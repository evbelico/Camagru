<?php require_once('html_fragments/header.php');
if (isset($_SESSION['loggued-on-user']) && $_SESSION['loggued-on-user'] != "") {
?>
<div id="content">
    <h3 class="login"><? echo $_SESSION['loggued-on-user']; ?></h3>
    <br />
    <form action="actions/modify.php" method="post">
        <h3>Change my username</h3>
        <br />
        <input type="text" name="username" placeholder="Username" required>
        <br />
        <input type="text" name="new-username" placeholder="New username" required>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <button type="submit" name="username-submit">Change username</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Change my e-mail address</h3>
        <br />
        <input type="text" name="mail" placeholder="E-mail" required>
        <br />
        <input type="text" name="new-mail" placeholder="New e-mail" required>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <button type="submit" name="mail-submit">Change e-mail</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Change my password</h3>
        <br />
        <input type="password" name="password" placeholder="Password" required>
        <br />
        <input type="password" name="new-password" placeholder="New password" required>
        <br />
        <button type="submit" name="password-submit">Change password</button>
    </form>
    <form action="actions/modify.php" method="post">
        <h3>Get comment mails ?</h3>
        <br/>
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