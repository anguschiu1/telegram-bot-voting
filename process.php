<?php


function processMessage($message) {
    // process incoming message
    $message_id = $message['message_id'];
    $chat_id = $message['chat']['id'];
    
    if (isset($message['text'])) {
        // incoming text message
        $text = $message['text'];
        logDebug("Text is: $text\n");
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

?>