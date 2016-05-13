<?php

$cycle_volume=1500;
$batch_volume=29;
$batch_wait=200000;
$SLIENT=true;

require('../php/inc.php');
require('module.php');

// if (midnight()) return;

$db = getDb();
$stmt1 = $db->prepare("select * from bulk where status = 1 order by bulk_id, lang limit :cycle_volume");
$stmt1->execute(array($cycle_volume));

$batch_count=$batch_volume;
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
                $stmt3 = $db->prepare("update `bulk` set status=:status, response=:response, last_modified_date=CURRENT_TIMESTAMP where bulk_id=:bulk_id and chat_id=:chat_id");
                $stmt3->bindValue(1, 2);
                $stmt3->bindValue(2, NULL);
                $stmt3->bindValue(3, $row["bulk_id"]);
                $stmt3->bindValue(4, $row["chat_id"]);
                $stmt3->execute();

                $content = bind_vars($media["media_content"], array('count'=>$batch_count));

                if ($SLIENT) {
                        $response=sendMessage($row["chat_id"], $content, BOT_TOKEN, false);
                } else {
                        $response=sendMessage($row["chat_id"], $content, BOT_TOKEN, !midnight());
                }
                $stmt3->bindValue(2, $response);
                $result = json_decode($response, true);
                if ( $result["ok"] ) {
                        echo "Content sent okay - $batch_count\n";
                        $stmt3->bindValue(1, 0);
                        $stmt3->execute();
                } else {
                        echo "Content sent fail - $batch_count\n";
                        $stmt3->bindValue(1, 3);
                        $stmt3->execute();
                }

                $batch_count--;
                if ( $batch_count <= 0 ) {
                        usleep($batch_wait);
                        $batch_count=$batch_volume;
                }

        } else {
                echo "Content skip\n";
        }

}

$db = null;

?>
