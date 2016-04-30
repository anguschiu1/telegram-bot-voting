<?php
    $GLOBALS['WORD_EN'] = array(
        'NOT_AUTHORIZED' => "We are sorry that your invitation URL is invalid. Please check again with the URL. For enquiries, please send a message to @CivicDataHK",
        'LINK_QUOTA_USED_UP' => "We are sorry that the quota is exceeded for this invitation URL. What about asking  someone else to invite you? For enquiries, please send a message to @CivicDataHK",
        'WELCOME_CHOOSE_LANGUAGE' => 'Please select a language:',
        'WELCOME' => "Votsonar lets voters vote and see polling results in real time. Participants get to vote on the 1st of every month, see the latest polling data of all parties and candidates, and be able to make a wiser choice in the Legislature Council (LegCo) Election on September 4th, 2016.",
        'WELCOME_TERMS' => "`「Terms」`\n\nParticipants must input all information carefully because changes are not allowed after submission is \"confirmed\".Participants must ensure that all electronic messages sent do not contain any virus or element that will affect the operation of this voting or will damage, interfere or compromise the system of VotSonar, or any information it contains. A fee may be levied on the mobile data user by the telecommunication company, but VotSonar has no part to play in this.All personal information collected is used only for identity verification for this activity. The data transferred through Telegram will be encrypted using 256-bit AES encryption so that effectively no one can decode them. The encryption technology is provided by Telegram, not by VotSonar.",
        'WELCOME_TERMS_AGREE' => 'Do you agree with the above terms and conditions?',
        'INVITE_NO_PRIVILEGE' => 'No privileges',
        'INVITE_ALREAY_GENERATED' => "You already have an invitation link\n",
        'INVITATION_MSG' => 'Thanks for casting your vote. Now, you can simply copy the message below to invite your friends (who are also supporting the non-establishment camp) via Telegram, WhatsApp or Facebook.  Each link can only invite a maximum of 10 different friends to vote. 
👇👇',
        'INVITATION_LINK' => "How Votsonar Works:\n1. Download Telegram\n2. Click the “invitation” link\n".'[%1$s](%1$s)
3. Vote for the candidate you vow to support at this point of time
4. Check the real-time poll results.
5. Polling will start again in the beginning of each month.  You are welcome to check the latest poll results anytime.',
        'SURVEY_NOT_START' => '你還未開始投票，請使用 /start 開始。',
        'SURVEY_Q1_NOT_AGREE' => 'I am sorry, we need your consent to continue the survey. Please kindly reconsider!',
        'SURVEY_Q2' => 'Which candidate did you vote for in LegCo Election 2012?',
        'SURVEY_Q3' => 'Are you an eligible voter in LegCo 2016?',
        'SURVEY_Q4' => 'Which of the geographical constituency do you live in?',
        'SURVEY_Q5' => 'If tomorrow is the voting day of the LegCo Election, which one of the following lists will you vote for in Geographical Constituency Areas (the name in the bracket is the possible candidate representing the political group)?',
        'SURVEY_Q6' => 'What do you think about the winning chance of "%s" in 4-Sep LegCo election?',
        'SURVEY_Q7' => 'Apart from the above candidate list, do you have a second choice?',
        'SURVEY_Q8' => 'In LegCo Election 2012, you voted "%1$s". In the coming election, you will choose "%2$s", and you think that list has "%3$s" chance to win. 
Apart from "%2$s", your second most preferable choice is "%4$s".'."\nAre you sure?",
        'SURVEY_Q9' => 'If tomorrow is the voting day of the LegCo Election, which one of the following lists will you vote for in District Council (Second) of Functional Constituency Area (the name in bracket is the possible candidate representing the political group)?',
        'SURVEY_Q10' => 'What do you think about the winning chance of "%s" in the coming LegCo election?',
        'SURVEY_Q11' => 'Apart from the above candidate, do you have a second choice?',
        'SURVEY_Q12' => 'In the coming election, you will choose "%1$s", and you think that s/he has "%2$s" chance to win. 
Apart from "%1$s", your second most preferable choice is "%3$s"
Are you sure?',
        'SURVEY_Q13' => 'To help improve our analysis, we would like to know more about your personal information.
May I have your age?',
        'SURVEY_Q14' => 'May I know your occupation?',
        'SURVEY_Q15' => '',
        'SURVEY_Q2_CONFIRM' => '確認投給「%s」？',
        'SURVEY_THANKS' => 'Thank you so much for your response!',
        'SURVEY_THANKS_REMIND' => "Thank you for your participation!
Please come back and vote again on 1st of June, and you can also check out the latest survey results. Civic Data HK will remind you by push notifications around that period.",
        'SURVEY_RESULT' => "Here it is the real time survey result of `%s` in May. Currently %d people have voted.\n\n",
        'SURVEY_RESULT_MORE' => 'and more',
        'SURVEY_RESULT_LINK' => '([Detailed result](http://votsonar.civicdata.hk/result.html))',
        'SURVEY_RESULT_RESTART_INSTRUCTION' => "\n",
        'INVALID_INPUT' => 'Sorry, I do not understand',
        'ALREADY_VOTE' => "You have already voted.  Please use `/result` to check the result",
    );
    
    
    $GLOBALS['ANSWER_KEYBOARD_EN'] = array(
        'WELCOME_LANGUAGE' => array('廣東話', 'English'),
        'Q1_AGREE' => '👌 I agree',
        'Q1_DISAGREE' => '🚫 I do not agree',
        'Q1' => array('👌 I agree', '🚫 I do not agree'),
        'Q2' => getVoter2012KeyboardAllEn(),
        'Q3' => array('👌 Yes', '🚫 No'),
        'Q4' => getQ2KeyboardEn(),
        'Q4_CONFIRM_YES' => '✔ Yes',
        'Q4_CONFIRM_NO' => '❌ No',
        'Q4_CONFIRM_YES_ANSWERS' => array('yes', 'confirm', 'ok', '✔ Yes', '確定'),
        'Q4_CONFIRM_NO_ANSWERS' => array('no', 'nope', '❌ No', '否', '不'),
        'Q4_CONFIRM' => array ('✔ Yes', '❌ No'),
        'Q5' => getQ3KeyboardEn(),
        'Q6' => array('0%', '10%', '20%', '30%', '40%', '50%', '60%', '70%', '80%', '90%', '100%', 'uncertain'),
        'Q7' => getQ3KeyboardEn(),
        'Q8' => array('👌 Yes, that is it', '🚫 No, I need to choose again.'),
        'Q9' => getSuperPartyKeyboardEn(),
        'Q10' => array('0%', '10%', '20%', '30%', '40%', '50%', '60%', '70%', '80%', '90%', '100%', 'uncertain'),
        'Q11' => getSuperPartyKeyboardEn(),
        'Q12' => array('👌 Yes, that is it', '🚫 No, I need to choose again'),
        'Q13' => array('under 18', '18-25', '26-50', '51-75', '76-98', 'I don\'t want to disclose'),
        'Q14' => array('Managers and administrators',
                        'Professionals',
                        'Associate professionals',
                        'Clerks',
                        'Service workers and shop sales workers',
                        'Skilled agricultural and fishery workers',
                        'Craft and related workers',
                        'Elementary occupations',
                        'Students',
                        'Homemakers',
                        'Occupations not classifiable',
                        'Others (Including unemployed, retired and other non-occupied workers)',
                        'I don\'t want to disclose.'),
        'PARTY_NOT_YET_DECIDE' => 'Not yet decide',
        'PARTY_NO_SECOND_CHOICE' => 'No second choice'
    ); 
    
