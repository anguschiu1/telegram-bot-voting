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

function respondQ2($chat_id){
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['SURVEY_Q2'], array_chunk($GLOBALS['ANSWER_KEYBOARD']['Q2'], 3));
}


function respondQ3($chat_id){
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['SURVEY_Q3'], array_chunk($GLOBALS['ANSWER_KEYBOARD']['Q3'], 3));
}


function respondQ4($chat_id){
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['SURVEY_Q4'], array_chunk($GLOBALS['ANSWER_KEYBOARD']['Q4'], 3));
}

function respondQ5($chat_id, $questionObj){
    //which party?
    $district = $GLOBALS['ANSWER_KEYBOARD']['Q4'][$questionObj->q2];
    
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q5'][$questionObj->q2];
    shuffle($option);
    respondWithKeyboard($chat_id, sprintf($GLOBALS['WORD']['SURVEY_Q5'], $district), array_chunk($option, 1));
}

function respondQ3Confirm($chat_id, $choice){
    respondWithKeyboard($chat_id, sprintf($GLOBALS['WORD']['SURVEY_Q2_CONFIRM'], $choice), array($GLOBALS['ANSWER_KEYBOARD']['Q2_CONFIRM']));
}

function respondQ6($chat_id, $questionObj){
    $name = $GLOBALS['ANSWER_KEYBOARD']['Q5'][$questionObj->q2][$questionObj->q5];

    $question = sprintf($GLOBALS['WORD']['SURVEY_Q6'], $name);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q6'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 2));
}

function respondQ7($chat_id, $questionObj){
    $question = $GLOBALS['WORD']['SURVEY_Q7'];
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q7'][$questionObj->q2];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 1));
}


function respondQ8($chat_id, $questionObj){
    $districtKey = $questionObj->q2;
    $q3answer = $GLOBALS['ANSWER_KEYBOARD']['Q5'][$districtKey][$questionObj->q5];
    $q4answer = $GLOBALS['ANSWER_KEYBOARD']['Q6'][$questionObj->q6];
    $q5answer = $GLOBALS['ANSWER_KEYBOARD']['Q7'][$districtKey][$questionObj->q7];

    $question = sprintf($GLOBALS['WORD']['SURVEY_Q8'], $q3answer, $q4answer, $q5answer);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q8'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 2));
}


function respondQ9($chat_id, $questionObj){
    $districtKey = $questionObj->q2;
    $question = $GLOBALS['WORD']['SURVEY_Q9'];
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q9'][$districtKey];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 1));
}


function respondQ10($chat_id, $questionObj){
    $districtKey = $questionObj->q2;
    $name = $GLOBALS['ANSWER_KEYBOARD']['Q9'][$districtKey][$questionObj->q9];

    $question = sprintf($GLOBALS['WORD']['SURVEY_Q10'], $name);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q10'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 2));
}


function respondQ11($chat_id, $questionObj){
    $districtKey = $questionObj->q2;
    $question = $GLOBALS['WORD']['SURVEY_Q11'];
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q11'][$districtKey];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 1));
}


function respondQ12($chat_id, $questionObj){
    $districtKey = $questionObj->q2;
    $q7answer = $GLOBALS['ANSWER_KEYBOARD']['Q9'][$districtKey][$questionObj->q9];
    $q8answer = $GLOBALS['ANSWER_KEYBOARD']['Q10'][$questionObj->q10];
    $q9answer = $GLOBALS['ANSWER_KEYBOARD']['Q11'][$districtKey][$questionObj->q11];

    $question = sprintf($GLOBALS['WORD']['SURVEY_Q12'], $q7answer, $q8answer, $q9answer);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q12'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 2));
}

function respondQ13($chat_id, $questionObj){
    $question = sprintf($GLOBALS['WORD']['SURVEY_Q13'], $name);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q13'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 3));
}

function respondQ14($chat_id, $questionObj){
    $question = sprintf($GLOBALS['WORD']['SURVEY_Q14'], $name);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q14'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 1));
}


function respondQ15($chat_id, $questionObj){
    $question = sprintf($GLOBALS['WORD']['SURVEY_Q15'], $name);
    $keyboard = $GLOBALS['ANSWER_KEYBOARD']['Q15'];

    respondWithKeyboard($chat_id, $question, array_chunk($keyboard, 1));
}


?>