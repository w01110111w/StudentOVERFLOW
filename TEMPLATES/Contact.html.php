<div class="center-form">
    <h2 class="page-title">Contact the wonderful admins of Student Overflow!</h2>
    <p class="error-text">Please note this will only work on localhost and not on the I drive as it is using the GMAIL SMTP server!</p>
    <form action="" method="post">
        <label for="Nickname">Name</label>
        <?php if (empty($name)): ?>
            <input type="text" id="Nickname" name="Nickname" placeholder="Your name...">
        <?php else: ?>
            <input type="text" id="Nickname" name="Nickname" value="<?php echo $name;?>" readonly placeholder="Your name...">
        <?php endif; ?>
        <label for="Topic">Topic</label>
        <select id="Topic" name="Topic">
            <option>General inquiry</option>
            <option>Bug report</option>
            <option>Request for new module</option>
            <option>Request for becoming an admin</option>
            <option>Report site misuse</option>
            <option>Privacy policy</option>
            <option>Terms and conditions</option>
        </select>

        <label for="Subject">Subject</label>
        <input type="text" id="Subject" name="Subject" placeholder="Type your subject here...">

        <label for="Message">Message</label>
        <textarea id="Message" name="Message" placeholder="Type your message here..." style="height:200px"></textarea>

        <input type="submit" value="Submit">

    </form>
</div>