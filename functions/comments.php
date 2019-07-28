<?php

function add_comment($poster, $posterid, $userid, $imageid, $text, $snapshot_src) {
    require(dirname(__FILE__).'/../config/database.php');
    require_once(dirname(__FILE__).'/mail.php');

    try {
        $sql = "SELECT id, userid, img FROM camagru.gallery WHERE id=:imageid AND userid=:userid";
        $request = $cxn->prepare($sql);
        $request->execute(array(':imageid' => $imageid, ':userid' => $userid));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $snapshot_src = $result['img'];
            $text = htmlspecialchars($text);
            $sql = "INSERT INTO camagru.comments (userid, imageid, content, creation_date) VALUES (:userid, :imageid, :content, NOW())";
            $request = $cxn->prepare($sql);
            $request->execute(array(':userid' => $posterid, ':imageid' => $imageid, ':content' => $text));

            $sql = "SELECT mail, username FROM camagru.users WHERE id=:userid AND mailing='Y'";
            $request = $cxn->prepare($sql);
            $request->execute(array(':userid' => $userid));
            $result = $request->fetch(PDO::FETCH_ASSOC);

            if ($result > 0) {
                $style_img = 'style="display: block; width: 50%; border-style: solid; border-width: 2%;"';
                $style_comment = 'style="display: block; width: 50%; border-style: solid; border-width: 5px;
                        font-size: 12px;"';
                $class_comment = 'class="typewriter"';
                $picture = '<a href="'. URLROOT .'/snapshots/'. $snapshot_src .'">Your picture</a><br/>';
                $comment = '<p '. $style_comment .' '. $class_comment. ' ><b>'. $poster .'</b> '. $text . '</p>';
                $content = $picture . $comment;
                comment_mail($result['username'], $result['mail'], $content, $poster);
                return (TRUE);
            }
        }
        else {
            header("Location: ../gallery.php?error=nodatafoundforcommenting");
        }     
    }
    catch (PDOException $e) {
        echo "Could not add comment to this picture : ".$e->getMessage()."\n";
    }
}

function get_comments($imageid, $snapshot_src) {
    require(dirname(__FILE__).'/../config/database.php');
    require_once(dirname(__FILE__).'/mail.php');

    try {
        $sql = "SELECT c.id, c.userid, c.imageid, c.content, c.creation_date, u.username FROM camagru.comments AS c, camagru.users AS u, camagru.gallery AS g WHERE g.img = :img AND g.id = :imageid AND c.userid = u.id ORDER BY creation_date ASC";
        $request = $cxn->prepare($sql);
        $request->execute(array(':img' => $snapshot_src, ':imageid' => $imageid));

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
        echo "Could not get latest comments : ". $e->getMessage() ."\n";
    }
}
?>