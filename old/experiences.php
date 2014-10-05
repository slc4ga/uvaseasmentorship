<?php
    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    $membership = new Membership();
    

    if($_POST) {
         $membership->add_experience($_POST['overwhelmed'], $_POST['fail_test'], $_POST['anxiety'], $_POST['over_committed'], $_POST['fail_class'], $_POST['homesick'], $_POST['family'], $_POST['isolated'], $_POST['roommate'], $_POST['depression'], $_POST['death'], $_POST['relationship'], $_POST['caps'], $_POST['no_alcohol'], $_POST['extreme_alcohol'], $_POST['eating_disorder'], $_POST['suicide'], $_POST['disability'], $_POST['drugs'], $_POST['homeschool'], $_POST['money'], $_POST['greek'], $_POST['transfer'], $_POST['international'], $_POST['academic_probation'], $_POST['military']);

       $membership->newRedirect();
    }

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <title>SEAS Mentorship Experiences update</title>
</head>

<body>
    <div id="header">
        <h1 id="logo-text"><a href="../index.php" title="">uva seas mentorship</a></h1>
        <p id="slogan">est. 2012</p>				
    </div>	
		
    <!-- navigation starts here -->
        <div id="nav">	
	<ul>
    		<li><a href="../index.php">Home</a></li>
		<li><a href="pics.php">Pictures</a></li>
                <li><a href="calendar.php">Calendar</a></li>
		<li><a href="login.php">Login</a></li>				
	</ul>
    </div>
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
                            <li><a href="../index.php">Home</a></li>
                            <li><a href="contact.php">Contact Exec</a></li>
			    <li><a href="seasAccountform.php">Mentee Application</a></li>
			    <li ><a href="application.php">Mentor Application</a></li>
                            <li><a href="http://www.virginia.edu" target="_blank">Virginia Home Page</a> </li>									
                    </ul>	
                            
                    <h3>Wise Words</h3>
                    <p>&quot;Treat your password like your toothbrush. Don't let anybody else use it
		    and get a new one every 6 months.&quot;</p>		
                    
                    <p class="align-right">- Clifford Stoll</p>		
        </div>
	<div id="main">
	    <br>
        <form method="post" action="" style="height: 500px">
            <h2 style="color: #CFEBFF">Update User Experiences</h2>
            <h4> Check all situations that you have experience with or would like help with.</h4>
		<div id="formRow" style="height: 275px">
		    <div id="leftForm" style="height: 375px">
			<input type="checkbox" name="transfer" value="X">  Transfer student<br>
            <input type="checkbox" name="international" value="X">  International student<br>
			<input type="checkbox" name="military" value="X">  Military connections<br>
			<input type="checkbox" name="greek" value="X">  Greek life<br>
			<input type="checkbox" name="homeschool" value="X">  Homeschooled<br>
			<input type="checkbox" name="over_committed" value="X">  Overcommited<br>
			<input type="checkbox" name="homesick" value="X">  Homesick<br>
			<input type="checkbox" name="isolated" value="X">  Feeling isolated<br>
			<input type="checkbox" name="overwhelmed" value="X">  Feeling Overwhelmed<br>
			<input type="checkbox" name="anxiety" value="X">  Feelings of anxiety<br>
			<input type="checkbox" name="no_alcohol" value="X">  No alcohol use<br>
            <input type="checkbox" name="extreme_alcohol" value="X">  Extreme alcohol use<br>
            <input type="checkbox" name="drugs" value="X">  Illegal drug use<br>
		    </div>
		    
		    <div id="rightForm">
			<input type="checkbox" name="caps" value="X">  Dealt with CAPS<br>
			<input type="checkbox" name="eating_disorder" value="X">  Eating disorder<br>
			<input type="checkbox" name="money" value="X">  Money problems<br>
			<input type="checkbox" name="roommate" value="X">  Roommate problems<br>
			<input type="checkbox" name="family" value="X">  Family problems<br>
			<input type="checkbox" name="relationship" value="X">  Relationship problems<br>
            <input type="checkbox" name="fail_test" value="X">  Failed a test<br>
            <input type="checkbox" name="fail_class" value="X">  Failed a class<br>
            <input type="checkbox" name="academic_probation" value="X">  Academic probation<br>
            <input type="checkbox" name="disability" value="X">  Disability<br>
            <input type="checkbox" name="suicide" value="X">  Suicide<br>
            <input type="checkbox" name="depression" value="X">  Depression<br>
            <input type="checkbox" name="death" value="X">  Death<br>
		    </div>
		
		</div>
                <div id="formRow">
                    <div id="leftForm">
                        <br>
                        <input type="submit" class = "button" id="submit" value="SUBMIT EXPERIENCES" name="submit"/>
                    </div>
		<div id="rightForm"></div>
            </div> 
        </form>
	</div>
    </div> </div>
    
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
    </div>
</body>

</html>