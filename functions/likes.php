<?php
function add_like($likerid, $userid, $imageid, $snapshot) {

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
                if ($row['type'] == 'D') {
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
        else
            return (FALSE);
    }
    catch (PDOException $e) {
        echo "Snapshot could not be liked : ". $e->getMessage() . '\nOperation aborted.\n';
    }
}

function add_dislike($likerid, $userid, $imageid, $snapshot) {

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
                if ($row['type'] == 'L') {
                    $sql = "UPDATE camagru.likes SET `type`='D' WHERE imageid=:imageid AND userid=:userid";
                    $request = $cxn->prepare($sql);
                    $request->execute(array(':imageid' => $imageid, ':userid' => $userid));
                    echo "SUCCESS : snapshot disliked again.\n";
                }
            }
            else {
                $sql = "INSERT INTO camagru.likes (userid, imageid, `type`, creation_date) VALUES (:userid, :imageid, 'D', NOW())";
                $request = $cxn->prepare($sql);
                $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
                echo "SUCCESS : snapshot disliked !\n";
            }
        }
        else
            return (FALSE);
    }
    catch (PDOException $e) {
        echo "Snapshot could not be disliked : ". $e->getMessage() . '\nOperation aborted.\n';
    }
}

function get_likes($likerid, $imageid) {
    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT imageid, `type` FROM camagru.likes WHERE userid=:userid AND imageid=:imageid";
        $request = $cxn->prepare($sql);
        $request->execute(array(':userid' => $likerid, ':imageid' => $imageid));
        
        $tab = null;
        $i = 0;
        while ($result = $request->fetch(PDO::FETCH_ASSOC)) {
            $tab[$i] = $result;
            $i++;
        }
        $tab[$i] = null;
        return ($tab);
    }
    catch (PDOException $e) {
        echo "ERROR : could not get likes : ". $e->getMessage()."\nAborting.\n";
    }
}

function get_nb_likes($imageid) {
    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT `type` FROM camagru.likes, camagru.gallery WHERE camagru.likes.imageid=camagru.gallery.id AND camagru.gallery.id=$imageid AND `type`='L'";
        $request = $cxn->prepare($sql);
        $request->execute();
        
        $i = 0;
        while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        }
        return($i);
    }
    catch (PDOException $e) {
        echo "ERROR : could not get number of likes :\n". $e->getMessage() ."\nAborting.\n";
    } 
}

function get_nb_dislikes($imageid) {
    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT `type` FROM camagru.likes, camagru.gallery WHERE camagru.likes.imageid=camagru.gallery.id AND camagru.gallery.id=$imageid AND `type`='D'";
        $request = $cxn->prepare($sql);
        $request->execute();

        $i = 0;
        while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        }
        return($i);
    }
    catch (PDOException $e) {
        echo "ERROR : could not get number of likes :\n". $e->getMessage() ."\nAborting.\n";
    } 
}
?>