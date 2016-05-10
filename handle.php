<?php
function handleInvitationUsedNotification($user, $invitation){
    $originalUser = UserDao::get($invitation->create_user_id);
    if(null !== $originalUser){
        respondWithMessage($originalUser->chat_id, 
            sprintf($GLOBALS['WORD']['INVITATION_LINK_USED_NOTIFICATION'], $user->getName(), InvitationService::getFullLink($invitation), $invitation->quota));
    }
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
            if(null !== $invitation){
                if($invitation->quota > 0){
                    $invitationUser = $invitation->useQuota($user);
                    
                    UserDao::save($user);
                    InvitationDao::save($invitation);
                    InvitationUserDao::save($invitationUser);
                    
                    respondWelcomeMessage($user->chat_id);
                    handleInvitationUsedNotification($user, $invitation);
                }
                else{
                    UserDao::save($user);
                    respondLinkQuotaUsedUp($user->chat_id);
                }
            }
            else{
                UserDao::save($user);
                respondNotAuthorized($user->chat_id);
            }
        }
        else{
            UserDao::save($user);
            respondNotAuthorized($user->chat_id);
        }
    }
}

function handleStageAuthorized($user, $questionService, $text){
    $aryAgreeText = array($GLOBALS['ANSWER_KEYBOARD']['WELCOME_LANGUAGE'][0]);
    $aryDisagreeText = array($GLOBALS['ANSWER_KEYBOARD']['WELCOME_LANGUAGE'][1]);
    
    if($user->changeStageToLang()){
        $lang = '';
        if(in_array($text, $aryAgreeText)){
            $lang = 'tc';
        }
        else if(in_array($text, $aryDisagreeText)){
            $lang = 'en';
        }

        if('' === $lang){
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
            respondWelcomeMessage($user->chat_id);
        }
        else{
            $user->lang = $lang;
            UserDao::save($user);
            processLang($lang);
            respondTermsAgree($user->chat_id);
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondWelcomeMessage($user->chat_id);   
    }
}

function handleStageLang($user, $questionService, $text){
    $aryAgreeText = array('agree', 'ok', 'yes', $GLOBALS['ANSWER_KEYBOARD']['Q1_AGREE']);
    $aryDisagreeText = array('not agree', 'no', 'nope', $GLOBALS['ANSWER_KEYBOARD']['Q1_DISAGREE']);
    
    if(in_array($text, $aryAgreeText)){
        if($user->changeStageToQ1()){
            if($questionService->addQ1(ANSWER_YES)){
                respondQ2($user->chat_id);
                UserDao::save($user);
            }
        }
    }
    else if(in_array($text, $aryDisagreeText)){
        if($questionService->addQ1(ANSWER_NO)){
            //tell them not agree can't do anything
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_Q1_NOT_AGREE']);
            respondTermsAgree($user->chat_id);   
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondTermsAgree($user->chat_id);   
    }
}

function handleStageQ1($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q2']);
    if (false !== $key){
        if($user->changeStageToQ2()){
            $user->voter2012 = $key;
            if($questionService->addQ2($key)){
                $user = UserDao::save($user);
                respondQ3($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ2($user->chat_id);
    }
}

function handleStageQ2($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q3']);
    if (false !== $key){
        if($user->changeStageToQ3()){
            $user->is_voter = $key;
            if($questionService->addQ3($key)){
                UserDao::save($user);
                respondQ4($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ3($user->chat_id);
    }
}

function handleStageQ3($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q4']);
    if (false !== $key){
        if($user->changeStageToQ4()){
            if($questionService->addQ4($key)){
                UserDao::save($user);
                respondQ5($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ4($user->chat_id);
    }
}

function handleStageQ4($user, $questionService, $text){
    $districtKey = $questionService->question->q4;
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q5'][$districtKey];
    array_push($option, $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE']);
    $key = array_search($text, $option);
    
    if(false !== $key){
        if($user->changeStageToQ5()){
            if($questionService->addQ5($key)){
                if($text === $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE']){
                    $questionService->addQ6(null);
                    $user->changeStageToQ6();
                    UserDao::save($user);
                    respondQ7($user->chat_id, $questionService->question);
                }
                else{
                    UserDao::save($user);
                    respondQ6($user->chat_id, $questionService->question);
                }
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ5($user->chat_id, $questionService->question);
    }
}

function handleStageQ5($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q6']);

    if(false !== $key){
        if($user->changeStageToQ6()){
            if($questionService->addQ6($key)){
                UserDao::save($user);
                respondQ7($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ6($user->chat_id, $questionService->question);
    }
}

function handleStageQ6($user, $questionService, $text){
    $districtKey = $questionService->question->q4;
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q7'][$districtKey];
    array_push($option, $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE'], $GLOBALS['ANSWER_KEYBOARD']['PARTY_NO_SECOND_CHOICE']);
    $key = array_search($text, $option);
    
    if(false !== $key){
        if($user->changeStageToQ7()){
            if($questionService->addQ7($key)){
                UserDao::save($user);
                respondQ8($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ7($user->chat_id, $questionService->question);
    }
}

function handleStageQ7($user, $questionService, $text){
    $aryAgreeText = array('agree', 'ok', 'yes', $GLOBALS['ANSWER_KEYBOARD']['Q8'][0]);
    $aryDisagreeText = array('not agree', 'no', 'nope', $GLOBALS['ANSWER_KEYBOARD']['Q8'][1]);
    
    if(in_array($text, $aryAgreeText)){
        if($user->changeStageToQ8()){
            if($questionService->addQ8(ANSWER_YES)){
                UserDao::save($user);
                respondQ9($user->chat_id, $questionService->question);
            }
        }
    }
    else if(in_array($text, $aryDisagreeText)){
        if($user->changeStageToQ4()){
            UserDao::save($user);
            respondQ5($user->chat_id, $questionService->question);
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ8($user->chat_id, $questionService->question);
    }
}

function handleStageQ8($user, $questionService, $text){
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q9'];
    array_push($option, $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE']);
    $key = array_search($text, $option);
    
    if(false !== $key){
        if($user->changeStageToQ9()){
            if($questionService->addQ9($key)){
                if($text === $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE']){
                    $questionService->addQ10(null);
                    if($user->changeStageToQ10()){
                        UserDao::save($user);
                        print ' SKIP '.$user->stage;
                        respondQ11($user->chat_id, $questionService->question);
                    }
                }
                else{
                    UserDao::save($user);
                    respondQ10($user->chat_id, $questionService->question);
                }
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ9($user->chat_id, $questionService->question);
    }
}

function handleStageQ9($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q10']);
    
    if(false !== $key){
        if($user->changeStageToQ10()){
            if($questionService->addQ10($key)){
                UserDao::save($user);
                respondQ11($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ10($user->chat_id, $questionService->question);
    }
}

function handleStageQ10($user, $questionService, $text){
    $option = $GLOBALS['ANSWER_KEYBOARD']['Q11'];
    array_push($option, $GLOBALS['ANSWER_KEYBOARD']['PARTY_NOT_YET_DECIDE'], $GLOBALS['ANSWER_KEYBOARD']['PARTY_NO_SECOND_CHOICE']);
    $key = array_search($text, $option);
    
    if(false !== $key){
        if($user->changeStageToQ11()){
            if($questionService->addQ11($key)){
                UserDao::save($user);
                respondQ12($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ11($user->chat_id, $questionService->question);
    }
}

function handleStageQ11($user, $questionService, $text){
    $aryAgreeText = array('agree', 'ok', 'yes', $GLOBALS['ANSWER_KEYBOARD']['Q12'][0]);
    $aryDisagreeText = array('not agree', 'no', 'nope', $GLOBALS['ANSWER_KEYBOARD']['Q12'][1]);


    if(in_array($text, $aryAgreeText)){
        if($user->changeStageToQ12()){
            if($questionService->addQ12(ANSWER_YES)){
                UserDao::save($user);
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_THANKS']);
                respondPollingResult($user->chat_id, $questionService->question);

                respondQ13($user->chat_id, $questionService->question);
            }
        }
    }
    else if(in_array($text, $aryDisagreeText)){
        if($user->changeStageToQ8()){
            UserDao::save($user);
            respondQ9($user->chat_id, $questionService->question);
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ12($user->chat_id, $questionService->question);
    }
}

function handleStageQ12($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q13']);
    
    if(false !== $key || Func::isValidAge($text)) {
        if($user->changeStageToQ13()){
            $age = (false !== $key)?$GLOBALS['ANSWER_KEYBOARD']['Q13'][$key]:$text;
            $user->age = $age;
            if($questionService->addQ13($age)){
                UserDao::save($user);
                respondQ14($user->chat_id, $questionService->question);
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ13($user->chat_id, $questionService->question);
    }
}

function handleStageQ13($user, $questionService, $text){
    $key = array_search($text, $GLOBALS['ANSWER_KEYBOARD']['Q14']);
    
    if(false !== $key){
        if($user->changeStageToQ14()){
            $user->job = $key;
            if($questionService->addQ14($key)){
                UserDao::save($user);
                //end, show result and invitation
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['SURVEY_THANKS_REMIND']);
                

                $invitationService = new InvitationService($user);
                
                if(!$invitationService->hasGenerated() && $invitationService->canGenerate()){
                    $invitation = $invitationService->getInvitation();
                    respondWithMessage($user->chat_id, sprintf($GLOBALS['WORD']['INVITATION_MSG'], $invitation->quota));
                    respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
                }
            }
        }
    }
    else{
        respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
        respondQ14($user->chat_id, $questionService->question);
    }
}

function handleStageQ14($user, $questionService, $text){
    $ary = array('/vote');
    if(in_array($text, $ary)){
        if($user->changeStageToRestart()){
            respondQ2($user->chat_id, $questionService->question);
            UserDao::save($user);
        }
    }
    else if(handleShowResult($user, $questionService->question, $text)){
        
    }
    else if(strpos($text, "/invite") === 0 && handleInvite($user, $text)){
        
    }
    else if(strpos($text, '/quota') ===0){
        $invitationService = new InvitationService($user);
        $invitation = $invitationService->getInvitation();
        respondQuotaLeft($user->chat_id, $invitation);
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
            respondPollingResult($user->chat_id, $question);
        }
        return true;
    }
    return false;
}

function handleInvite($user , $text){
    $ret = false;
    if(MemberType::canCreateMutli($user->member_type)){
         $invitationService = new InvitationService($user);
        if($invitationService->canGenerate()){
            $memberType = MemberType::L5;
            if(strpos($text, '/invite new') === 0){
                $memberType = MemberType::L1;
            } else if(strpos($text, '/invite c') === 0){
                $memberType = MemberType::CELEBRITIES;
            } else if(strpos($text, '/invite 1st') === 0){
                $memberType = MemberType::L2;
            } else if(strpos($text, '/invite 2nd') === 0){
                $memberType = MemberType::L3;
            } else if(strpos($text, '/invite pan') === 0){
                $memberType = MemberType::L4;
            } else if(strpos($text, '/invite general') === 0){
                $memberType = MemberType::L5;
            } 
            $invitationService->createOneInivitationLink($memberType);
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
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVITE_ALREAY_GENERATED']);
            respondWithMessage($user->chat_id, formatInvitationMessage($invitation));
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

function handleSurveyEnded($user, $text){
    if(strpos($text, "/invite") === 0 && handleInvite($user, $text)){
        
    }
    else if(strpos($text, '/quota') ===0){
        $invitationService = new InvitationService($user);
        $invitation = $invitationService->getInvitation();
        respondQuotaLeft($user->chat_id, $invitation);
    }
    else{
        respondSurveyEnded($user->chat_id);
    }
    die();
}

?>