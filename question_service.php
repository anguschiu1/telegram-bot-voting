<?php

function addQ1($user, $question, $text){
    $result = false;
    
    if(null != $user){
        global $aryQ1;
        
        $answer = array_search($text, $aryQ1);
        
        if(null != $question){
            $i = QuestionDao::updateSingle($question, 1, $answer);
        }
        else{
            $question = new Question();
            $question->user_id = $user->user_id;
            $question->q1 = $answer;
            $i = QuestionDao::save($question);
        }
        print_r($i);
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
            QuestionDao::updateSingle($question, 2, $answer);
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
            QuestionDao::updateSingle($question, 3, $answer);
            $result = true;
        }
    }
    return $result;
}
?>