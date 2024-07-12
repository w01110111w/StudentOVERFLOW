<div style="display: flex; margin-bottom: 20px;">
    <div style="flex: 1; padding: 10px; background: #ddd; margin-right: 10px;">
        <h2 class="page-title">My Account Details</h2>
        <form action="" method="post">
            <label for="Username">Username:
                <input required value="<?php echo $user["Username"]; ?>" type="text" name="Username" id="Username" minlength="3" maxlength="10" disabled></label><br />
            <label for="Firstname">Firstname:
                <input required value="<?php echo $user["Firstname"]; ?>"type="text" name="Firstname" id="Firstname" minlength="2" maxlength="40"></label><br />
            <label for="Surname">Surname:
                <input required value="<?php echo $user["Surname"]; ?>"type="text" name="Surname" id="Surname" minlength="2" maxlength="40"></label><br />
            <label for="Email">Your Email:
                <input required value="<?php echo $user["Email"]; ?>"type="email" name="Email" id="Email"></label><br />
            <input type="submit" value="Save">
        </form>
    </div>
    <div style="flex: 1; margin-left: 10px;">
        <div style="margin-bottom: 10px; background: #ddd; padding: 10px;">
            <h2 class="page-title">Account Actions</h2>
            <form onsubmit="return confirm('Are you sure you want to delete your account? All your questions and comments will be removed!');" action="" method="post">
                <input style="background: rgb(240, 80, 80); color: white;" type="submit" name="DeleteAccount" value="Delete Account">
            </form>
            <form action="" method="post">
                <input type="submit" name="LogOut" value="Log Out">
            </form>
        </div>
        <div style="margin-top: 10px; background: #ddd; padding: 10px;">
            <h2 class="page-title">Change Password</h2>
            <?php if(isset($_SESSION["PasswordError"])):?>
                <div> <?=$_SESSION["PasswordError"] ?> </div>
            <?php endif; $_SESSION["PasswordError"] = null; ?>
            <form action="" method="post">
                <label for="OldPassword">Your current password:
                    <input required type="password" name="OldPassword" id="Password" minlength="8" maxlength="64"></label><br />
                <label for="NewPassword">New password:
                    <input required type="password" name="NewPassword" id="Password" minlength="8" maxlength="64"></label><br />
                <input type="submit" value="Change Password">
            </form>
        </div>
    </div>
</div>