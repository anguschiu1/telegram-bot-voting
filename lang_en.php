<?php
    $GLOBALS['WORD_EN']['WELCOME'] = "Welcome!\n\n Agree with our Terms & Condition?";
    $GLOBALS['WORD_EN']['INVITE_NO_PRIVILEGE'] = 'Not authorized';
    $GLOBALS['WORD_EN']['INVITE_ALREAY_GENERATED'] = "You already have an invitatoin link.\n";
    $GLOBALS['WORD_EN']['INVITATION_LINK'] = 'Your invitation link is %s. You can share with %d peoples.';
    $GLOBALS['WORD_EN']['SURVEY_NOT_START'] = 'You have not yet start voting.  Please click /start to vote.';
    $GLOBALS['WORD_EN']['SURVEY_Q1'] = 'Which district ? ';
    $GLOBALS['WORD_EN']['SURVEY_Q1_NOT_AGREE'] = 'You must agree, otherwise you cannot vote.';
    $GLOBALS['WORD_EN']['SURVEY_Q2'] = '2016 who will you vote in *%s*?';
    $GLOBALS['WORD_EN']['SURVEY_THANKS'] = 'Thanks for your vote';
    $GLOBALS['WORD_EN']['SURVEY_THANKS_REMIND'] = 'Please vote in next month.  We will remind you later.  Thank you.';
    $GLOBALS['WORD_EN']['SURVEY_RESULT'] = "「*%s*」Result: (Total: %d)：\n\n";
    $GLOBALS['WORD_EN']['SURVEY_RESULT_MORE'] = 'And more ';
    $GLOBALS['WORD_EN']['SURVEY_RESULT_LINK'] = '([Detailed result](http://civic-data.hk/result-graph/))';
    $GLOBALS['WORD_EN']['SURVEY_RESULT_RESTART_INSTRUCTION'] = "\nTo change your vote, click /start";
    $GLOBALS['WORD_EN'][''] = '';
    
        $aryPartyEn = array(
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

    $aryQ2En = array(
       'HK Island' => $aryPartyEn,
       'Kowloon East' => $aryPartyEn,
       'Kowloon West' => $aryPartyEn,
       'NT East' => $aryPartyEn,
       'NT West' => $aryPartyEn
    );

    $Q1AgreeEn = '👌 Agree';
    $Q1DisagreeEn = '🚫 No!';

    $aryQ1En = array('Y' => $Q1AgreeEn, 'N' => $Q1DisagreeEn);

?>