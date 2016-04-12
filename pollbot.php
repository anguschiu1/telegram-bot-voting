<?php

require 'config.php';
require('db.php');
require('api.php');
require('dao/invitation_dao.php');
require('dao/invitation_user_dao.php');
require('dao/user_dao.php');
require('model/invitation_model.php');
require('model/invitation_user_model.php');
require('model/question_model.php');
require('model/user_model.php');
require('process.php');


if (php_sapi_name() == 'cli') {
    // if run from console, set or delete webhook.  Will not upload self-signed certificate
    apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
    exit;
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);
logDebug("Receving content: $content\n");

if (!$update) {
    // receive wrong update, must not happen
    logDebug('wrong update');
    exit;
}

if (isset($update["message"])) {
    processMessage($update["message"]);
}



/*
//for getUpdates
foreach ($update['result'] as $result){
    processMessage($result['message']);
}
*/

?>