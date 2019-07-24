<?php
function montage_todatabase($image_path, $userid) {

    require(dirname(__FILE__).'/../config/database.php');

    global $_SESSION;
    var_dump($image_path, $userid);
    try {
        $sql = "INSERT INTO camagru.gallery (`userid`, `img`, `creation_date`) VALUES (:userid, :img, NOW())";
        $request = $cxn->prepare($sql);
        $request->execute(array(':userid' => $userid, ':img' => $image_path));
        echo "Snapshot added to the gallery !\n";
    }
    catch (PDOException $e) {
        echo "The snapshot could not be added to the gallery -->".$e->getMessage()."\n";
    }
}


function count_montages() {
	require(dirname(__FILE__).'/../config/database.php');

	try {
		$sql = "SELECT * FROM camagru.gallery ORDER BY id ASC";
		$request = $cxn->prepare($sql);
		$request->execute();

		$rows = $request->rowCount();
		return ($rows);
	}
	catch (PDOException $e) {
		echo "Could not count rows : ".$e->getMessage()."\n";
	}
}

function get_montages($offset, $per_page) {
    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT * FROM camagru.gallery ORDER BY creation_date DESC LIMIT $offset, $per_page";
        $request = $cxn->prepare($sql);
        $request->execute();

        $tab = null;
        $i = 0;
        while ($result = $request->fetch(PDO::FETCH_ASSOC)) {
            $tab[$i] = $result;
            $i++;
        }
        return ($tab);
    }
    catch (PDOException $e) {
        echo "Could not get latest snapshots : ".$e->getMessage()."\n";
    }
}
?>