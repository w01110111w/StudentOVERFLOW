<h2 class="page-title">Sign up to Student Overflow now!</h2>
<form action="" method="post">
    <?php if ($cookiesAccepted): ?>
        <label for="Username">Create an Username:
            <input required value="<?= isset($_POST['Username']) ? $_POST['Username'] : ''; ?>" type="text" name="Username" id="Username" minlength="3" maxlength="10"></label><br />
        <label for="Password">Create a Password:
            <input required type="password" name="Password" id="Password" minlength="8" maxlength="64"></label><br />
        <label for="Firstname">What's your Firstname?
            <input required value="<?= isset($_POST['Firstname']) ? $_POST['Firstname'] : ''; ?>" type="text" name="Firstname" id="Firstname" minlength="2" maxlength="40"></label><br />
        <label for="Surname">What's your Surname?
            <input required value="<?= isset($_POST['Surname']) ? $_POST['Surname'] : ''; ?>" type="text" name="Surname" id="Surname" minlength="2" maxlength="40"></label><br />
        <label for="Email">Your Email:
            <input required value="<?= isset($_POST['Email']) ? $_POST['Email'] : ''; ?>" type="email" name="Email" id="Email"></label><br />
        <input type="submit" value="Sign Up">
    <?php else: ?>
        <label for="Username">Create an Username:
            <input required disabled type="text" name="Username" id="Username" minlength="3" maxlength="10"></label><br />
        <label for="Password">Create a Password:
            <input required disabled type="password" name="Password" id="Password" minlength="8" maxlength="64"></label><br />
        <label for="Firstname">What's your Firstname?
            <input required disabled type="text" name="Firstname" id="Firstname" minlength="2" maxlength="40"></label><br />
        <label for="Surname">What's your Surname?
            <input required disabled type="text" name="Surname" id="Surname" minlength="2" maxlength="40"></label><br />
        <label for="Email">Your Email:
            <input required disabled type="email" name="Email" id="Email"></label><br />
        <input type="submit" value="Sign Up">
    <?php endif; ?>
</form>