<?php

    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    $membership = new Membership();
    

    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        $membership->log_user_out();
    }
    else if($_SESSION['role']!=2) {
        header("location: ../index.php");
    }

    if(isset($_POST['submit'])) {
        $text = $_POST['announcement'];
        if (get_magic_quotes_gpc()) {
            $text = stripslashes($text);
        } 
        $headers="From: " . $_SESSION['username'] . "@virginia.edu";
        mail("seas-mentorshipexec@virginia.edu", $_POST['subject'], $text, $headers);
        header("location:menteeIndex.php");
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />

<title> Contact Exec</title>

</head>

<body>
    	<!-- header starts here -->
	<div id="header">	
	    <h1 id="logo-text"><a href="../index.php" title="">uva seas mentorship</a></h1>	
	    <p id="slogan">est. 2012</p>				
	</div>	
		
	<!-- navigation starts here -->
                            <div id="leftNav">
                  <ul>
                      <li><a href="mentorIndex.php">Home</a></li>
                      <li><a href="#">Messages</a></li>
                      <li><a href="profile.php">Profile</a></li>
                      <li><a href="#">Log</a></li>
                  </ul>
              </div>
              <div id="rightNav">
                    <ul>
                            <li><a href="../public/logout.php">Logout</a></li>	
                    </ul>
              </div>
	<!-- content-wrap starts here -->
	<div id="content-wrap"><div id="content">	 
	    <div id="sidebar" >	
		<h3>Search Box</h3>	
                    <form action="#" class="searchform">
                            <p>
                                    <input name="search_query" class="textbox" type="text" />
                                    <input name="search" class="button" value="Search" type="submit" />
                            </p>			
                    </form>
				
                    <h3>Sidebar Menu</h3>			
                    <ul class="sidemenu">
                            <li><a href="mentorIndex.php">Mentor Home</a></li>
                            <li><a href="../index.php">Mentorship Home</a></li>
                            <li><a href="contact.php">Contact Exec</a></li>
                            <li><a href="#">Mentor Attendance </a> </li>	
                            <li><a href="../public/calendar.php">Calendar </a> </li>						
                    </ul>		
            </div>
            <div id="main">
               <h2>Contact Exec</h2>
                <form style="padding: 20px;" method="POST">
                     <b>Subject: </b><input style="margin-bottom: 15px;" type="text" name="subject"><br>
                     <b>From: </b><span style="color: #ffffff; font-size: 16px; margin-bottom: 25px;">&nbsp;<? $membership->getMenteeUser($_SESSION['username']); ?> <br></span> <br>
                       <b>Message text: </b><br>
                       <textarea name="announcement" id="announcement" rows="20" style="width: 100%; margin-top: 10px; color: #000000; height: 300px"></textarea> <br><br>
                       <input type="submit" class="button" id="submit" value="Send message" name="submit"/>
                </form> 
            </div>					  
    <!-- content-wrap ends here -->		
    </div></div>

    <!-- footer starts here-->	
    <div id="footer-wrap">
	    <div id="footer-bottom">		
		    <p>
		    &copy; 2013 <strong>UVA SEAS Mentorship</strong> 
		    
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    
		    <a href="index.php">Home</a>&nbsp;|&nbsp;
		    <a href="index.php">Sitemap</a>&nbsp;
		    </p>		
	    </div>	
    <!-- footer ends-->	
</body>
</html>