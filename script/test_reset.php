<?php

require('../php/inc.php');
require('module.php');

$db = getDb();
$stmt3 = $db->prepare("update `bulk` set status=:status, last_modified_date=CURRENT_TIMESTAMP where chat_id=:chat_id");
$stmt3->bindValue(1, 1);
$stmt3->bindValue(2, 198674682);
$stmt3->execute();

?>
