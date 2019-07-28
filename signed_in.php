<?php require_once('html_fragments/header.php');
require_once('config/database.php');
require_once('functions/montage.php');
?>
<?php if (isset($_SESSION['loggued-on-user']) && $_SESSION['loggued-on-user'] != '') { ?>
	<div id="main">
		<div id="filter-bar">
			<input type="radio" id="cactus.png" name="img" value="<?php echo URLROOT; ?>filters/oldctus.png" onclick="ifChecked('oldctus.png')">
			<img src="filters/oldctus.png" alt="cactus">
			<br />
			<input type="radio" id="cat_1.png" name="img" value="<?php echo URLROOT; ?>filters/cat_1.png" onclick="ifChecked('cat_1.png')">
			<img src="filters/cat_1.png" alt="black cat">
			<br />
			<input type="radio" id="lamapresident.png" name="img" value="<?php echo URLROOT; ?>filters/old_lamapresident.png" onclick="ifChecked('old_lamapresident.png')">
			<img src="filters/old_lamapresident.png" alt="backolama">
		</div>
        <div class="camera-booth">
            <video id="video" autoplay onclick="this.paused ? this.play() : this.pause();"></video>
			<img id="cactus" src="filters/cactus.png" style="display:none;">
			<img id="cat_1" src="filters/cat_1.png" style="display:none;">
			<div id="capture">
            	<button type="submit" id="capture-btn" value="submit" class="capture-button">Take picture</button>
			</div>
            <canvas id="canvas"></canvas>
			<img id="picture" src="http://placekitten.com/640/480">
			<div id="uploadFile">
				<button type="submit" id="upload-btn" value="submit" class="capture-button">Upload image file</button>
			</div>
			<input type="file" id="inputFile" accept="image/png image/jpeg image/jpg" style="display:none;">
		</div>
	</div>
		<br/>
		<div id="sidebar">
			<div id="snapshots">				
			</div>
		</div>
        <script src="<?php echo URLROOT; ?>javascript/camera.js"></script>
<?php ; } else { header("Location: signin.php"); } ?>
<?php require_once('html_fragments/footer.php'); ?>
