<?php
function add_like($liker, $likerid, $userid, $imageid, $type, $snapshot) {

    require(dirname(__FILE__).'/../config/database.php');
    session_start();

    try {
        $sql = "SELECT id, userid, img FROM camagru.gallery WHERE id=:imageid AND userid=:userid AND img=:img";
        $request = $cxn->prepare($sql);
        $request->execute(array(':imageid' => $imageid, ':userid' => $userid, ':img' => $snapshot));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $sql = "SELECT userid, imageid, `type` FROM camagru.likes WHERE userid=:userid AND imageid=:imageid";
            $request = $cxn->prepare($sql);
            $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
            $row = $request->fetch(PDO::FETCH_ASSOC);
            if ($row > 0) {
                if ($row['type'] == null) {
                    $sql = "UPDATE camagru.likes SET `type`='L' WHERE imageid=:imageid AND userid=:userid";
                    $request = $cxn->prepare($sql);
                    $request->execute(array(':imageid' => $imageid, ':userid' => $likerid));
                    echo "SUCCESS : snapshot liked again.\n";
                }
            }
            else {
                $sql = "INSERT INTO camagru.likes (userid, imageid, `type`, creation_date) VALUES (:userid, :imageid, 'L', NOW())";
                $request = $cxn->prepare($sql);
                $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
                echo "SUCCESS : snapshot liked !\n";
            }
        }
        else {
            header("Location: ../gallery.php?error=nodatafoundforliking");
        }
    }
    catch (PDOException $e) {
        echo "Snapshot could not be liked : ". $e->getMessage() . '\nOperation aborted.\n';
    }
}

function add_dislike($liker, $likerid, $userid, $imageid, $type, $snapshot) {

    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT id, userid, img FROM camagru.gallery WHERE id=:imageid AND userid=:userid AND img=:img";
        $request = $cxn->prepare($sql);
        $request->execute(array(':imageid' => $imageid, ':userid' => $userid, ':img' => $snapshot));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $sql = "SELECT userid, imageid, `type` FROM camagru.likes WHERE userid=:userid AND imageid=:imageid AND `type`='L'";
            $request = $cxn->prepare($sql);
            $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
            $row = $request->fetch(PDO::FETCH_ASSOC);
            if ($row > 0) {
                //if ($row['type'] == 'L') {
                    $sql = "UPDATE camagru.likes SET `type`=null WHERE imageid=:imageid AND userid=:userid";
                    $request = $cxn->prepare($sql);
                    $request->execute(array(':imageid' => $imageid, ':userid' => $userid));
                    echo "SUCCESS : snapshot DISliked again.\n";
                //}
            }
            /*else {
                $sql = "INSERT INTO camagru.likes (userid, imageid, `type`, creation_date) VALUES (:userid, :imageid, 'D', NOW())";
                $request = $cxn->prepare($sql);
                $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
                echo "SUCCESS : snapshot liked !\n";
            }*/
        }
        else {
            header("Location: ../gallery.php?error=nodatafoundforliking");
        }
    }
    catch (PDOException $e) {
        echo "Snapshot could not be disliked : ". $e->getMessage() . '\nOperation aborted.\n';
    }
}
?>