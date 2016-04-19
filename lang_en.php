<?php
    $GLOBALS['WORD']['WELCOME'] = "Welcome!\n\n Agree with our Terms & Condition?";
    $GLOBALS['WORD']['INVITE_NO_PRIVILEGE'] = 'Not authorized';
    $GLOBALS['WORD']['INVITE_ALREAY_GENERATED'] = "You already have an invitatoin link.\n";
    $GLOBALS['WORD']['INVITATION_LINK'] = 'Your invitation link is %s. You can share with %d peoples.';
    $GLOBALS['WORD']['SURVEY_NOT_START'] = 'You have not yet start voting.  Please click /start to vote.';
    $GLOBALS['WORD']['SURVEY_Q1'] = 'Which district ? ';
    $GLOBALS['WORD']['SURVEY_Q1_NOT_AGREE'] = 'You must agree, otherwise you cannot vote.';
    $GLOBALS['WORD']['SURVEY_Q2'] = '2016 who will you vote in *%s*?';
    $GLOBALS['WORD']['SURVEY_THANKS'] = 'Thanks for your vote';
    $GLOBALS['WORD']['SURVEY_THANKS_REMIND'] = 'Please vote in next month.  We will remind you later.  Thank you.';
    $GLOBALS['WORD']['SURVEY_RESULT'] = "「*%s*」Result: (Total: %d)：\n\n";
    $GLOBALS['WORD']['SURVEY_RESULT_MORE'] = 'And more ';
    $GLOBALS['WORD']['SURVEY_RESULT_LINK'] = '([Detailed result](http://civic-data.hk/result-graph/))';
    $GLOBALS['WORD']['SURVEY_RESULT_RESTART_INSTRUCTION'] = "\nTo change your vote, click /start";
    $GLOBALS['WORD'][''] = '';
    
        $aryParty = array(
    '1' => '民主黨',
    '2' => '公民黨',
    '3' => '工黨',
    '4' => '街工',
    '5' => '民協',
    '6' => '新民主同盟',
    '7' => '社民連',
    '8' => '人民力量',
    '9' => '學民思潮',
    '10' => '青年新政本民前',
    '11' => '熱血公民',
    '12' => '民建聯',
    '13' => '工聯會',
    '14' => '經民聯',
    '15' => '新民黨鄉事派',
    '16' => '自由黨',
    '17' => '民主思路',
    '18' => '新思維',
    '19' => '其他',
    '20' => 'Not yet'
    );

    $aryQ2 = array(
       'HK Island' => $aryParty,
       'Kowloon East' => $aryParty,
       'Kowloon West' => $aryParty,
       'NT East' => $aryParty,
       'NT West' => $aryParty
    );

    $Q1Agree = '👌 同意';
    $Q1Disagree = '🚫 No!';

    $aryQ1 = array('Y' => $Q1Agree, 'N' => $Q1Disagree);

?>