function getQ3KeyboardEn(){
    return array(
        0 => array('Democratic Alliance for the Betterment and Progress of HK (CHUNG Shu Kun)',
                    'Democratic Alliance for the Betterment and Progress of HK (List 2)',
                    'HK Federation of Trade Unions',
                    'Business and Professionals Alliance for HK',
                    'New People\'s Party (Regina IP LAU Suk-yee)',
                    'Liberal Party',
                    'Path of Democracy',
                    'Third Side',
                    'Democratic Party (HUI Chi-fung)',
                    'Civic Party (Tanya CHAN Suk-chong)',
                    'Labour Party (Cyd HO Sau-lan)',
                    'People Power (Christopher  LAU Gar Hung)',
                    'Demosistō (Nathan LAW Kwun Chung)',
                    'Youngspiration (Baggio LEUNG Chung-heng)',
                    'Civic Passion (Alvin CHENG Kam-mun)'),
        1 => array('Democratic Alliance for the Betterment and Progress of HK  ( CHAN Kam Lam)',
                    'HK Federation of Trade Unions',
                    'Business and Professionals Alliance for HK',
                    'New People\'s Party',
                    'Liberal Party',
                    'Paul TSE Wai-chun',
                    'Path of Democracy',
                    'Third Side',
                    'Democratic Party (WU Chi-wai)',
                    'Civic Party (Jeremy TAM Man Ho)',
                    'Labour Party (Suzanne WU Shui-shan)',
                    'HK Association for Democracy and People\'s Livelihood',
                    'People Power (TAM Tak Chi)',
                    'Demosistō （Oscar LAI Man Lok）',
                    'Kowloon East Community (CHAN Chak To)',
                    'Civic Passion (WONG Yeung Tat)'),
        2 => array('Democratic Alliance for the Betterment and Progress of HK  (Ann CHIANG)',
                    'HK Federation of Trade Unions',
                    'Business and Professionals Alliance for HK (Priscilla LEUNG Mei-fun )',
                    'New People\'s Party',
                    'Liberal Party',
                    'Path of Democracy',
                    'Third Side',
                    'Democratic Party (Helena WONG Pik-wan)',
                    'Civic Party (Claudia MO)',
                    'Labour Party (CHIU Shi Shun)',
                    'HK Association for Democracy and People\'s Livelihood',
                    'League of Social Democrats (Avery NG Man Yuen)',
                    'Lester SHUM Ngo-fai',
                    'Youngspiration (YAU Wai-ching)',
                    'Civic Passion ( WONG Yuk-man)'),
        3 => array('Democratic Alliance for the Betterment and Progress of HK  (CHAN Hak Kan)',
                    'Democratic Alliance for the Betterment and Progress of HK  (Elizabeth QUAT)',
                    'HK Federation of Trade Unions',
                    'Business and Professionals Alliance for HK',
                    'New People\'s Party',
                    'New Territories Progressive Alliance',
                    'Liberal Party',
                    'Christine FONG Kwok Shan',
                    'Path of Democracy',
                    'Third Side',
                    'Democratic Party (LAM Cheuk-ting)',
                    'Civic Party (Alvin YEUNG Ngok-kiu)',
                    'Labour Party (Fernando CHEUNG Chiu-hung)',
                    'NeoDemocrats (Gary FAN Kwok-wai)',
                    'League of Social Democrats (LEUNG Kwok-hung)',
                    'People Power (CHAN Chi-chuen)',
                    'LAU Siu-lai',
                    'Hong Kong Indigenous (Edward LEUNG Tin Kei)',
                    'Civic Passion (Horace CHIN Wan-kan)'),
        4 => array('Democratic Alliance for the Betterment and Progress of HK  ( CHAN Han Ban)',
                    'Democratic Alliance for the Betterment and Progress of HK  ( LEUNG Che Cheung)',
                    'Democratic Alliance for the Betterment and Progress of HK  ( TAM Yiu Chung)',
                    'HK Federation of Trade Unions (MAK Mei-kuen)',
                    'Business and Professionals Alliance for HK',
                    'New People\'s Party (Michael TIEN Puk-sun)',
                    'New Territories Progressive Alliance',
                    'Liberal Party', 
                    'Path of Democracy',
                    'Democratic Party (Andrew WAN Siu-kin)',
                    'Third Side',
                    'Civic Party (KWOK Ka-ki)',
                    'Labour Party (LEE Cheuk-yan )',
                    'HK Association for Democracy and People\'s Livelihood',
                    'NeoDemocrats (TAM Hoi-pong)',
                    'Neighbourhood and Workers Services Centre',
                    'League of Social Democrats/People Power (WONG Ho Ming /Albert CHAN Wai-yip)',
                    'Eddie CHU Hoi-dick',
                    'Youngspiration ( WONG Chun Kit)',
                    'Civic Passion (CHENG Chung-tai)'),
    );
}

