<?php
require_once('html_fragments/header.php');
?>
<div id="content">
    <div class="typewriter">
        <h3>Sign-in</h3>

        <form action="actions/signin.php" method="post">
            <label for="mail">E-mail</label><br/>
            <input class="typewriter" type="text" name="mail" placeholder="E-mail" required>
            <br />
            <label for="Password">Password</label><br/>
            <input class="typewriter" type="password" name="password" placeholder="Password" required>
            <br/>
            <button type="submit" name="login-submit">Submit</button>
            <br/>
            <a style="text-align: right;" href="forgot.php">Forgot password ?</a>
        </form>
    </div>
</div>
<?php require_once('html_fragments/footer.php') ?>