<?php

$cycle_volume=1500;
$batch_volume=29;
$batch_wait=200000;

$batch_count=$batch_volumn;

require('../php/inc.php');
require('module.php');

$db = getDb();
$stmt1 = $db->prepare("select * from bulk where status != 0 order by bulk_id, lang limit :cycle_volume");
$stmt1->execute(array($cycle_volume));

$i_bulk_id=null;
$i_lang=null;
while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        echo "bulk_id=". $row["bulk_id"]. " chat_id=". $row["chat_id"]. " lang=". $row["lang"]. " status=". $row["status"]. " last_modified_date=". $row["last_modified_date"]. "\n";
        if ( $row["bulk_id"] != $i_bulk_id || $row["lang"] != i_lang ) {
                $stmt2 = $db->prepare("select * from media_content where bulk_id=:bulk_id and lang in ('*', :lang) order by lang desc limit 1");

                $stmt2->bindValue(1, $row["bulk_id"]);
                $stmt2->bindParam(2, $row["lang"], PDO::PARAM_STR);
                $stmt2->execute();
                $media = $stmt2->fetch(PDO::FETCH_ASSOC);
                echo "bulk_id=". $media["bulk_id"]. " media_type=". $media["media_type"]. " lang=". $media["lang"]. " media_status=". $media["media_status"]. "\n";
                $i_bulk_id = $row["bulk_id"];
                $i_lang = $row["lang"];
        }

        if ( $media["media_status"] == 3 ) {
                $response=sendMessage($row["chat_id"], $media["media_content"], BOT_TOKEN);
                $result = json_decode($response, true);
                echo "OK:". $result["ok"];
                echo $result;
        }

        if ( $batch_count == 0 ) {
                usleep($batch_wait);
                $batch_count=$batch_volumn;
        } else {
                $batch_count--;
        }
}

$db = null;

?>

