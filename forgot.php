<?php require_once(dirname(__FILE__).'/html_fragments/header.php'); ?>
<div id="content">
    <div class="typewriter">
        <h3>Forgot password</h3>

        <form action="actions/forgot.php" method="post">
            <label for="mail">E-mail</label>
            <br />
            <input class="typewriter" type="text" name="mail" placeholder="Enter your e-mail address" required>
            <br />
            <button type="submit" name="forgot-submit">Send me a reset link !</button>
        </form>
    </div>
</div>
<?php require_once(dirname(__FILE__).'/html_fragments/footer.php'); ?>