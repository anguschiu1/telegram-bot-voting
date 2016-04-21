<?php
    $GLOBALS['WORD_TC']['WELCOME'] = "公民數據以滾動投票方式讓支持民主的選民即時投票同睇結果。選民每月一號投票及查看各政團的最新支持度，以求在九月四號的立法會選，讓你做更明智既投票決定。";
    $GLOBALS['WORD_TC']['WELCOME_TERMS'] = "`「使用條款」`\n\n參加人士必須小心輸入所有資料，「確認」遞交後將不能作出任何修改。\n\n".
        "參加人士必須確保傳送的任何電子訊息，均不含任何病毒或可能影響此投票運作的元素，又或對公民聲吶的資料或系統造成損害、干擾或刪減。電訊商可能會向發送使用者收取流動數據費用，有關費用與公民聲吶無關。\n\n".
        "所有收集的個人資料只用作是次活動的身分驗証，傳送時 Telegram 會使用 256-位元 AES 加密，以確保有關資料實際上無法被人破解。加密技術由 Telegram 提供，並非由公民聲吶負責。";
    $GLOBALS['WORD_TC']['WELCOME_TERMS_AGREE'] = '同意以上使用條款?';
    $GLOBALS['WORD_TC']['INVITE_NO_PRIVILEGE'] = '沒有權限';
    $GLOBALS['WORD_TC']['INVITE_ALREAY_GENERATED'] = "你已有邀請連結。\n";
    $GLOBALS['WORD_TC']['INVITATION_MSG'] = '由於你是第一次投票，你可以邀請 %d 個支持民主的朋友來投票，請複製以下訊息給你 Telegram、WhatsApp 或 Facebook 上的朋友。';
    $GLOBALS['WORD_TC']['INVITATION_LINK'] = "我誠意邀請你去「公民數據」查看立法會最新投票調查結果。\n\n".
            "Civic Data HK 公民數據以滾動投票方式讓支持民主的選民即時投票和睇結果。你可查看各政團的最新支持度，以求在九月四號的立法會選舉，讓你做更明智的投票決定。\n\n".
            '[%1$s](%1$s)';
    $GLOBALS['WORD_TC']['SURVEY_NOT_START'] = '你還未開始投票，請使用 /start 開始。';
    $GLOBALS['WORD_TC']['SURVEY_Q1'] = '你的選民登記屬於那個選區？';
    $GLOBALS['WORD_TC']['SURVEY_Q1_NOT_AGREE'] = '我們需要你的同意，才能繼續。';
    $GLOBALS['WORD_TC']['SURVEY_Q2'] = '2016 年立會選舉你`現時`傾向投給 %s 中的哪個政黨？';
    $GLOBALS['WORD_TC']['SURVEY_Q2_CONFIRM'] = '確認投給「%s」？';
    $GLOBALS['WORD_TC']['SURVEY_THANKS'] = '多謝投票。';
    $GLOBALS['WORD_TC']['SURVEY_THANKS_REMIND'] = '請於下個月一號回來再投票，同時看最新投票結果。到時我們會再提醒你，謝謝。';
    $GLOBALS['WORD_TC']['SURVEY_RESULT'] = "「`%s`」 選區的結果 (共 %d 票)：\n\n";
    $GLOBALS['WORD_TC']['SURVEY_RESULT_MORE'] = '還有其他 ';
    $GLOBALS['WORD_TC']['SURVEY_RESULT_LINK'] = '([詳細的結果](http://votsonar.civicdata.hk/result/))';
    $GLOBALS['WORD_TC']['SURVEY_RESULT_RESTART_INSTRUCTION'] = "\n";
    $GLOBALS['WORD_TC']['INVALID_INPUT'] = '對不起，我不明白';
    
    
    
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

    $Q1AgreeTc = '👌 我同意';
    $Q1DisagreeTc = '🚫 不!';

    $aryQ1Tc = array('Y' => $Q1AgreeTc, 'N' => $Q1DisagreeTc);
?>