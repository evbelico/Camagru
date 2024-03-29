<?php require_once('html_fragments/header.php');
require_once('functions/activate.php');
require_once('config/database.php'); ?>

    <?php if (forgot_token($_GET['reset']) == TRUE) { ?>
        <div id="content">
            <form action="actions/forgot.php" method="post">
            <?php if (isset($_SESSION['reset-error']) && !empty($_SESSION['reset-error'])) {
            echo '<ul id="form-messages">';
            foreach ($_SESSION['reset-error'] as $msg)
                echo '<li>'. $msg . '</li>';
            echo '</ul>';
            $_SESSION['reset-error'] = null;
            }?>
            <div class="typewriter">
                <h3>Password reset</h3><br/>
                <label for="mail">E-mail</label><br/>
                <input class="typewriter" id="e-mail" type="text" name="mail" placeholder="E-mail" required>
                <br />
                <label for="Password">Password</label><br/>
                <input class="typewriter" id="pwd" type="password" name="password-reset" placeholder="Enter new password" required>
                <br/>
                <label for="Password-confirm">Confirm password</label><br/>
                <input class="typewriter" id="pwd-confirm" type="password" name="password-reset-confirm" placeholder="Enter new password again" required>
                <br/>
                <button id="submit-btn" type="submit" name="reset-submit">Submit</button>
            </form>
            </div>
        </div>
        <!-- <script type="text/javascript" src="<?php echo URLROOT ?>javascript/password.js"></script> -->
    <?php } else { header("Location: ../forgot.php?error=notallowed"); } ?>
<?php require_once('html_fragments/footer.php'); ?>