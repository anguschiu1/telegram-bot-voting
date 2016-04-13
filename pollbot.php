<?php

require('inc.php');


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