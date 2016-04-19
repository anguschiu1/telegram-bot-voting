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
    }
    else{
        $user->user_name = $userName;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->chat_id = $chat_id;
    }
    
    return $user;
}

function processMessage($message) {
    // process incoming message
    $message_id = $message['message_id'];
    $chat_id = $message['chat']['id'];
    
    $userId = $message['from']['id'];
    
    global $aryQ1;
    global $aryQ2;
    
    
    if (isset($message['text'])) {
        // incoming text message
        $text = $message['text'];
        logDebug("Text is: $text\n");
        
        
        $user = UserDao::get($userId);
        
        if(null == $user){
            $question = null;
        }
        else{
            $question = QuestionDao::get($userId);
        }
        
        $user = processUser($message, $user);
        
        
        if (strpos($text, "/start") === 0) {
            commandStart($user, $text, $chat_id);
        } else if ($text === "Hello" || $text === "Hi") {
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
        } else if (strpos($text, "/invite new") === 0 && MemberType::canCreateMutli($user->member_type)) {
            $invitationService = new InvitationService($user);
            if($invitationService->canGenerate()){
                $invitationService->createInvitation($user->member_type);
                $invitation = $invitationService->getInvitation();
                respondWithMessage($chat_id, formatInvitationMessage($invitation));
            }
            else{
                respondWithMessage($chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
            }
        } else if (strpos($text, "/invite c") === 0 && MemberType::canCreateMutli($user->member_type)) {
            $invitationService = new InvitationService($user);
            if($invitationService->canGenerate()){
                $invitationService->createInvitation(MemberType::CELEBRITIES);
                $invitation = $invitationService->getInvitation();
                respondWithMessage($chat_id, formatInvitationMessage($invitation));
            }
            else{
                respondWithMessage($chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
            }
        } else if (strpos($text, "/invite") === 0) {
            $invitationService = new InvitationService($user);
            
            
            if($invitationService->hasGenerated()){
                $invitation = $invitationService->getInvitation();
                respondWithMessage($chat_id, $GLOBALS['WORD']['INVITE_ALREAY_GENERATED'].formatInvitationMessage($invitation));
            }
            else{
                if($invitationService->canGenerate()){
                    $invitation = $invitationService->getInvitation();
                    respondWithMessage($chat_id, formatInvitationMessage($invitation));
                }
                else{
                    respondWithMessage($chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
                }
            }
        } else if (strpos($text, "/stop") === 0) {
            // stop now, do nothing
        } else if (strpos($text, "/result") === 0) {
            if(null == $question->q2){
                respondWithQuote($chat_id, $message_id, $GLOBALS['WORD']['SURVEY_NOT_START']);
            }
            else{
                respondPollingResult($chat_id, $question->q2);
            }
        }  else if (in_array($text, $aryQ1)){
            if(addQ1($user, $question, $text)){
                if ($text == $aryQ1['Y']){
                    //reply with Q2
                    respondWithKeyboard($chat_id, $GLOBALS['WORD']['SURVEY_Q1'], array_chunk(array_keys($aryQ2), 3));
                }
                else{
                    //tell them not agree can't do anything
                    respondWithQuote($chat_id, $message_id, $GLOBALS['WORD']['SURVEY_Q1_NOT_AGREE']);
                }
            }
        }  else if (array_key_exists($text, $aryQ2)){
            if(!addQ2($user, $question, $text)){
                //Ask Q1 again if no answer found
            }
            else{
                $q2Key = array_keys($aryQ2);
                $q2 = $q2Key[$question->q2];
                
                $option = $aryQ2[$text];
                shuffle($option);
                respondWithKeyboard($chat_id, sprintf($GLOBALS['WORD']['SURVEY_Q2'], $q2), array_chunk($option, 3));
            }
        } else {
            if (null != $question && null != $question->q2){
                $q2 = $question->q2;
                $q2Key = array_keys($aryQ2);
                
                if(in_array($text, $aryQ2[$q2Key[$q2]])){
                    if(addQ3($user, $question, array_search($text, $aryQ2[$q2Key[$q2]]))){
                        respondWithQuote($chat_id, $message_id, $GLOBALS['WORD']['SURVEY_THANKS']);
                        respondPollingResult($chat_id, $q2);
                        respondWithMessage($chat_id, $GLOBALS['WORD']['SURVEY_THANKS_REMIND']);
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
        
        $user = UserDao::save($user);
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
    
    $res = sprintf($GLOBALS['WORD']['SURVEY_RESULT'], $q2Key[$q2Index], $total);
    
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
            $res .= $GLOBALS['WORD']['SURVEY_RESULT_MORE'];
            break;
        }
    }
    $res .= $GLOBALS['WORD']['SURVEY_RESULT_LINK'];
    $res .= $GLOBALS['WORD']['SURVEY_RESULT_RESTART_INSTRUCTION'];
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $res, 'parse_mode' => 'Markdown'));
}

function respondWithMessage($chat_id, $message){
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $message, 'parse_mode' => 'Markdown'));
    print "API: $message.<BR>\n";
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



function formatInvitationMessage($invitation){
    $url = INVITATION_LINK_PREFIX.$invitation->link;
    
    return sprintf($GLOBALS['WORD']['INVITATION_LINK'], $url, $invitation->quota);
}

function respondWelcomeMessage($chat_id){
    global $aryQ1;
    respondWithKeyboard($chat_id, $GLOBALS['WORD']['WELCOME'], array(array_values($aryQ1)));
}

function respondNotAuthorized($chat_id){
    respondWithMessage($chat_id, 'Not authorized');
}

function commandStart($user, $text, $chat_id){
    if('Y' === $user->authorized){
        respondWelcomeMessage($chat_id);
    }
    else{
        $args = explode(' ', $text);
        if (count($args) > 1){
            $invitation = InvitationDao::getByLink($args[1]);
            if(null != $invitation){
                $user->authorized = 'Y';
                $user->member_type = $invitation->member_type;
                $user->stage = Stage::AUTHORIZED;
                
                $user = UserDao::save($user);
                
                $invitation->useQuota();
                
                $invitationUser = new InvitationUser();
                $invitationUser->invitation_id = $invitation->id;
                $invitationUser->user_id = $user->user_id;
                
                InvitationDao::save($invitation);
                InvitationUserDao::save($invitationUser);
                
                respondWelcomeMessage($chat_id);
            }
            else{
                respondNotAuthorized($chat_id);
            }
        }
        else{
            respondNotAuthorized($chat_id);
        }
    }    
}
?>