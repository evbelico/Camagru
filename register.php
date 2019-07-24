<?php
require_once('html_fragments/header.php');
?>
<div id="content">
    <div class="typewriter">
        <h3>Registration</h3>

        <form action="actions/register.php" method="post">
            <label for="uname">Username</label><br/>
            <input type="text" name="username" placeholder="SlimShady" required>
            <br/>
            <label for="mail">E-mail</label><br/>
            <input type="text" name="mail" placeholder="slimshady@protonmail.com" required>
            <br/>
            <label for="pwd">Password</label><br/>
            <input type="password" name="password" placeholder="Enter password" required>
            <br/>
            <label for="pwd-confirm">Confirm password</label><br/>
            <input type="password" name="password-confirm" placeholder="Confirm your password" required>
            <br/>
            <button type="submit" name="register-submit">Register</button>
        </form>
    </div>
</div>
<?php require_once('html_fragments/footer.php');