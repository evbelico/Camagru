<?php require_once('html_fragments/header.php');
if (isset($_SESSION['loggued-on-user']) && !empty($_SESSION['loggued-on-user'])) {
?>
<div id="content">
    <h3 class="login"><?php echo $_SESSION['loggued-on-user'] . ' / ' . $_SESSION['mail']; ?></h3>
    <br />
    <form action="actions/modify.php" method="post">
        <h3>Change my username</h3>
        <br />
        <?php if (isset($_SESSION['mod-username-error']) && !empty($_SESSION['mod-username-error'])) {
                echo '<ul id="form-messages">';
                foreach ($_SESSION['mod-username-error'] as $msg)
                    echo '<li>'. $msg .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-username-error']);
            }
            else if (isset($_SESSION['mod-username-ok']) && !empty($_SESSION['mod-username-ok'])) {
                echo '<ul id="form-successes">';
                echo '<li>'. $_SESSION['mod-username-ok'] .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-username-ok']);
            }
        ?>
        <input type="text" name="new-username" placeholder="New username" required>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <button type="submit" name="username-submit">Change username</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Change my e-mail address</h3>
        <br />
        <?php if (isset($_SESSION['mod-mail-error']) && !empty($_SESSION['mod-mail-error'])) {
                echo '<ul id="form-messages">';
                foreach ($_SESSION['mod-mail-error'] as $msg)
                    echo '<li>'. $msg .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-mail-error']);
            }
            else if (isset($_SESSION['mod-mail-ok']) && !empty($_SESSION['mod-mail-ok'])) {
                echo '<ul id="form-successes">';
                echo '<li>'. $_SESSION['mod-mail-ok'] .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-mail-ok']);
            }
        ?>
        <input type="text" name="new-mail" placeholder="New e-mail" required>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <button type="submit" name="mail-submit">Change e-mail</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Change my password</h3>
        <br />
        <?php if (isset($_SESSION['mod-pwd-error']) && !empty($_SESSION['mod-pwd-error'])) {
                echo '<ul id="form-messages">';
                foreach ($_SESSION['mod-pwd-error'] as $msg)
                    echo '<li>'. $msg .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-pwd-error']);
            }
            else if (isset($_SESSION['mod-pwd-ok']) && !empty($_SESSION['mod-pwd-ok'])) {
                echo '<ul id="form-successes">';
                echo '<li>'. $_SESSION['mod-pwd-ok'] .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-pwd-ok']);
            }
        ?>
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <input type="password" name="new-password" placeholder="New password" required>
        <br />
        <button type="submit" name="password-submit">Change password</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Get comment mails ?</h3>
        <br/>
        <?php if (isset($_SESSION['mod-mailing-ok']) && !empty($_SESSION['mod-mailing-ok'])) {
                echo '<ul id="form-successes">';
                echo '<li>'. $_SESSION['mod-mailing-ok'] .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-mailing-ok']);
            }
            else if (isset($_SESSION['mod-mailing-error']) && !empty($_SESSION['mod-mailing-error'])) {
                echo '<ul id="form-messages">';
                echo '<li>'. $_SESSION['mod-mailing-error'] .'</li>';
                echo '</ul>';
                unset($_SESSION['mod-mailing-error']);
            }
        ?>
        <input type="radio" style="width: 1%" name="get-mails">
        <label for="get-mails">Yes</label>
        <br/>
        <input type="radio" style="width: 1%" name="no-mails">
        <label for="no-mails">No</label>
        <br/>
        <button type="submit" name="mailing-submit">Go</button>
    </form>
    <form action="actions/delete.php" method="post">
        <h3>Delete my account</h3>
        <br />
        <?php if (isset($_SESSION['delete-account-error']) && !empty($_SESSION['delete-account-error'])) {
                echo '<ul id="form-messages">';
                foreach ($_SESSION['delete-account-error'] as $msg)
                    echo '<li>'. $msg .'</li>';
                echo '</ul>';
                unset($_SESSION['delete-account-error']);
            }
        ?>
        <input type="text" name="mail" placeholder="Enter your e-mail address" required>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <input type="password" name="password-confirm" placeholder="Confirm your password" required>
        <br />
        <button type="submit" style="background-color: #FF0000" name="delete-submit">Delete account</button>
    </form>
</div>
<?php } else { header("Location: signin.php"); } ?>
<?php require_once('html_fragments/footer.php'); ?>