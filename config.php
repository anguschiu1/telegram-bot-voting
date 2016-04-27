<?php

define('BOT_TOKEN', 'MY_AWESOME_BOT_TOKEN');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

define('DB_CONNECT_STR', 'mysql:host=localhost;dbname=bot;charset=utf8mb4');
//define('DB_CONNECT_STR', 'pgsql:host=localhost;dbname=bot;user=poll;password=abcd1234;');
define('DB_USER_NAME', 'root');
define('DB_PASSWORD', '');

define ('CURRENT_ROUND_NUM', 1);
define ('INVITATION_LINK_PREFIX', 'https://telegram.me/CivicDataHK2Bot?start=');

define('DEBUG', true);
define('DEBUG_FILE_NAME', 'debug.txt');

?>