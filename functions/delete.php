<?php
function delete_account($userid, $mail, $password, $password_confirm) {

    require(dirname(__FILE__).'/../config/database.php');
    
    try {
        $sql = "SELECT * FROM camagru.users WHERE mail=:mail AND id=:id";
        $request = $cxn->prepare($sql);
        $request->execute(array(':mail' => $mail, ':id' => $userid));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            if (password_verify($password, $result['password']) == TRUE) {
                $sql = "DELETE FROM camagru.likes WHERE userid=:userid";
                $request = $cxn->prepare($sql);
				$request->execute(array(':userid' => $result['id']));
				$sql = "DELETE FROM camagru.comments WHERE userid=:userid";
				$request = $cxn->prepare($sql);
				$request->execute(array(':userid' => $result['id']));
				$sql = "DELETE FROM camagru.gallery WHERE userid=:userid";
				$request = $cxn->prepare($sql);
                $request->execute(array(':userid' => $result['id']));
                $sql = "DELETE FROM camagru.users WHERE id=:id";
                $request = $cxn->prepare($sql);
                $request->execute(array(':id' => $result['id']));
                return (TRUE);
            }
            else {
                header("Location: ../users.php?error=wrongpassword");
            }
        }
    }
    catch (PDOException $e) {
        echo "Account could not be deleted : " . $e->getMessage() . "\nTry again.\n";
    }
}

function delete_content($userid, $imageid, $snapshot) {

    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT * FROM camagru.likes WHERE imageid=:imageid";
        $request = $cxn->prepare($sql);
        $request->execute(array(':imageid' => $imageid));
        $resultLikes = $request->fetch(PDO::FETCH_ASSOC);
        if ($resultLikes > 0) {
            $sql = "DELETE FROM camagru.likes WHERE imageid=:imageid";
            $request = $cxn->prepare($sql);
            $request->execute(array(':imageid' => $imageid));
        }

        $sql = "SELECT * FROM camagru.comments WHERE imageid=:imageid";
        $request = $cxn->prepare($sql);
        $request->execute(array(':imageid' => $imageid));
        $resultComments = $request->fetch(PDO::FETCH_ASSOC);
        if ($resultComments > 0) {
            $sql = "DELETE FROM camagru.comments WHERE imageid=:imageid";
            $request = $cxn->prepare($sql);
            $request->execute(array(':imageid' => $imageid));
        }
        
        $sql = "SELECT * FROM camagru.gallery WHERE userid=:userid AND id=:id";
        $request = $cxn->prepare($sql);
        $request->bindParam(':id', $imageid, PDO::PARAM_INT);
        $request->bindParam(':userid', $userid, PDO::PARAM_INT);
        $request->execute();
        $resultSnapshots = $request->fetch(PDO::FETCH_ASSOC);
        if ($resultSnapshots > 0) {
            $sql = "DELETE FROM camagru.gallery WHERE id=:id AND userid=:userid";
            $request = $cxn->prepare($sql);
            $request->execute(array(':id' => $imageid, ':userid' => $userid));
        }
        return (TRUE);
    }
    catch (PDOException $e) {
        echo "ERROR : could not delete your snapshot and its linked content : ". $e->getMessage() ."\nAborting.\n";
    }
}
?>
