<?php
    $GLOBALS['WORD_TC'] = array(
        'WELCOME' => "公民數據以滾動投票方式讓支持民主的選民即時投票同睇結果。選民每月一號投票及查看各政團的最新支持度，以求在九月四號的立法會選，讓你做更明智既投票決定。",
        'WELCOME_TERMS' => "`「使用條款」`\n\n參加人士必須小心輸入所有資料，「確認」遞交後將不能作出任何修改。\n\n".
            '參加人士必須確保傳送的任何電子訊息，均不含任何病毒或可能影響此投票運作的元素，'.
            '又或對公民聲吶的資料或系統造成損害、干擾或刪減。電訊商可能會向發送使用者收取流動數據費用，'.
            "有關費用與公民聲吶無關。\n\n".
            '所有收集的個人資料只用作是次活動的身分驗証，傳送時 Telegram 會使用 256-位元 AES 加密，'.
            '以確保有關資料實際上無法被人破解。加密技術由 Telegram 提供，並非由公民聲吶負責。',
        'WELCOME_TERMS_AGREE' => '同意以上使用條款?',
        'INVITE_NO_PRIVILEGE' => '沒有權限',
        'INVITE_ALREAY_GENERATED' => "你已有邀請連結。\n",
        'INVITATION_MSG' => '由於你是第一次投票，你可以邀請 %d 個支持民主的朋友來投票，請複製以下訊息給你 Telegram、WhatsApp 或 Facebook 上的朋友。',
        'INVITATION_LINK' => "我誠意邀請你去「公民數據」查看立法會最新投票調查結果。\n\n".
                "Civic Data HK 公民數據以滾動投票方式讓支持民主的選民即時投票和睇結果。你可查看各政團的最新支持度，以求在九月四號的立法會選舉，讓你做更明智的投票決定。\n\n".
                '[%1$s](%1$s)', 
        'SURVEY_NOT_START' => '你還未開始投票，請使用 /start 開始。',
        'SURVEY_Q1' => '你的選民登記屬於那個選區？',
        'SURVEY_Q1_NOT_AGREE' => '我們需要你的同意，才能繼續。',
        'SURVEY_Q2' => '2016 年立會選舉你`現時`傾向投給 %s 中的哪個政黨？',
        'SURVEY_Q2_CONFIRM' => '確認投給「%s」？',
        'SURVEY_THANKS' => '多謝投票。',
        'SURVEY_THANKS_REMIND' => '請於下個月一號回來再投票，同時看最新投票結果。到時我們會再提醒你，謝謝。',
        'SURVEY_RESULT' => "「`%s`」 選區的結果 (共 %d 票)：\n\n",
        'SURVEY_RESULT_MORE' => '還有其他 ',
        'SURVEY_RESULT_LINK' => '([詳細的結果](http://votsonar.civicdata.hk/result.html))',
        'SURVEY_RESULT_RESTART_INSTRUCTION' => "\n",
        'INVALID_INPUT' => '對不起，我不明白',
        'ALREADY_VOTE' => "你已投票了。你可以用 /result 查看投票結果。",
    );
    
    
    $GLOBALS['ANSWER_KEYBOARD_TC'] = array(
        'Q1_AGREE' => '👌 我同意',
        'Q1_DISAGREE' => '🚫 不!',
        'Q1' => array('👌 我同意', '🚫 不!'),
        'Q2' => getQ2Keyboard(),
        'Q2_CONFIRM_YES' => 'Yes',
        'Q2_CONFIRM_NO' => 'No',
        'Q2_CONFIRM' => array ('Yes', 'No'),
        'Q3' => getQ3Keyboard()
    );
    
function getQ3Keyboard(){
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
    return array(
        0 => $aryParty,
        1 => $aryParty,
        2 => $aryParty,
        3 => $aryParty,
        4 => $aryParty
    );
}

function getQ2Keyboard(){
    return array(
       0 => '香港島',
       1 => '九龍東',
       2 => '九龍西',
       3 => '新界東',
       4 => '新界西'
    );
}
?>