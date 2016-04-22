<?php
function handleInvitationUsedNotification($user, $invitation){
    $originalUser = UserDao::get($invitation->create_user_id);
    respondWithMessage($originalUser->chat_id, 
        sprintf($GLOBALS['WORD']['INVITATION_LINK_USED_NOTIFICATION'], $user->getName(), InvitationService::getFullLink($invitation), $invitation->quota));
}

function handleStageUnauthorized($user, $text){
    //authorize the user
    $args = explode(' ', $text);
    if(strpos($text, "/start") !== 0){
        respondNotAuthorized($user->chat_id);
    }
    else{
        if (count($args) > 1){
            $invitation = InvitationDao::getByLink($args[1]);
            if(null != $invitation){
                $invitationUser = $invitation->useQuota($user);
                
                UserDao::save($user);
                InvitationDao::save($invitation);
                InvitationUserDao::save($invitationUser);
                
                respondWelcomeMessage($user->chat_id);
                handleInvitationUsedNotification($user, $invitation);
            }
            else{
                respondNotAuthorized($user->chat_id);
            }
        }
        else{
            respondNotAuthorized($user->chat_id);
        }
    }
}

function handleStageAuthorized($user, $questionService, $text){
    $aryAgreeText = array('agree', 'ok', 'yes', $GLOBALS['ANSWER_KEYBOARD']['Q1_AGREE']);
    $aryDisagreeText = array('not agree', 'no', 'nope', $GLOBALS['ANSWER_KEYBOARD']['Q1_DISAGREE']);
    
    if(in_array($text, $aryAgreeText)){
        if($user->changeStageToQ1()){
            if($questionService->addQ1(ANSWER_YES)){
                respondQ1($user->chat_id);
                UserDao::save($user);
            }
        }
    }
    else if(in_array($text, $aryDisagreeText)){
        if($questionService->addQ1(ANSWER_NO)){
            //tell them not agree can't do anything
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_Q1_NOT_AGREE']);
            respondWelcomeMessage($user->chat_id);   
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondWelcomeMessage($user->chat_id);   
    }
}

function handleStageQ1($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q2']);
    print 'key: ' . $key;
    if (false !== $key){
        if($user->changeStageToQ2()){
            if($questionService->addQ2($key)){
                respondQ2($user->chat_id, $questionService->question);
                
                UserDao::save($user);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ1($user->chat_id);
    }
}

function handleStageQ2($user, $questionService, $text, $message_id){
    $districtKey = $questionService->question->q2;
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q3'][$districtKey]);
    
    if($key){
        if($user->changeStageToQ2Confirm()){
            if($questionService->addQ3($key)){
                respondQ2Confirm($user->chat_id, $text);
                UserDao::save($user);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ2($user->chat_id, $questionService->question);
    }
}

function handleStageQ2Confirm($user, $questionService, $text, $message_id){
    $aryAgreeText = array('confirm', 'ok', $GLOBALS['ANSWER_KEYBOARD']['Q2_CONFIRM_YES']);
    $aryDisagreeText = array('no', 'nope', $GLOBALS['ANSWER_KEYBOARD']['Q2_CONFIRM_NO']);
    
    if(in_array($text, $aryAgreeText)){
        if($user->changeStageToQ3()){
            UserDao::save($user); //save user first, for calculate the result correctly
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_THANKS']);
            respondPollingResult($user->chat_id, $questionService->question->q2);
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_THANKS_REMIND']);
            

            $invitationService = new InvitationService($user);
            
            if(!$invitationService->hasGenerated() && $invitationService->canGenerate()){
                $invitation = $invitationService->getInvitation();
                respondWithMessage($user->chat_id, sprintf($GLOBALS['WORD']['INVITATION_MSG'], $invitation->quota));
                respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
            }
        }
    }
    else if(in_array($text, $aryDisagreeText)){
        if($user->changeStageToQ2()){
            respondQ2($user->chat_id, $questionService->question);
            UserDao::save($user);
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        $partyArray = $GLOBALS['ANSWER_KEYBOARD']['Q3'][$questionService->question->q2];
        respondQ2Confirm($user->chat_id, $partyArray[$questionService->question->q3]);
    }
}
function handleStageQ3($user, $questionService, $text){
    $ary = array('/vote');
    if(in_array($text, $ary)){
        if($user->changeStageToRestart()){
            respondQ2($user->chat_id, $questionService->question);
            UserDao::save($user);
        }
    }
    else if(handleShowResult($user, $questionService->question, $text)){
        
    }
    else if(handleInvite($user, $text)){
        
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['ALREADY_VOTE']);
    }
}

function handleStageRestart($user, $questionService, $text, $message_id){
    handleStageQ2($user, $questionService, $text, $message_id);
}

function handleStageDeleted($user, $questionService, $text){
}

function handleShowResult($user, $question, $text){
    $aryResult = array('/result', 'show result');
    if(in_array($text, $aryResult)){
        if(null === $question->q2){
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_NOT_START']);
        }
        else{
            respondPollingResult($user->chat_id, $question->q2);
        }
        return true;
    }
    return false;
}

function handleInvite($user , $text){
    $ret = false;
    if (strpos($text, "/invite new") === 0 && MemberType::canCreateMutli($user->member_type)) {
        $invitationService = new InvitationService($user);
        if($invitationService->canGenerate()){
            $invitationService->createInvitation($user->member_type);
            $invitation = $invitationService->getInvitation();
            respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
        }
        else{
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
        }
        $ret = true;
    } else if (strpos($text, "/invite c") === 0 && MemberType::canCreateMutli($user->member_type)) {
        $invitationService = new InvitationService($user);
        if($invitationService->canGenerate()){
            $invitationService->createInvitation(MemberType::CELEBRITIES);
            $invitation = $invitationService->getInvitation();
            respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
        }
        else{
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
        }
        $ret = true;
    } else if (strpos($text, "/invite") === 0) {
        $invitationService = new InvitationService($user);
        
        
        if($invitationService->hasGenerated()){
            $invitation = $invitationService->getInvitation();
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVITE_ALREAY_GENERATED'].formatInvitationMessage($invitation));
        }
        else{
            if($invitationService->canGenerate()){
                $invitation = $invitationService->getInvitation();
                respondWithMessage($user->chat_id, sprintf($GLOBALS['WORD']['INVITATION_MSG'], $invitation->quota));
                respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
            }
            else{
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVITE_NO_PRIVILEGE']);
            }
        }
        $ret = true;
    } 
    return $ret;
}

?>