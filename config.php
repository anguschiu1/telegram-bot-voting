<?php

define('BOT_TOKEN', getenv('BOT_TOKEN'));
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

//define('DB_CONNECT_STR', 'pgsql:host=localhost;dbname=bot;user=poll;password=abcd1234;');

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER_NAME', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASSWORD', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

define('DB_CONNECT_STR', 'mysql:host='.getenv('OPENSHIFT_MYSQL_DB_HOST').';port='.getenv('OPENSHIFT_MYSQL_DB_PORT').';dbname='.getenv('OPENSHIFT_GEAR_NAME').';charset=utf8mb4');

define ('INVITATION_LINK_PREFIX', 'http://votsonar.civicdata.hk/?');

define('DEBUG', false);
define('DEBUG_FILE_NAME', 'debug.txt');

?>
