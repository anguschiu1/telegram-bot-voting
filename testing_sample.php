<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php
require('inc.php');


$user_id = '60';
$text = '/invite';

$messageStr = '{
		"message_id": 231,
		"from": {
			"id": '.$user_id.',
			"first_name": "MY FIRST NAME",
			"last_name": "MY LAST NAME"
		},
		"chat": {
			"id": '.$user_id.',
			"first_name": "MY FIRST NAME",
			"last_name": "MY LAST NAME"
			"type": "private"
		},
		"date": 1458745194,
		"text": "'.$text.'"
	}';


processMessage(json_decode($messageStr, true));

?>

</body></html>