<?php

require('../php/inc.php');
require('module.php');

$db = getDb();

$stmt1 = $db->prepare("SELECT DATE_FORMAT(create_date, '%e %M') 'label', DAY(create_date) 'day', COUNT(1) 'n' FROM voter GROUP BY DATE_FORMAT(create_date, '%e %M') ORDER BY 1;");
$stmt1->execute();
$result = $stmt1->fetchAll();
file_put_contents("../php/chart/daily_grow.json", "{\"items\":". json_encode($result). "}");

$stmt1 = $db->prepare("SELECT DATE_FORMAT(create_date, '%e %M') 'label', DAY(create_date) 'day', COUNT(1) 'n' FROM voter where stage='Q14' GROUP BY DATE_FORMAT(create_date, '%e %M') ORDER BY 1;");
$stmt1->execute();
$result = $stmt1->fetchAll();
file_put_contents("../php/chart/daily_vote.json", "{\"items\":". json_encode($result). "}");

$db = null;

?>