function getQ2KeyboardEn(){
    return array(
       0 => 'Hong Kong Island',
       1 => 'Kowloon East',
       2 => 'Kowloon West',
       3 => 'New Territories East',
       4 => 'New Territories West'
    );
}

function getSuperPartyKeyboardEn(){
    return array('Democratic Alliance for the Betterment and Progress of HK  (List 1)',
                'Democratic Alliance for the Betterment and Progress of HK  (List 2)',
                'HK Federation of Trade Unions',
                'Another Establishment Camp List',
                'Democratic Party (James TO Kun-sun )',
                'Democratic Party (KWONG Chun-yu)',
                'Civic Party',
                'HK Association for Democracy and People\'s Livelihood',
                'NeoDemocrats (KWAN Wing-yip)',
                'Neighbourhood and Workers Services Centre (LEUNG Yiu-chung)',
                'Paul Zimmerman');
}

function getVoter2012KeyboardAllEn(){
    $ret = array();
    $voter2012 = getVoter2012KeyboardEn();
    foreach (getQ2KeyboardEn() as $districtKey => $district){
        foreach($voter2012[$districtKey] as $voter){
            array_push($ret, "[$district] $voter");
        }
    }
    array_push($ret, 'I was not a voter', 'I was a voter but did not vote');
    return $ret;
}
function getVoter2012KeyboardEn(){
    return array(
        0 => array(
            'HUI CHING ON',
            'SIN CHUNG KAI',
            'LO WING LOK',
            'LAU GAR HUNG CHRISTOPHER',
            'CHUNG SHU KUN CHRISTOPHER',
            'NG WING CHUN',
            'HO SAU LAN CYD',
            'IP LAU SUK YEE REGINA',
            'WONG KWOK HING',
            'CHAN KA LOK',
            'HO KAR TAI',
            'TSANG YOK SING JASPER',
            'LAU KIN YEE MIRIAM',
            'NG MAN YUEN AVERY',
            //'I was not a voter', 'I was a voter but did not vote'
        ),
        1 => array(
            'LEONG KAH KIT ALAN',
            'WONG KWOK KIN',
            'TO KWAN HANG ANDREW',
            'YIM FUNG CHI KAY',
            'WU CHI WAI',
            'CHAN KAM LAM',
            'TSE WAI CHUN PAUL',
            'WONG YEUNG TAT',
            'TAM HEUNG MAN',
            //'I was not a voter', 'I was a voter but did not vote'
        ),
        2 => array(
            'WONG YEE HIM',
            'WONG PIK WAN',
            'TAM KWOK KIU',
            'WONG YAT YUK',
            'CHIANG LAI WAN',
            'WONG YUK MAN',
            'LAM YI LAI',
            'LEUNG MEI FUN',
            'MO MAN CHING CLAUDIA',
            //'I was not a voter', 'I was a voter but did not vote'
        ),
        3 => array(
            'LEUNG KWOK HUNG',
            'IP WAI MING',
            'LAU WAI HING EMILY',
            'LEUNG ON KAY ANGEL',
            'PONG SCARLETT OI LAN',
            'QUAT ELIZABETH',
            'CHAN CHI CHUEN RAYMOND',
            'YAU WING KWONG',
            'CHAN HAK KAN',
            'CHEUNG CHIU HUNG',
            'TSOI YIU CHEONG RICHARD',
            'FAN GARY KWOK WAI',
            'TIEN PEI CHUN JAMES',
            'WONG SING CHI',
            'TONG KA WAH RONNY',
            'HO MAN KIT RAYMOND',
            'PONG YAT MING',
            'FONG KWOK SHAN CHRISTINE',
            'CHAN KWOK KEUNG',
            //'I was not a voter', 'I was a voter but did not vote'
        ),
        4 => array(
            'LEUNG CHE CHEUNG',
            'MAK MEI KUEN ALICE',
            'CHAN SHU YING JOSEPHINE',
            'CHAN WAI YIP ALBERT',
            'MAK IP SING',
            'TSANG KIN SHING',
            'KWOK KA KI',
            'TIEN MICHAEL PUK SUN',
            'HO KWAN YIU',
            'CHAN YUT WAH',
            'LEUNG YIU CHUNG',
            'CHAN HAN PAN',
            'CHAN KEUNG',
            'LEE WING TAT',
            'LEE CHEUK YAN',
            'TAM YIU CHUNG',
            //'I was not a voter', 'I was a voter but did not vote'
        )
        );
}
?>