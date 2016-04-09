<?php

$aryParty = array(
'1' => '民主黨',
'2' => '公民黨',
'3' => '工黨',
'4' => '街工',
'5' => '民協',
'6' => '新民主同盟',
'7' => '社民連',
'8' => '人民力量',
'9' => '學民思潮',
'10' => '青年新政本民前',
'11' => '熱血公民',
'12' => '民建聯',
'13' => '工聯會',
'14' => '經民聯',
'15' => '新民黨鄉事派',
'16' => '自由黨',
'17' => '民主思路',
'18' => '新思維',
'19' => '其他',
'20' => '未決定'
);

$aryQ2 = array(
   '香港島' => $aryParty,
   '九龍東' => $aryParty,
   '九龍西' => $aryParty,
   '新界東' => $aryParty,
   '新界西' => $aryParty
);

$Q1Agree = '👌 同意';
$Q1Disagree = '🚫 No!';

$aryQ1 = array('Y' => $Q1Agree, 'N' => $Q1Disagree);


function processMessage($message) {
    // process incoming message
    $message_id = $message['message_id'];
    $chat_id = $message['chat']['id'];
    
    $userId = $message['from']['id'];
    $firstName = $message['from']['first_name'];
    $lastName = $message['from']['last_name'];
    $userName = $message['from']['username'];
    
    global $aryQ1;
    global $aryQ2;
    
    
    if (isset($message['text'])) {
        // incoming text message
        $text = $message['text'];
        logDebug("Text is: $text\n");
        
        
        $user = getUser($userId);
        
        if(null == $user){
            $user = createUser($userId, $userName, $firstName, $lastName, $chat_id);
            $question = null;
        }
        else{
            $user = updateUser($user, $userId, $userName, $firstName, $lastName, $chat_id);
            $question = getQuestion($userId);
        }
        
        
        if (strpos($text, "/start") === 0 || strpos($text, "/vote") === 0) {
            respondWithKeyboard($chat_id, '同意我們的使用條款?', array(array_values($aryQ1)));
        } else if ($text === "Hello" || $text === "Hi") {
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
        } else if (strpos($text, "/stop") === 0) {
            // stop now, do nothing
        } else if (strpos($text, "/result") === 0) {
            if(null == $question['q2']){
                respondWithQuote($chat_id, $message_id, "You have not yet voted. /start to start voting.");
            }
            else{
                respondPollingResult($chat_id, $question['q2']);
            }
        }  else if (in_array($text, $aryQ1)){
            if(addQ1($user, $question, $text)){
                if ($text == $aryQ1['Y']){
                    //reply with Q2
                    respondWithKeyboard($chat_id, '你的選民登記屬於那個選區？', array_chunk(array_keys($aryQ2), 3));
                }
                else{
                    //tell them not agree can't do anything
                    respondWithQuote($chat_id, $message_id, "We can do nothing if you do not agree.");
                }
            }
        }  else if (array_key_exists($text, $aryQ2)){
            if(!addQ2($user, $question, $text)){
                //Ask Q1 again if no answer found
            }
            else{
                $q2Key = array_keys($aryQ2);
                $q2 = $q2Key[$question['q2']];
                
                $option = $aryQ2[$text];
                shuffle($option);
                respondWithKeyboard($chat_id, '2016 年立會選舉你`現時`傾向投給'.$q2.'中的哪個政黨？', array_chunk($option, 3));
            }
        } else {
            if (null != $question && null != $question['q2']){
                $q2 = $question['q2'];
                $q2Key = array_keys($aryQ2);
                
                if(in_array($text, $aryQ2[$q2Key[$q2]])){
                    if(addQ3($user, $question, array_search($text, $aryQ2[$q2Key[$q2]]))){
                        respondWithQuote($chat_id, $message_id, '多謝投票。');
                        respondPollingResult($chat_id, $q2);
                        respondWithMessage($chat_id, '請於下個月再投票，到時我們會再提醒你，謝謝');
                    }
                }
                else{
                    respondInvalidRequest($chat_id, $message_id);
                }
            } 
            else {
                respondInvalidRequest($chat_id, $message_id);
            }
        }
    } else {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
    }
}

function respondPollingResult($chat_id, $q2Index){
    global $aryQ2;
    
    $result = getResult($q2Index);
    
    $q2Key = array_keys($aryQ2);
    $q2Array = $aryQ2[$q2Key[$q2Index]];
    
    $total = array_sum($result);
    
    $res = '「`'. $q2Key[$q2Index]."`」 選區的結果 (共 $total 票)：\n\n";
    
    arsort($result);
    $row = 0;
    foreach($result as $key => $val) {
        $res .= $q2Array[$key].": $val\n";
        $count = ($val/$total * 10);
        
        for($i=0; $i < $count; $i++){
            $res .= '✅';
        }
        $res .= ' *'.floor($count * 10)."%*\n\n";
        $row++;
        if($row == 5){
            $res .= '還有其他 ';
            break;
        }
    }
    $res .= '([詳細的結果](http://civic-data.hk/result-graph/))';
    $res .= "\n如要更改你的投票，請使用 /start 重新開始";
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $res, 'parse_mode' => 'Markdown'));
}

function respondWithMessage($chat_id, $message){
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $message, 'parse_mode' => 'Markdown'));
}

function respondInvalidRequest($chat_id, $message_id){
    respondWithQuote($chat_id, $message_id, 'Cool.  But I do not understand.');
}

function respondWithQuote($chat_id, $message_id, $message){
    apiRequestJson("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $message));
}

function respondWithKeyboard($chat_id, $message, $keyboardOptions){
    apiRequestJson("sendMessage", 
                array('chat_id' => $chat_id, 
                "text" => $message, 
                'parse_mode' => 'Markdown', 
                'reply_markup' => array('keyboard' => $keyboardOptions, 
                                        'one_time_keyboard' => true, 
                                        'resize_keyboard' => true))
                      );
}

function logDebug($msg) {
    if (DEBUG) {
        file_put_contents(DEBUG_FILE_NAME, $msg."\n", FILE_APPEND | LOCK_EX);
    }
}

function addQ1($user, $question, $text){
    $result = false;
    
    if(null != $user){
        global $aryQ1;
        
        $answer = array_search($text, $aryQ1);
        
        if(null != $question){
            updateSingleQuestion($question, $user['user_id'], 1, $answer);
        }
        else{
            createQuestion($user['user_id'], $answer, null, null);
        }
        $result = true;
    }
    return $result;
}


function addQ2($user, $question, $text){
    $result = false;
    
    if(null != $user){
        global $aryQ2;
        $answer = array_search($text, array_keys($aryQ2));
        
        if(null != $question){
            updateSingleQuestion($question, $user['user_id'], 2, $answer);
            $result = true;
        }
    }
    return $result;
}




function addQ3($user, $question, $text){
    $result = false;
    
    if(null != $user){
        $answer = $text;
        
        if(null != $question){
            updateSingleQuestion($question, $user['user_id'], 3, $answer);
            $result = true;
        }
    }
    return $result;
}

?>