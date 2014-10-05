<?php
    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    $membership = new Membership();
    
    // check to see if the user entered a username and password
    if($_POST && !empty($_POST['username'])) {
        // validate data
        $response = $membership->recordAttendance($_POST['username'], '9/15'); 
        header("location: ../index.php");
    }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <title> Pizza Party RSVP (9/15) </title>
</head>

<body>
<div id="login">
    <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>";
    ?>
    <form method="post" action="">
        <h2>RSVP</h2>
        <p> If you're able to attend the SEAS Mentorship Kickoff event, please type your username in below. Mentors, remember this event is <b>mandatory</b>. Please email <a href="mailto:seas-mentorshipexec@virginia.edu?subject=Mentor Training">Exec</a> if you are unable to attend.</p>
        <p>
            <label for="name" style="color:#000000" >Username: </label>
            <input type="text" name="username" />
        </p>       
        <p>
            <input type="submit" class="button" id="submit" value="Submit" name="submit" />
        </p>
        
    </form>
</div> <!------ end login ----->
</body>
</html>