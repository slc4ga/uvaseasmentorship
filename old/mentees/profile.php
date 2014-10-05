<?php

    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    $membership = new Membership();
    

    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        $membership->log_user_out();
    }
    else if($_SESSION['role']!=3) {
        header("location: ../index.php");
    }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />

<title> Mentee Profile</title>

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
                      <li><a href="menteeIndex.php">Home</a></li>
                      <li><a href="#">Messages</a></li>
                      <li  id="current"><a href="profile.php">Profile</a></li>
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
                            <li><a href="menteeIndex.php">Mentee Home</a></li>
                            <li><a href="../index.php">Mentorship Home</a></li>
                            <li><a href="contact.php">Contact Exec</a></li>
                            <li><a href="#">Mentee Attendance </a> </li>
                            <li><a href="../public/calendar.php">Calendar </a> </li>							
                    </ul>		
            </div>
            <div id="main">									 
            <br>
            <br>
            <?
                 $imgPath=$membership->getMenteePhoto($_SESSION['username']);
                 echo "<img src=\"$imgPath\" height=\"225\" width=\"175\" style=\"float: left; margin-right: 25px; image-orientation: 90deg;\">";
            ?>
            <div style="margin-left: 38%">
            <h2> <? 
                  $membership->getMenteeUser($_SESSION['username']); 
                ?>
            </h2>
            <p id="major" style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"><em>Majoring in...<br></em></span> 
               <?
                   echo $membership->getMenteeMajor($_SESSION['username']);
                   $major=$membership->getMentorMajor2($_SESSION['username']);
                   if(!empty($major)) {
                    echo "<br>";
                    echo $major;
               }
               ?>
            </p> 
            <?
               $minor=$membership->getMenteeMinor($_SESSION['username']);
               if(!empty($minor)) {
                    echo "<p style=\"font-size: 16px; color: #F2F2F2\"><span style=\"color: #A9D0F5;\"><em>Minoring in... 
                              <br></em></span>$minor";
                    $minor2=$membership->getMentorMinor2($_SESSION['username']);
                    if(!empty($minor2)) {
                        echo "<br>" . $minor2;
                    }
                    echo "</p>";
               }
               
            ?>
            <p id="year" style="font-size: 16px; color: #F2F2F2"><em>Graduating </em> 
               <span style="color: #A9D0F5;"><?
                   echo $membership->getMenteeYear($_SESSION['username']);
               ?></span>
            </p>
            <p style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"> 
               <?
                   echo $membership->getMenteeAge($_SESSION['username']);
               ?></span>
               <em> years old</em>
            </p>
            <p style="font-size: 16px; color: #F2F2F2"><em>An </em><span style="color: #A9D0F5;">
               <?
                   echo $membership->getMenteeRegion($_SESSION['username']);
               ?>
               </span><em> student</em>
            </p>
            <?
               $personal=$membership->getMenteePersonal($_SESSION['username']);
               if(!empty($personal)) {
                    echo "<p style=\"font-size: 16px; color: #F2F2F2\"><span style=\"color: #A9D0F5;\"><em>Personal Statement: 
                              <br></em></span>$personal</p>";
               }
               
            ?> <br><br>
            <p style="font-size: 20px; color: #F2F2F2; margin-left: 10%"><span style="color: #A9D0F5; margin-left:-13%;"><em>What only Exec can see:<br></em></span> <br><span style="font-size: 16px; margin-left: -5%; color: #99CC33">Adversity:</span>
               <?
                   $adversity=$membership->getMenteeExp($_SESSION['username']);
                   echo "<span style=\"font-size: 16px;\">$adversity</span>";
               ?>
<br><br><span style="font-size: 16px; margin-left: -5%; color: #99CC33">Mentor:</span> <br> 
                   <? $mentor = $membership->getMyMentor($_SESSION['username']); ?>
<span style=\"font-size: 16px;\">                 <? if(strlen($mentor) > 0) { echo $mentor; } ?>                 </span>
            </p> 
            </div>
            <div style="margin-left: 38%; padding-top: 40px; width: 50%">
                <h4><a href="../public/resetpass.php">Change Password </a></h4>
            </div>
            <div style="margin-left: 38%; padding-top: 40px; width: 27%">
                <form method="link" action="menteeEdit.php">
                    <input class="button" type="submit" id="edit" value="Edit Profile" name="edit" />
                </form>
            </div>
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