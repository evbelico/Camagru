<?php require_once('html_fragments/header.php'); ?>
    <div id="content">
    <?php if (isset($_SESSION['reset-error']) && !empty($_SESSION['reset-error'])) {
            echo '<ul id="form-messages">';
            foreach ($_SESSION['reset-error'] as $msg)
                echo '<li>'. $msg . '</li>';
            echo '</ul>';
            $_SESSION['reset-error'] = null;
        }?>
		<p class="typewriter">Welcome to Camagru, the filter app !
                <BR />
                Join the community in order to add filters, comment and share with your friends.
                <BR />
                Have a Barackolama as a welcoming token.</p>
                <BR />
                <img width="50%" style="border-width: 50%;" src="/filters/barackolama.jpg" alt="Barack Olama">
                <br/>
    </div>
<?php require_once('html_fragments/footer.php'); ?>