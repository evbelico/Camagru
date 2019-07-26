<?php
require_once('html_fragments/header.php');
?>
<div id="content">
        <h3>Sign-in</h3>

        <form action="actions/signin.php" method="post">
        <?php if (isset($_SESSION['signin-msg']) && !empty($_SESSION['signin-msg'])) {
            echo '<ul id="form-messages">';
            echo '<li>'. $_SESSION['signin-msg'] .'</li>';
            echo '</ul>';
            unset($_SESSION['signin-msg']);
        }?>
        <div class="typewriter">
            <label for="mail">E-mail</label><br/>
            <input class="typewriter" type="text" name="mail" placeholder="E-mail" required>
            <br />
            <label for="Password">Password</label><br/>
            <input class="typewriter" type="password" name="password" placeholder="Password" required>
            <br/>
            <button type="submit" name="login-submit">Submit</button>
            <br/>
            <a style="text-align: right;" href="forgot.php">Forgot password ?</a>
        </div>
        </form>
    </div>
</div>
<?php require_once('html_fragments/footer.php') ?>