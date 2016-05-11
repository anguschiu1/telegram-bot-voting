<?php

function processUser($message, $user){
    $chat_id = $message['chat']['id'];
    $userId = $message['from']['id'];
    $firstName = isset($message['from']['first_name'])?$message['from']['first_name']:'';
    $lastName = isset($message['from']['last_name'])?$message['from']['last_name']:'';
    $userName = isset($message['from']['username'])?$message['from']['username']:'';
    
    if(null == $user){
        $user = new User();
        $user->user_id = $userId;
        $user->user_name = $userName;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->chat_id = $chat_id;
        $user->authorized = 'N';
        $user->member_type = MemberType::L4;
        $user->stage = Stage::UNAUTHORIZED;
        $user->lang = 'tc';
    }
    else{
        $user->user_name = $userName;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->chat_id = $chat_id;
    }
    
    return $user;
}

function processLang($lang){
    
    if('en' === $lang ){
        $GLOBALS['WORD'] = $GLOBALS['WORD_EN'];
        $GLOBALS['ANSWER_KEYBOARD'] = $GLOBALS['ANSWER_KEYBOARD_EN'];
    }
    else{
        $GLOBALS['WORD'] = $GLOBALS['WORD_TC'];
        $GLOBALS['ANSWER_KEYBOARD'] = $GLOBALS['ANSWER_KEYBOARD_TC'];
    }
}

function processMessage($message) {
    // process incoming message
    $message_id = $message['message_id'];
    $chat_id = $message['chat']['id'];
    
    $userId = $message['from']['id'];
    
    if (isset($message['text'])) {
        // incoming text message
        $text = $message['text'];
        logDebug("Text is: $text\n");
        
        
        $user = UserDao::get($userId);        
        $question = QuestionDao::get($userId);

        if(null === $user || null === $question){
            $question = new Question();
            $question->round = CURRENT_ROUND_NUM;
        }
        
        $user = processUser($message, $user);
        $questionService = new QuestionService($user, $question);
        
        processLang($user->lang);
        
        print "Stage $user->stage<br>\n";
        switch($user->stage){
            case Stage::UNAUTHORIZED:
                handleStageUnauthorized($user, $text);
                break;
            case Stage::AUTHORIZED:
                handleStageAuthorized($user, $text);
                break;
            default:
                handleSurveyEnded($user, $text);
                break;
                /*
            case Stage::LANG:
                handleStageLang($user, $questionService, $text);
                break;
            case Stage::Q1:
                handleStageQ1($user, $questionService, $text);
                break;
            case Stage::Q2:
                handleStageQ2($user, $questionService, $text, $message_id);
                break;
            case Stage::Q2_CONFIRM:
                handleStageQ2Confirm($user, $questionService, $text, $message_id);
                break;
            case Stage::Q3:
                handleStageQ3($user, $questionService, $text);
                break;
            case Stage::Q4:
                handleStageQ4($user, $questionService, $text);
                break;
            case Stage::Q5:
                handleStageQ5($user, $questionService, $text);
                break;
            case Stage::Q6:
                handleStageQ6($user, $questionService, $text);
                break;
            case Stage::Q7:
                handleStageQ7($user, $questionService, $text);
                break;
            case Stage::Q8:
                handleStageQ8($user, $questionService, $text);
                break;
            case Stage::Q9:
                handleStageQ9($user, $questionService, $text);
                break;
            case Stage::Q10:
                handleStageQ10($user, $questionService, $text);
                break;
            case Stage::Q11:
                handleStageQ11($user, $questionService, $text);
                break;
            case Stage::Q12:
                handleStageQ12($user, $questionService, $text);
                break;
            case Stage::Q13:
                handleStageQ13($user, $questionService, $text);
                break;
            case Stage::Q14:
                handleStageQ14($user, $questionService, $text);
                break;
            case Stage::Q15:
                handleStageQ15($user, $questionService, $text);
                break;
            case Stage::RESTART:
                handleStageRestart($user, $questionService, $text, $message_id);
                break;
            case Stage::DELETED:
                handleStageDeleted($user, $questionService, $text);
                break;
            default:
                break;
                */
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



function formatInvitationMessage($invitation){
    return sprintf($GLOBALS['WORD']['INVITATION_LINK'], InvitationService::getFullLink($invitation));
}

?>