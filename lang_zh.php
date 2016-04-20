<?php
    $GLOBALS['WORD']['WELCOME'] = "歡迎\n\n同意我們的使用條款? /en to English";
    $GLOBALS['WORD']['INVITE_NO_PRIVILEGE'] = '沒有權限';
    $GLOBALS['WORD']['INVITE_ALREAY_GENERATED'] = "你已有邀請連結。\n";
    $GLOBALS['WORD']['INVITATION_LINK'] = '你的邀請連結為 %s 。你可以分享給 %d 個人。';
    $GLOBALS['WORD']['SURVEY_NOT_START'] = '你還未開始投票，請使用 /start 開始。';
    $GLOBALS['WORD']['SURVEY_Q1'] = '你的選民登記屬於那個選區？';
    $GLOBALS['WORD']['SURVEY_Q1_NOT_AGREE'] = '我們需要你的同意，才能繼續。';
    $GLOBALS['WORD']['SURVEY_Q2'] = '2016 年立會選舉你`現時`傾向投給 %s 中的哪個政黨？';
    $GLOBALS['WORD']['SURVEY_THANKS'] = '多謝投票。';
    $GLOBALS['WORD']['SURVEY_THANKS_REMIND'] = '請於下個月再投票，到時我們會再提醒你，謝謝';
    $GLOBALS['WORD']['SURVEY_RESULT'] = "「`%s`」 選區的結果 (共 %d 票)：\n\n";
    $GLOBALS['WORD']['SURVEY_RESULT_MORE'] = '還有其他 ';
    $GLOBALS['WORD']['SURVEY_RESULT_LINK'] = '([詳細的結果](http://civic-data.hk/result-graph/))';
    $GLOBALS['WORD']['SURVEY_RESULT_RESTART_INSTRUCTION'] = "\n如要更改你的投票，請使用 /start 重新開始";
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
    '20' => '未決定'
    );

    $aryQ2 = array(
       '香港島' => $aryParty,
       '九龍東' => $aryParty,
       '九龍西' => $aryParty,
       '新界東' => $aryParty,
       '新界西' => $aryParty
    );

    $Q1Agree = '👌 同意';
    $Q1Disagree = '🚫 No!';

    $aryQ1 = array('Y' => $Q1Agree, 'N' => $Q1Disagree);
?>