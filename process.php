<?php


$aryQ2 = array(
   '1. 香港島' => array('島名單 1', '島名單 2', '島名單 3', '島名單 4', '島名單 5', '島名單 6', '島名單 7', '島名單 8', '島名單 9', '島名單 10', '島名單 11', '島名單 12', '島名單 13', '島名單 14'),
   '2. 九龍東' => array('九龍 1', '九龍2', '九龍 3', '九龍 4', '九龍 5', '九龍 6', '九龍 7', '九龍 8', '九龍 9'),
   '3. 九龍西' => array('名單西 1', '名單西 2', '名單西 3', '名單西 4', '名單西 5', '名單西 6', '名單西 7', '名單西 8', '名單西 9'),
   '4. 新界東' => array('新界東 1', '新界東 2', '新界東 3', '新界東 4', '新界東 5', '新界東 6', '新界東 7', '新界東 8', '新界東 9', '新界東 10', '新界東 11', '新界東 12', '新界東 13', '新界東 14', '新界東 15', '新界東 16'),
   '5. 新界西' => array('新界西 1', '新界西 2', '新界西 3', '新界西 4', '新界西 5', '新界西 6', '新界西 7', '新界西 8', '新界西 9', '新界西 10', '新界西 11', '新界西 12', '新界西 13', '新界西 14', '新界西 15', '新界西 16', '新界西 17', '新界西 18', '新界西 19')
);

$Q1Agree = '👌 Agree';
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
            $user = createUser($userId, $userName, $firstName, $lastName);
            $question = null;
        }
        else{
            $user = updateUser($user, $userId, $userName, $firstName, $lastName);
            $question = getQuestion($userId);
        }
        
        
        if (strpos($text, "/start") === 0 || strpos($text, "/vote") === 0) {
            apiRequestJson("sendMessage", 
                    array('chat_id' => $chat_id, 
                    "text" => '同意我們的使用條款? ', 
                    'reply_markup' => array('keyboard' => array(array_values($aryQ1)), 
                                            'one_time_keyboard' => true, 
                                            'resize_keyboard' => true))
                          );
        } else if ($text === "Hello" || $text === "Hi") {
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
        } else if (strpos($text, "/stop") === 0) {
            // stop now, do nothing
        } else if (strpos($text, "/result") === 0) {
            if(null == $question['q2']){
                apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => "You have not yet voted."));
            }
            else{
                $arr = getResult($question['q2']);
                $res = '*「'. $question['q2']."*」 選區的結果：\n\n";
                foreach($arr as $key => $val) {
                    $res .= "*$key* : $val\n";
                }
                $res .= "\n".'[詳細的結果](http://civic-data.hk/result-graph/)';
                $res .= "\n如要更改你的投票，請使用 /start 重新開始";
                apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $res, 'parse_mode' => 'Markdown'));
            }
        }  else if (in_array($text, $aryQ1)){
            if(addQ1($user, $question, $text)){
                if ($text == $aryQ1['Y']){
                    //reply with Q2
                    apiRequestJson("sendMessage", 
                            array('chat_id' => $chat_id, 
                            "text" => 'Q2: 那一區?', 
                            'reply_markup' => array('keyboard' => array_chunk(array_keys($aryQ2), 2), 
                                                    'one_time_keyboard' => true, 
                                                    'resize_keyboard' => true))
                                  );
                }
                else{
                    //tell them not agree can't do anything
                    apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => "We can do nothing if you do not agree."));
                }
            }
        }  else if (array_key_exists($text, $aryQ2)){
            if(!addQ2($user, $question, $text)){
                //Ask Q1 again if no answer found
            }
            else{
                $option = $aryQ2[$text];
                apiRequestJson("sendMessage", 
                            array('chat_id' => $chat_id, 
                            "text" => 'Q3: 名單是?', 
                            'reply_markup' => array('keyboard' => array_chunk($option, 2), 
                                                    'one_time_keyboard' => true, 
                                                    'resize_keyboard' => true))
                                  );
            }
        } else if (null != $question && in_array($text, $aryQ2[$question['q2']])){
            if(addQ3($user, $question, $text)){
                apiRequest("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Thanks'));
            }
        } else {
            apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Cool.  But I do not understand.'));
        }
    } else {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
    }
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
        $answer = $text;
        
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