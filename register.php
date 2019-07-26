<?php
require_once('html_fragments/header.php');
error_reporting(E_ALL);
?>
<div id="content">
        <h3>Registration</h3>
        <form action="actions/register.php" method="post">
        <?php if (isset($_SESSION['register-msg']) && !empty($_SESSION['register-msg'])) {
            echo '<ul id="form-messages">';
            foreach ($_SESSION['register-msg'] as $msg)
                echo '<li>'. $msg . '</li>';
            echo '</ul>';
            $_SESSION['register-msg'] = null;
        }?>
        <div class="typewriter">
                <label for="uname">Username</label><br/>
                <input type="text" id="username" name="username" placeholder="SlimShady" required>
                <br/>
                <label for="mail">E-mail</label><br/>
                <input type="text" id="mail" name="mail" placeholder="slimshady@protonmail.com" required>
                <br/>
                <label for="pwd">Password</label><br/>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <br/>
                <label for="pwd-confirm">Confirm password</label><br/>
                <input type="password" id="password-confirm" name="password-confirm" placeholder="Confirm your password" required>
                <br/>
                <button type="submit" id="btn-submit" name="register-submit">Register</button>
        </form>
    </div>
</div>
<?php require_once('html_fragments/footer.php');