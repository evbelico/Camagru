<?php
function imagecopymergealpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
	$cut = imagecreatetruecolor($src_w, $src_h); 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
}

function init_montage($path, $filter, $image_path) {
	
	require_once(dirname(__FILE__).'/../config/database.php');
	require_once(dirname(__FILE__).'/montage_todatabase.php');

	$template = imagecreatefrompng($path);
	$mod = imagecreatefrompng(dirname(__FILE__).'/..'.$filter);

	$width_template = imagesx($template);
	$height_template = imagesy($template);
	$width_mod = imagesx($mod);
	$height_mod = imagesy($mod);

	$width_dest = $width_template - $width_mod;
	$height_dest = $height_template - $height_mod;

	imagecopymergealpha($template, $mod, $width_dest, $height_dest, 0, 0, $width_template, $height_template, 100);
	imagepng($template, $path);
	$userid = $_SESSION['userid'];
	montage_todatabase($image_path, $userid);
}

function create_miniature($path) {

	require_once(dirname(__FILE__).'/montage_todatabase.php');
	$source = imagecreatefrompng($path);
	$width_source = imagesx($source);
	$height_source = imagesy($source);

	$miniature = imagecreatetruecolor($width_source / 2, $height_source / 2);
	$width_miniature = imagesx($miniature);
	$height_miniature = imagesy($miniature);

	imagecopyresampled($miniature, $source, 0, 0, 0, 0, $width_miniature, $height_miniature, $width_source, $height_source);
	$miniature64 = str_replace($_SESSION['loggued-on-user'], $_SESSION['loggued-on-user'].'-MiniatureUnsaved', $path);
	imagepng($miniature, $miniature64);
}

function display_miniatures() {
	$username = htmlspecialchars($_SESSION['loggued-on-user']);
	$miniature64_path = dirname(__FILE__).'/snapshots/';
	$regex_miniature = preg_match('/^'.$username.'-MiniatureUnsaved-$/', $miniature64_path);
	$tab = array();
	$index = 0;
	while ($regex_miniature[$index]) {
		$tab[$index] = $regex_miniature[$index];
		$index++;
	}
	return ($tab);
}

function delete_montage($image) {
	imagedestroy($image);
}