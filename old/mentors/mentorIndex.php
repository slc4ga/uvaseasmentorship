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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />

<title> Mentor Home</title>

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
                      <li id="current"><a href="mentorIndex.php">Home</a></li>
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
                <?
                     $announce = $membership->getNumAnnouncements();
                     $count = 0;
                     if($announce == 0) {  }
                     for($i; $i < $announce; $i++) {
                          $next = $membership->getAnnouncementPostTo($i);
                          if(false !== strpos($next, 'Mentors@') && count < 15) {
                            $next = $membership->getAnnouncementSubject($i);
                            echo "<h2>$next</h2>";
                          
                            $next = $membership->getAnnouncementPostBy($i);
                            $name = $membership->returnExecUser($next);
                            echo "<p><span style=\"color: $ffffff\"><b>Posted by: &nbsp;</b></span>$name <br>";
                            $next = $membership->getAnnouncementPostTo($i);
                            if(false !== strpos($next, 'Mentors@')) {
                                echo "<span style=\"color: $ffffff; margin-top: -10px\"><b>Posted to: &nbsp;</b></span>Mentors";
                            }
                            echo "</p>";
                            $next = $membership->getAnnouncementText($i);
                            echo "<p  style=\"color: #ffffff\">$next</p><br>";

                            $next = $membership->getAnnouncementDate($i);
                            echo "<p class=\"post-footer align-right\"> <span class=\"date\">$next</span></p>";

                            echo "<br /> <br>";
                            $count++;
                          }
                     }
                     if($count == 0) { echo "<h2><center>No new announcements right now.</h2>"; } 
                ?>									  
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