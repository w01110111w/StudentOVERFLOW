<h2 class="page-title">Log In to Student Overflow</h2>
<div>
    <p>New to Student Overflow? Create an account <a href="SignUp.php"><strong>here</strong></a>!</p>
</div>
<div class="centered">
    <form action="" method="post">
    <?php if ($cookiesAccepted): ?>
            <label for="UsernameOrEmail">Your Username or Email:
            <input type="text" name="UsernameOrEmail" id="Username" minlength="3"></label><br />
            <label for="Password">Your Password:
                <input type="password" name="Password" id="Password" minlength="8" maxlength="64"></label><br />
            <input type="submit" value="Log In">
        <?php else: ?>
            <label for="UsernameOrEmail">Your Username or Email:
            <input disabled type="text" name="UsernameOrEmail" id="Username" minlength="3"></label><br />
            <label for="Password">Your Password:
                <input disabled type="password" name="Password" id="Password" minlength="8" maxlength="64"></label><br />
            <input disabled type="submit" value="Log In">
        <?php endif; ?>
    </form>
</div>