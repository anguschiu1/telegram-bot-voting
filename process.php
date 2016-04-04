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
        }
        else{
            $question = getQuestion($userId);
        }
        
        
        if (strpos($text, "/start") === 0 || strpos($text, "/vote") === 0) {
            apiRequestJson("sendMessage", 
                array('chat_id' => $chat_id, "text" => 'Who do you vote?', 
                'reply_markup' => array('keyboard' => array(array('Vote 1', 'Vote 2'), array('Vote 3', 'Vote 4'), array('Vote 5', 'Vote 6')), 
                'one_time_keyboard' => true, 
                'resize_keyboard' => true)));
        } else if ($text === "Hello" || $text === "Hi") {
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
        } else if (strpos($text, "/stop") === 0) {
            // stop now, do nothing
        } else if (strpos($text, "Vote ") === 0) {
            addRecords($message['from']['id'], $message['from']['first_name'], str_replace('Vote ', '', $text));
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Voted.  Thanks. \n".
                "Use /result to display report.\n".
                "Use /vote to add a new vote."));
        } else if(strpos($text, '/in ') === 0){
            addQ1($message['from']['id'], $message['from']['first_name'], str_replace('Vote ', '', $text));
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Voted.  Thanks. \n".
                "Use /result to display report.\n".
                "Use /vote to add a new vote."));
        } else if (strpos($text, "/result") === 0) {
            $arr = getResult();
            $res = '';
            foreach($arr as $key => $val) {
                $res .= "Poll $key : $val\n";
            }
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $res));
        }  else if (in_array($text, $aryQ1)){
            addQ1($user, $question, $text);
        }  else if (array_key_exists($text, $aryQ2)){
            if(!addQ2($user, $question, $text)){
                //Ask Q1 again if no answer found
                print 'reply with q1';
            }
        } else if (null != $question && in_array($text, $aryQ2[$question['q2']])){
            print 'add Q3<br>';
            addQ3($user, $question, $text);
        } else {
            apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Cool'));
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
        global $aryQ2;
        $answer = $text;
        
        print "$answer\n";
        
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
        global $aryQ2;
        $answer = $text;
        
        print "$answer\n";
        
        if(null != $question){
            updateSingleQuestion($question, $user['user_id'], 3, $answer);
            $result = true;
        }
    }
    return $result;
}

?>