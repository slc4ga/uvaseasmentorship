<?

    session_start(); // on every page that sessions are used in
    require_once '../classes/membership.php';
    $membership = new Membership();
    

    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        $membership->log_user_out();
    }
    else if($_SESSION['role']!=1) {
        header("location: ../index.php");
    }

    if($_POST && !empty($_POST['name']) && !empty($_POST['sem']) &&
       !empty($_POST['date']) && !empty($_POST['details'])) {
       $membership->addEvent($_POST['name'], $_POST['date'], $_POST['details'], $_POST['sem']);
       header("location: events.php");
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" href="../colorbox/example4/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<title> Exec - Events</title>
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
            <div id="main">
			<h2>Semester Events</h2>
			<h3 style="padding-right: 20px;font-size:14px;"><b>Choose a semester to view existing events: </b></h3>
			<select name="semChoice" id="semChoice" style="width: 40%; margin-left: 15px;">
			    <option value="All" selected>All</option>
			    <option value="Fall 2013">Fall 2013</option>
			    <option value="Spring 2014">Spring 2014</option>
			    <option value="Fall 2014">Fall 2014</option>
			    <option value="Spring 2015">Spring 2015</option>
			    <option value="Fall 2015">Fall 2015</option>
			    <option value="Spring 2016">Spring 2016</option>
			    <option value="Fall 2016">Fall 2016</option>
			    <option value="Spring 2017">Spring 2017</option>
			</select><br><br>
                <?
		    $result=$membership->getAllEvents();
		    if (gettype($result) == "boolean") {
			echo "failed2<br>";
		    }
		    else {
			 echo "<div id=\"eventTable\"></div>";
		    }
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
<script>
    $( "#semChoice" )
    .change(function () {
     var id = $("#semChoice option:selected").val();
     $.get('../classes/eventTable.php?sem=' + id,function(data) {
      $( "#eventTable" ).html( data);
    });
   })
    .change();
</script>
</body>
</html>