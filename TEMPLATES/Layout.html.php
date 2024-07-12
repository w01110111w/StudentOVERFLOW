<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title)) ? $title : "STUDENT OVERFLOW"?></title>
    <link rel="Stylesheet" href="Style.css">
</head>

<body>
    <header>
        <div style="text-align: center;">
            <a href="Index.php">
                <img style="margin-left: -20px" src="INCLUDES\sitelogo.gif" width ="600" height="300">
            </a>
        </div>
    </header><!--<h1>STUDENT OVERFLOW &lt;/&gt;</h1>-->
    <nav class="<?php if (isset($navbarClass)) echo $navbarClass; ?>">
        <ul>
            <li <?php if ($currentPage == "Index.php") {echo 'class="active-link"';}?>><a href="index.php"><b>Home</b></a></li>
            <li <?php if ($currentPage == "Posts.php") {echo 'class="active-link"';}?>><a href="Posts.php"><b>All Posts </b></a></li> 
            <li <?php if ($currentPage == "QuestionAdd.php") {echo 'class="active-link"';}?>><a href="QuestionAdd.php"><b> New Post</b></a></li>
            <?php if ($isLoggedIn): ?>
                <li <?php if ($currentPage == "MyPosts.php") {echo 'class="active-link"';}?>><a href="MyPosts.php"><b>My Posts</b></a></li>
            <?php endif; ?>
            <li <?php if ($currentPage == "Modules.php") {echo 'class="active-link"';}?>><a href="Modules.php"><b>Modules</b></a></li>
            <?php if ($isAdmin): ?>
            <li <?php if ($currentPage == "ModuleAdd.php") {echo 'class="active-link"';}?>><a href="ModuleAdd.php"><b>New Module</b></a></li>
            <?php endif; ?>
            <li <?php if ($currentPage == "Account") {echo 'class="active-link"';}?>><a href="<?php echo ($isLoggedIn) ? "MyAccount.php" : "LogIn.php"; ?>"><b>Account</b></a></li>
            <li <?php if ($currentPage == "Contact.php") {echo 'class="active-link"';}?>><a href="Contact.php"; ?><b>Contact Us</b></a></li>
            <li <?php if ($currentPage == "AdminArea.php") {echo 'class="active-link"';}?>><a href="AdminArea.php"; ?><b>Admin Area</b></a></li>
        </ul>
    </nav>
    <main <?php if (isset($mainClass)) echo 'class="'.$mainClass.'"'; ?>>
        <?=$output?>
    </main>
    <?php if ($showCookiesPopup): ?>
        <div class="cookie-section">
            <div class="aligned-title">
                <img class="cookie-image" src="INCLUDES/cookie.png">
                <h2 class="cookie-title">Fancy some cookies?</h2>
                <form action="" method="post">
                    <button name="CookieAccept" type="submit" class="accept-blue-pill">Accept<i></i></button>
                    <button name="CookieReject" type="submit" class="accept-red-pill">Reject<i></i></button>
                </form>
            </div>
            <div class="cookie-description">
            <p>This site is making use of cookies for making your experience nice & smoothie (see what I did there?). This only includes essential functional cookies for things like logging in. We are unfortunately not tracking you yet - we haven't done that part but we look forward to it!.</p>
            <p>In any case, cookies are sweet, so accept them please?</p>
            </div>
        </div>
    <?php endif; ?>
    <footer>&copy; IJDB 2023</footer>
</body>
</html>