<?php

function respondPollingResult($chat_id, $districtIndex){
    $result = getResult($districtIndex);
    
    $total = array_sum($result);
    
    $district = $GLOBALS['ANSWER_KEYBOARD']['Q2'][$districtIndex];
    $partyArray = $GLOBALS['ANSWER_KEYBOARD']['Q3'][$districtIndex];
    
    $res = sprintf($GLOBALS['WORD']['SURVEY_RESULT'], $district, $total);
    
    arsort($result);
    $row = 0;
    foreach($result as $key => $val) {
        $res .= $partyArray[$key].": $val\n";
        $count = ($val/$total * 10);
        
        for($i=0; $i < $count; $i++){
            $res .= '✅';
        }
        $res .= ' *'.floor($count * 10)."%*\n\n";
        $row++;
        if($row == 5){
            $res .= $GLOBALS['WORD']['SURVEY_RESULT_MORE'];
            break;
        }
    }
    $res .= $GLOBALS['WORD']['SURVEY_RESULT_LINK'];
    $res .= $GLOBALS['WORD']['SURVEY_RESULT_RESTART_INSTRUCTION'];
    respondWithMessage($chat_id, $res);
}

function respondWithMessage($chat_id, $message){
    apiRequestJson("sendMessage", array('chat_id' => $chat_id, "text" => $message, 'parse_mode' => 'Markdown', 'reply_markup' => array('hide_keyboard' => true)));
    print "API: $message.<BR>\n";
}

function respondInvalidRequest($chat_id, $message_id){
    respondWithQuote($chat_id, $message_id, 'Cool.  But I do not understand.');
}

function respondWithQuote($chat_id, $message_id, $message){
    apiRequestJson("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $message));
}

function respondWithKeyboard($chat_id, $message, $keyboardOptions){
    print "API Keyboard: $message.<BR>\n";
    print_r($keyboardOptions);
    apiRequestJson("sendMessage", 
                array('chat_id' => $chat_id, 
                "text" => $message, 
                'parse_mode' => 'Markdown', 
                'reply_markup' => array('keyboard' => $keyboardOptions, 
                                        'one_time_keyboard' => true, 
                                        'resize_keyboard' => true))
                      );
}

function respondWelcomeMessage($chat_id){
    respondWithMessage($chat_id, $GLOBALS['WORD']['WELCOME']);
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['WELCOME_CHOOSE_LANGUAGE'], array_chunk($GLOBALS['ANSWER_KEYBOARD']['WELCOME_LANGUAGE'], 2));
}

function respondTermsAgree($chat_id){
    respondWithMessage($chat_id, $GLOBALS['WORD']['WELCOME_TERMS']);
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['WELCOME_TERMS_AGREE'], array(array_values($GLOBALS['ANSWER_KEYBOARD']['Q1'])));
}

function respondNotAuthorized($chat_id){
    respondWithMessage($chat_id, $GLOBALS['WORD']['NOT_AUTHORIZED']);
}

function respondLinkQuotaUsedUp($chat_id){
    respondWithMessage($chat_id, $GLOBALS['WORD']['LINK_QUOTA_USED_UP']);
}

function respondQ1($chat_id){
    //which district?
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['SURVEY_Q1'], array_chunk($GLOBALS['ANSWER_KEYBOARD']['Q2'], 3));
}

function respondQ2($chat_id, $question){
    //which party?
    $district = $GLOBALS['ANSWER_KEYBOARD']['Q2'][$question->q2];
    
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q3'][$question->q2];
    shuffle($option);
    respondWithKeyboard($chat_id, sprintf($GLOBALS['WORD']['SURVEY_Q2'], $district), array_chunk($option, 1));
}

function respondQ2Confirm($chat_id, $choice){
    respondWithKeyboard($chat_id, sprintf($GLOBALS['WORD']['SURVEY_Q2_CONFIRM'], $choice), array($GLOBALS['ANSWER_KEYBOARD']['Q2_CONFIRM']));
}

?>