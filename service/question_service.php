<?php
class QuestionService{
    private $user;
    public $question;
    
    function __construct($user, $question){
        $this->user = $user;
        $this->question = $question;
    }
    
    public function addQ1($answer){
        $result = false;
        
        if(null != $this->user){
            if(null === $this->question->user_id){
                $this->question->user_id = $this->user->user_id;
            }
            $this->question = QuestionDao::updateSingle($this->question, 1, $answer);
            
            $result = true;
        }
        return $result;
    }

    public function addQ2($answer){
        $result = false;
        
        if(null !== $this->question){
            QuestionDao::updateSingle($this->question, 2, $answer);
            $result = true;
        }
        return $result;
    }

    public function addQ3($answer){
        $result = false;
        
        if(null != $this->user){
            if(null != $this->question){
                QuestionDao::updateSingle($this->question, 3, $answer);
                $result = true;
            }
        }
        return $result;
    }

    private function setQuestion($q, $answer){
        switch($q){
            case 1:
                $this->question->q1 = $answer;
                break;
            case 2:
                $this->question->q2 = $answer;
                break;
            case 3:
                $this->question->q3 = $answer;
                break;
            case 4:
                $this->question->q4 = $answer;
                break;
            case 5:
                $this->question->q5 = $answer;
                break;
            case 6:
                $this->question->q6 = $answer;
                break;
            case 7:
                $this->question->q7 = $answer;
                break;
            case 8:
                $this->question->q8 = $answer;
                break;
            case 9:
                $this->question->q9 = $answer;
                break;
            case 10:
                $this->question->q10 = $answer;
                break;
            case 11:
                $this->question->q11 = $answer;
                break;
            case 12:
                $this->question->q12 = $answer;
                break;
            case 13:
                $this->question->q13 = $answer;
                break;
            case 14:
                $this->question->q14 = $answer;
                break;
            case 15:
                $this->question->q15 = $answer;
                break;
        }
        $this->question = QuestionDao::save($this->question);
        return true;
    }

    public function addQ4($answer){
        return $this->setQuestion(4, $answer);
    }

    public function addQ5($answer){
        return $this->setQuestion(5, $answer);
    }

    public function addQ6($answer){
        return $this->setQuestion(6, $answer);
    }

    public function addQ7($answer){
        return $this->setQuestion(7, $answer);
    }

    public function addQ8($answer){
        return $this->setQuestion(8, $answer);
    }

    public function addQ9($answer){
        return $this->setQuestion(9, $answer);
    }

    public function addQ10($answer){
        return $this->setQuestion(10, $answer);
    }

    public function addQ11($answer){
        return $this->setQuestion(11, $answer);
    }

    public function addQ12($answer){
        return $this->setQuestion(12, $answer);
    }

    public function addQ13($answer){
        return $this->setQuestion(13, $answer);
    }

    public function addQ14($answer){
        return $this->setQuestion(14, $answer);
    }

    public function addQ15($answer){
        return $this->setQuestion(15, $answer);
    }
}
?>