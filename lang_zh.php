<?php
    $GLOBALS['WORD_TC']['WELCOME'] = "歡迎\n\n同意我們的使用條款?";
    $GLOBALS['WORD_TC']['INVITE_NO_PRIVILEGE'] = '沒有權限';
    $GLOBALS['WORD_TC']['INVITE_ALREAY_GENERATED'] = "你已有邀請連結。\n";
    $GLOBALS['WORD_TC']['INVITATION_MSG'] = '由於你是第一次投票，你可以邀請 %d 個支持民主的朋友來投票，請複製以下訊息給你 Telegram、WhatsApp 或 Facebook 上的朋友。';
    $GLOBALS['WORD_TC']['INVITATION_LINK'] = "我誠意邀請你去「公民數據」查看立法會最新投票調查結果。\n\n".
            "Civic Data HK 公民數據以滾動投票方式讓支持民主的選民即時投票和睇結果。你可查看各政團的最新支持度，以求在九月四號的立法會選舉，做更明智的投票決定。\n\n".
            "%s";
    $GLOBALS['WORD_TC']['SURVEY_NOT_START'] = '你還未開始投票，請使用 /start 開始。';
    $GLOBALS['WORD_TC']['SURVEY_Q1'] = '你的選民登記屬於那個選區？';
    $GLOBALS['WORD_TC']['SURVEY_Q1_NOT_AGREE'] = '我們需要你的同意，才能繼續。';
    $GLOBALS['WORD_TC']['SURVEY_Q2'] = '2016 年立會選舉你`現時`傾向投給 %s 中的哪個政黨？';
    $GLOBALS['WORD_TC']['SURVEY_Q2_CONFIRM'] = '確認投給「%s」？';
    $GLOBALS['WORD_TC']['SURVEY_THANKS'] = '多謝投票。';
    $GLOBALS['WORD_TC']['SURVEY_THANKS_REMIND'] = '請於下個月一號回來再投票，同時看最新投票結果。到時我們會再提醒你，謝謝。';
    $GLOBALS['WORD_TC']['SURVEY_RESULT'] = "「`%s`」 選區的結果 (共 %d 票)：\n\n";
    $GLOBALS['WORD_TC']['SURVEY_RESULT_MORE'] = '還有其他 ';
    $GLOBALS['WORD_TC']['SURVEY_RESULT_LINK'] = '([詳細的結果](http://civic-data.hk/result-graph/))';
    $GLOBALS['WORD_TC']['SURVEY_RESULT_RESTART_INSTRUCTION'] = "\n如要更改你的投票，請使用 /vote 重新選擇";
    $GLOBALS['WORD_TC'][''] = '';
    
    
    
    $aryPartyTc = array(
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

    $aryQ2Tc = array(
       '香港島' => $aryPartyTc,
       '九龍東' => $aryPartyTc,
       '九龍西' => $aryPartyTc,
       '新界東' => $aryPartyTc,
       '新界西' => $aryPartyTc
    );

    $Q1AgreeTc = '👌 同意';
    $Q1DisagreeTc = '🚫 No!';

    $aryQ1Tc = array('Y' => $Q1AgreeTc, 'N' => $Q1DisagreeTc);
?>