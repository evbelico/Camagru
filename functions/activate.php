<?php
function activate($token) {

	require(dirname(__FILE__).'/../config/database.php');

	if (isset($_GET['token'])) {
		$token = htmlspecialchars(trim($_GET['token']));
		try {
			$sql = "SELECT id, token FROM camagru.users WHERE token=:token";
			$request = $cxn->prepare($sql);
			$request->execute(array(':token' => $token));
			$result = $request->fetch(PDO::FETCH_ASSOC);
			if ($result > 0) {
				$sql = "UPDATE camagru.users SET verified='Y' WHERE id=:id";
				$request = $cxn->prepare($sql);
				$request->execute(array(':id' => $result['id']));
				$_SESSION['valid-token'] = $result['token'];
				return (TRUE);
			}
			else if ($result['verified'] == 'Y')
				return (FALSE);
		}
		catch (PDOException $e) {
			echo "FAILURE : " . $e->getMessage() . "\n";
		}
	}
	else
		header("Location: ../register.php?error=tokennotfound");
}

function forgot_token($token) {

	require(dirname(__FILE__).'/../config/database.php');

	if (isset($_GET['reset'])) {
		$token = htmlspecialchars($_GET['reset']);
		try {
			$sql = "SELECT id, mail, `password` FROM camagru.users WHERE `password`=:pass";
			$request = $cxn->prepare($sql);
			$request->execute(array(':pass' => $token));
			$result = $request->fetch(PDO::FETCH_ASSOC);
			if ($result > 0) {
				$_SESSION['forgot-token'] = $result['password'];
				return (TRUE);
			}
			return (FALSE);
		}
		catch (PDOException $e) {
			echo "ERROR : could not fetch one-time token from database : ". $e->getMessage() ."\nAborting.\n";
		}
	}
}
?>
