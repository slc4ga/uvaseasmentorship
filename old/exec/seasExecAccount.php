<?php
    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    require_once '../classes/mysql.php';
    $membership = new Membership();
    $mysql = new Mysql();

    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        $membership->log_user_out();
    }
    else if($_SESSION['role']!=1) {
        header("location: ../index.php");
    }

    // check major/double major/minor sequence
    
    if($_POST) {
       if(!empty($_POST['name1']) && !empty($_POST['name2']) &&
       !empty($_POST['un']) && !empty($_POST['grad'])) {
       echo "here!";

        // validate data

               if((empty($_POST['major1']) && !empty($_POST['major2'])) ||
            (empty($_POST['major1'])  && (!empty($_POST['minor1'])  || !empty($_POST['minor2']))))  {
                echo "Please enter a valid degree program";
        }

        else {
            // check to see if it's adding a new user or just changing user role
            $user = $mysql->checkUser($_POST['un']);
            if($user == 0) {
                // add user as exec
                $pw = substr(md5(rand()), 0, 8);
                $membership->add_user($_POST['un'], $pw, 'EXEC');
                $response = $membership->add_mentor($_POST['name1'], $_POST['name2'], $_POST['un'],
                                                    $_POST['grad'], $_POST['major1'], $_POST['major2'], $_POST['minor1'], 
                                                    $_POST['minor2'], $_POST['age'], $_POST['region']);
                $response = $membership->add_exec($_POST['name1'], $_POST['name2'], $_POST['un'],
                                                  $_POST['grad'], $_POST['major1'], $_POST['major2'],
                                                  $_POST['minor1'], $_POST['minor2'], $_POST['age'],
                                                  $_POST['region'],$_POST['pos']); 
            } else {
                // change user to exec - MUST ALREADY BE A MENTOR
                //$membership->change_user($_POST['un'], 'EXEC');
                //$response = $membership->add_exec($_POST['name1'], $_POST['name2'], $_POST['un'],
                   //                               $_POST['grad'], $_POST['major1'], $_POST['major2'],
                      //                            $_POST['minor1'], $_POST['minor2'], $_POST['age'],
                         //                         $_POST['region'],$_POST['pos']);
            }
        }        
        header("location: execIndex.php");
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <title>Exec Account Creation</title>
    </head>

    <body>
        <!-- header starts here -->
        <div id="header">	
            <h1 id="logo-text"><a href="index.html" title="">uva seas mentorship</a></h1>	
            <p id="slogan">est. 2012</p>				
        </div>	
		
        <!-- navigation starts here -->
        <div id="leftNav">
            <ul>
                <li><a href="execIndex.php">Home</a></li>
                <li><a href="#">Messages</a></li>
                <li><a href="editPairs.php">Matches</a></li>
                <li><a href="execApprove.php">Approve</a></li>
                <li><a href="execPost.php">Post</a></li>
                <li><a href="profile.php">Profile</a></li>
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
                    <li><a href="../index.php">Mentorship Home</a></li>
                    <li><a href="mentees.php">Match Participants</a></li>
                    <li><a href="#">Mentor Logs</a> </li>
                    <li><a href="#">Attendance </a> </li>
                    <li><a href="seasExecAccount.php">Create Exec Account</a></li>
                                    <li><a href="../public/calendar.php">Calendar </a> </li>	
    
                </ul>		
            </div>
            <div id="main" style="height:695px;">
                <form method="post" action="" style="height: 1680px">
                    <h2 style="color: #CFEBFF">Apply for Mentorship</h2>
                    <div id="formRow">
                        <div id="leftForm">
                            <label for="name1">First name*: </label>
                            <input type="text" name="name1" />
                        </div>
                        <div id="rightForm">
                            <label for="name2">Last name*: </label>
                            <input type="text" name="name2" />
		                </div>
                    </div>
		
		<div id="formRow">
		    
		    <div id="leftForm">
			<label for="un">Computing ID*: </label>
			<input type="text" name="un" placeholder="abc1de"/>
		    </div>

		    <div id="rightForm">
			<label for="grad">Graduation year*: </label>
			<input type="number" name="grad" min="2010" max="2030">
		    </div>
		    
		</div>
		
		<div id="formRow" style="height: 120px;">
		    
		    <div id="leftForm">
			<label for="major1">Major*: </label>
			<input type="radio" name="major1" value="AERO">  Aerospace<br>
			<input type="radio" name="major1" value="CHEME">  Chemical<br>
			<input type="radio" name="major1" value="CPE">  Computer Engineering<br>
			<input type="radio" name="major1" value="EE">  Electrical<br>
			<input type="radio" name="major1" value="MECH">  Mechanical<br>
		    </div>
		    
		    <div id="rightForm" style="padding-top: 7px;">
			<br>
			    <input type="radio" name="major1" value="BIOMED">  Biomedical<br>
			    <input type="radio" name="major1" value="CIVIL">  Civil/Environmental<br>
			    <input type="radio" name="major1" value="CS">  Computer Science<br>
			    <input type="radio" name="major1" value="ESCI">  Engineering Science<br>
			    <input type="radio" name="major1" value="SYS">  Systems<br>
		    </div>
		    
		</div>
		 
		<div id="formRow">
		    
		    <div id="leftForm">
			<label for="major2">Additional major: </label>
			<input type="text" name="major2" />

		    </div>
		    
		    <div id="rightForm">
			<label for="minor1">Minor: </label>
			<input type="text" name="minor1" />
			
		    </div>
		    
		</div> 
		
		<div id="formRow">
		    
		    <div id="leftForm">
			
			<label for="minor2">Additional Minor: </label>
			<input type="text" name="minor2" />
			
		    </div>
		    
		    <div id="rightForm">
			
		    <label for="age">Age*: </label>
		    <input type="number" name="age" min="15" max="30">
		    </div>
		</div>
    
            <div id="formRow" style="height:150px;">
            <div id="leftForm">
                <label for="type">Region*: </label>
                <input type="radio" name="region" value="In-state">  In-State<br>
                <input type="radio" name="region" value="Out of state">  Out-of-State<br>
                <input type="radio" name="region" value="International">  International<br>
    
            </div>
		    
		    <div id="rightForm">
                    <label for="type">Position*: </label>
                    <input type="radio" name="pos" value="pres"> President<br>
                    <input type="radio" name="pos" value="vp"> Vice President<br>
                    <input type="radio" name="pos" value="tech"> Webmaster<br>
                    <input type="radio" name="pos" value="social"> Social Chair<br>
                    <input type="radio" name="pos" value="academic"> Academic Chair<br>
                    <input type="radio" name="pos" value="pub"> Publicity Chair<br>
		    </div>
		    
		</div>
	    <div id="formRow">
            <div id="leftForm">
                <input type="submit" class = "button" id="submit" value="Submit" name="submit"/>
            </div>
            <div id="rightForm"></div>
        </div>     
    </form> 
    </div>
    </div> 
    </div>
</body>

</html>