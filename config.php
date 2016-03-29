<?php

define('BOT_TOKEN', 'MY_AWESOME_BOT_TOKEN');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

define('DB_CONNECT_STR', 'PDO_DB_CONNECT_STR');
define('DB_USER_NAME', 'Username');
define('DB_PASSWORD', 'Password');

define('DEBUG', true);
define('DEBUG_FILE_NAME', 'debug.txt');

require('db.php');
require('process.php');
?>