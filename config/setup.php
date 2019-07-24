<?php

function init() {
	require('database.php');

	#CREATE DATABASE
	try {
		$sql = "CREATE DATABASE IF NOT EXISTS `camagru`";
		$cxn->exec($sql);
		echo "SUCCESS : database created !";
	}
	catch (PDOException $e) {
		echo "FAILURE : Connexion failed " . $e->getMessage() . "\n";
	}

	#CREATE USERS TABLE
	try {
		$sql = "CREATE TABLE IF NOT EXISTS camagru.users (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`username` VARCHAR(50)  NOT NULL UNIQUE,
			`password` VARCHAR(255) NOT NULL,
			`mail` VARCHAR(255) NOT NULL UNIQUE,
			`token` VARCHAR(255) NOT NULL UNIQUE,
			`creation` DATETIME NOT NULL,
			`verified` VARCHAR(1) NOT NULL DEFAULT 'N',
			`mailing` VARCHAR(1) NOT NULL DEFAULT 'Y')";
		$cxn->exec($sql);
		echo "SUCCESS : table 'users' created !";
	}
	catch (PDOException $e) {
		echo "FAILURE : " . $e->getMessage() . "\n";
	}

	#CREATE GALLERY TABLE
	try {
		$sql = "CREATE TABLE IF NOT EXISTS camagru.gallery (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`userid` INT UNSIGNED NOT NULL,
			`img` VARCHAR(255) NOT NULL,
			`creation_date` DATETIME NOT NULL,
			FOREIGN KEY (`userid`) REFERENCES camagru.users(id))";
		$cxn->exec($sql);
		echo "SUCCESS : table 'gallery' created !";
	}
	catch (PDOException $e) {
		echo "FAILURE : " . $e->getMessage() . "\n";
	}

	#CREATE COMMENTS TABLE
	try {
		$sql = "CREATE TABLE IF NOT EXISTS camagru.comments (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`userid` INT UNSIGNED NOT NULL,
			`imageid` INT UNSIGNED NOT NULL,
			`content` VARCHAR(1000) NOT NULL,
			`creation_date` DATETIME NOT NULL,
			FOREIGN KEY (`userid`) REFERENCES camagru.users(id),
			FOREIGN KEY (`imageid`) REFERENCES camagru.gallery(id))";
		$cxn->exec($sql);
		echo "SUCCESS : table 'comments' created !";
	}
	catch (PDOException $e) {
		echo "FAILURE : " . $e->getMessage() . "\n";
	}

	#CREATE LIKES TABLE
	try {
		$sql = "CREATE TABLE IF NOT EXISTS camagru.likes (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`userid` INT UNSIGNED NOT NULL,
			`imageid` INT UNSIGNED NOT NULL,
			`type` VARCHAR(1) NOT NULL,
			`creation_date` DATETIME NOT NULL,
			FOREIGN KEY (`userid`) REFERENCES camagru.users(id),
			FOREIGN KEY (`imageid`) REFERENCES camagru.gallery(id))";
		$cxn->exec($sql);
		echo "SUCCESS : table 'likes' created !";
	}
	catch (PDOException $e) {
		echo "FAILURE : " . $e->getMessage() . "\n";
	}
}

function feed_database() {
	require('database.php');

	### Insert some users inside users table
	try {
		$fakeToken0 = bin2hex(openssl_random_pseudo_bytes(64));
		$fakeToken1 = bin2hex(openssl_random_pseudo_bytes(64));
		$fakeToken2 = bin2hex(openssl_random_pseudo_bytes(64));
		$fakeToken3 = bin2hex(openssl_random_pseudo_bytes(64));

		$pwd0 = password_hash('M*Gust4B4n4n4', PASSWORD_DEFAULT);
		$pwd1 = password_hash('LEEER0Yjenk111ns', PASSWORD_DEFAULT);
		$pwd2 = password_hash('BellaLugosis-Dead16', PASSWORD_DEFAULT);

		$sql = "INSERT INTO camagru.users(`username`, `password`, `mail`, `token`, `creation`, `verified`) VALUES
			('Adminor', '', 'muffinhooker@gmail.com', '$fakeToken0', NOW(), 'Y'),
			('Banana2010', '$pwd0', 'banana2010@hotmail.fr', '$fakeToken1', NOW(), 'Y'),
			('LeeroyJenkins', '$pwd1', 'wowroxxor@yahoo.fr', '$fakeToken2', NOW(), 'Y'),
			('AEonFlux', '$pwd2', 'darkremembrance@gmail.com', '$fakeToken3', NOW(), 'Y')";
		$cxn->exec($sql);
		echo "SUCCESS : random users added !";
	}
	catch (PDOException $e) {
		echo "FAILURE : new users couldnt be added : " . $e->getMessage() . "\nAborting.\n";
	}

	### Insert picture as a test for the gallery table
	/*try {
		$sql = "INSERT INTO camagru.gallery(userid, img, creation_date) VALUES (2, 'img/cactus.png', NOW())";
		$cxn->exec($sql);
		echo "SUCCESS : added first picture to gallery !\n";
	}
	catch (PDOException $e) {
		echo "ERROR : couldnt add first picture to gallery : " . $e->getMessage() . "\nAborting. \n";
	}*/
}
