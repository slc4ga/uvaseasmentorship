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
         $membership->add_experience($_POST['overwhelmed'], $_POST['fail_test'], $_POST['anxiety'], $_POST['over_committed'], $_POST['fail_class'], $_POST['homesick'], $_POST['family'], $_POST['isolated'], $_POST['roommate'], $_POST['depression'], $_POST['death'], $_POST['relationship'], $_POST['caps'], $_POST['no_alcohol'], $_POST['extreme_alcohol'], $_POST['eating_disorder'], $_POST['suicide'], $_POST['disability'], $_POST['drugs'], $_POST['homeschool'], $_POST['money'], $_POST['greek'], $_POST['transfer'], $_POST['international'], $_POST['academic_probation'], $_POST['military']);

         $membership->updateMentorUser($_SESSION['username'], $_POST['major1'], $_POST['major2'], $_POST['minor1'], $_POST['minor2'], $_POST['year'], $_POST['region'], $_POST['personal'], $_POST['pos']);
    }

    if($_POST['picUpload']) {
        $image =$_FILES["file"]["name"];
        $uploadedfile = $_FILES['file']['tmp_name'];
        if ($image) {
            $filename = stripslashes($_FILES['file']['name']);
            $i = strrpos($filename,".");
            if (!$i) { $ext=""; }
            else {
                $l = strlen($filename) - $i;
                $ext = substr($filename,$i+1,$l);
            }
            $extension = $ext;
            $extension = strtolower($extension);
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))  {
                echo ' Unknown Image extension ';
                $errors=1;
            }
            else {
                $size=filesize($_FILES['file']['tmp_name']);
                $first=$membership->getMentorFirstName($_SESSION['username']);
                $last=$membership->getMentorLastName($_SESSION['username']);
                $name = $first . $last . ".jpg";
                if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG" || $extension=="JPEG") {
                    $uploadedfile = $_FILES['file']['tmp_name'];
                    $src = imagecreatefromjpeg($uploadedfile);
                }
                else if($extension=="png" || $extension=="PNG") {
                    $uploadedfile = $_FILES['file']['tmp_name'];
                    $src = imagecreatefrompng($uploadedfile);
                }
                else {
                    $src = imagecreatefromgif($uploadedfile);
                }
                list($width,$height)=getimagesize($uploadedfile);
                $newwidth=175;
                $newheight=225;
                $tmp=imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagejpeg($tmp,"../uploads/$name",100);
                imagedestroy($src);
                imagedestroy($tmp);
                move_uploaded_file($_FILES["file"]["tmp_name"],"../uploads/$name");
                header("location:profile.php");
            }
         }
        else
         {
            echo "Invalid file";
         }
    }

    if (isset($_POST['variable']) && $_POST['variable'] == 50) {
         //define image path
          $first=$membership->getMentorFirstName($_SESSION['username']);
          $last=$membership->getMentorLastName($_SESSION['username']);
          $name = $first . $last . ".jpg";
         // Load the image
          $source = imagecreatefromjpeg("../uploads/$name");
         // Rotate
          $rotate = imagerotate($source, 90, 0);
         //and delete/save it on your server...
          unlink("../uploads/$name");
          imagejpeg($rotate,"../uploads/$name");
          header("location:mentorEdit.php");
     }


    if (isset($_POST['variable2']) && $_POST['variable2'] == 100) {
         //define image path
          $first=$membership->getMentorFirstName($_SESSION['username']);
          $last=$membership->getMentorLastName($_SESSION['username']);
          $name = $first . $last . ".jpg";
         // Load the image
          $source = imagecreatefromjpeg("../uploads/$name");
         // Rotate
          $rotate = imagerotate($source, 270, 0);
         //and delete/save it on your server...
          unlink("../uploads/$name");
          imagejpeg($rotate, "../uploads/$name");
          header("location:mentorEdit.php");
     }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />

<title> Mentor Profile - Edit</title>

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
                      <li id="current"><a href="profile.php">Profile</a></li>
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
                <br>
                <br> <div style="float: left; width: 33%">
                    <?
                         $imgPath=$membership->getMentorPhoto($_SESSION['username']);
                         echo "<img src=\"$imgPath\" height=\"225\" width=\"175\" style=\"float: left; margin-right: 25px;\">";
                    ?>
                    <form action="" method="POST" style="float: left; width: 20px; height: 20px; margin-left: 50px;">
                          <input type="hidden" name="variable" value="50" />
                          <input type="image" src="../images/left.png" height="30" style="margin-left: -10px; margin-top: -10px" name="submit" />
                    </form>
                    <form action="" method="POST" style="float: left; width: 20px; height: 20px; margin-left: 0px;">
                          <input type="hidden" name="variable2" value="100" />
                          <input type="image" src="../images/right.png" height="30" style="margin-left: -10px; margin-top: -10px" name="submit" />
                    </form> 
                    <form action="" method="post" enctype="multipart/form-data" style="margin-top: 300px; width: 160px; margin-left: 0px;" >
                         <label style="margin-top: -5px;" for="file">Filename:</label>
                         <div style="background: #FFFFFF">
                         <input type="file" name="file" id="file" style="color: #FFFFFF; width: 150px;"><br> </div>
                         <input type="submit" name="picUpload" value="Upload" style="margin-top: 8px;">
                    </form>
                </div>
                <div style="margin-left: 37%; width: 430px;">
                <h2> <? 
                      $membership->getMentorUser($_SESSION['username']); 
                    ?>
                </h2> </div>
                <form style="margin-left: 37%; height: 1220px; width: 410px; padding-left: 1px; padding-top: 2px" method="POST">
                <p id="major" style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"><em>Majoring in...<br></em></span> 
                   <div style="padding-bottom: 13px; padding-left: 15px;">
                      <div id="leftForm">
			<label for="major1">Primary Major*: </label>
			<input type="radio" name="major1" value="AERO" <? if($membership->getMentorMajor($_SESSION['username']) == 'Aerospace Engineering') { echo "checked"; } ?> >  Aerospace<br>
			<input type="radio" name="major1" value="CHEME" <? if($membership->getMentorMajor($_SESSION['username']) == 'Chemical Engineering') { echo "checked"; } ?> >  Chemical<br>
			<input type="radio" name="major1" value="CPE"  <? if($membership->getMentorMajor($_SESSION['username']) == 'Computer Engineering') { echo "checked"; } ?> >  Computer Engineering<br>
			<input type="radio" name="major1" value="EE" <? if($membership->getMentorMajor($_SESSION['username']) == 'Electrical Engineering') { echo "checked"; } ?> >  Electrical<br>
			<input type="radio" name="major1" value="MECH" <? if($membership->getMentorMajor($_SESSION['username']) == 'Mechanical Engineering') { echo "checked"; } ?> >  Mechanical<br>
		      </div>
		    
		      <div id="rightForm" style="padding-top: 7px;">
			<br>
			    <input type="radio" name="major1" value="BIOMED" <? if($membership->getMentorMajor($_SESSION['username']) == 'Biomedical Engineering') { echo "checked"; } ?> >  Biomedical<br>
			    <input type="radio" name="major1" value="CIVIL" <? if($membership->getMentorMajor($_SESSION['username']) == 'Civil Engineering') { echo "checked"; } ?> >  Civil/Environmental<br>
			    <input type="radio" name="major1" value="CS" <? if($membership->getMentorMajor($_SESSION['username']) == 'Computer Science') { echo "checked"; } ?> >  Computer Science<br>
			    <input type="radio" name="major1" value="ESCI" <? if($membership->getMentorMajor($_SESSION['username']) == 'Engineering Science') { echo "checked"; } ?> >  Engineering Science<br>
			    <input type="radio" name="major1" value="SYS" <? if($membership->getMentorMajor($_SESSION['username']) == 'Systems Engineering') { echo "checked"; } ?> >  Systems<br>
		      </div>
                   </div>
                   <div style="padding-bottom: 13px; padding-left: 15px;"> 
			<label for="major2">Additional Major: </label>
			<input type=text name=major2 size=30 maxlength=25 value='<? echo $membership->getExecMajor2($_SESSION['username']); ?>'>
                   </div>
                </p> 

                <p style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"><em>Minoring in... 
                                  <br></em></span>
                   <div style="padding-bottom: 13px; padding-left: 15px;"> <input type=text name=minor1 size=30 maxlength=25 value='<? echo $membership->getMentorMinor($_SESSION['username']); ?>'> </div>
                   <div style="padding-bottom: 13px; padding-left: 15px;"> <input type=text name=minor2 size=30 maxlength=25 value='<? echo $membership->getMentorMinor2($_SESSION['username']); ?>'> </div>
                </p>

                <p id="year" style="font-size: 16px; color: #F2F2F2"><em>Graduating </em> 
                   <input type=number name=year min="2010" max="2030" value='<? echo $membership->getMentorYear($_SESSION['username']); ?>'>
                </p>
                <p style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"> 
                    <input type="number" name="age" min="15" max="30" value='<? echo $membership->getMentorAge($_SESSION['username']);?>' >
                   </span><em> years old</em>
                </p>
                                <p> <span style="color: #A9D0F5; font-size: 16px;"><em>Region:<br></em></span> 
			<input type="radio" name="region" value="In-state" <? if($membership->getMentorRegion($_SESSION['username']) == 'In-state') { echo "checked"; } ?> >  In-State<br>
			<input type="radio" name="region" value="Out of state" <? if($membership->getMentorRegion($_SESSION['username']) == 'Out-of-state') { echo "checked"; } ?> >  Out-of-State<br>
			<input type="radio" name="region" value="International" <? if($membership->getMentorRegion($_SESSION['username']) == 'International') { echo "checked"; } ?> >  International<br>
                </p>
                <p style="font-size: 16px; color: #F2F2F2"><span style="color: #A9D0F5;"><em>Personal Statement: <br></em></span>
                   <textarea name=personal rows="6" style="width: 98%; margin-top: 10px; color: #000000"><? echo htmlspecialchars($membership->getMentorPersonal($_SESSION['username'])); ?></textarea>
                </p>
                <br><br>
                <p style="font-size: 20px; color: #F2F2F2; margin-left: 10%"><span style="color: #A9D0F5; margin-left:-13%;"><em>What only Exec can see:<br></em></span> <br><span style="font-size: 16px; margin-left: -10%; color: #99CC33">Adversity:</span>
                    <div id="formRow" style="width: 450px; height: 325px; padding-left: 5%; font-size: 14px; color: #FFFFFF; margin-top: -15px">
                        <?
                             $myArray = $membership->getMentorExpArray($_SESSION['username']);
                        ?> 
                        <div id="leftForm" style="height: 325px; width: 180px;">
                            <input type="checkbox" name="transfer" value="X" <?php if(in_array('Transfer student', $myArray)) echo( 'checked=\"true\"'); ?>>  Transfer student<br>
                            <input type="checkbox" name="international" value="X"<?php if(in_array('International student', $myArray)) echo( 'checked=\"true\"'); ?>>  International student<br>
                            <input type="checkbox" name="military" value="X" <?php if(in_array('Military', $myArray)) echo( 'checked=\"true\"'); ?>>  Military connections<br>
                            <input type="checkbox" name="greek" value="X" <?php if(in_array('Greek Life', $myArray)) echo( 'checked=\"true\"'); ?>>  Greek life<br>
                            <input type="checkbox" name="homeschool" value="X" <?php if(in_array('Homeschooled', $myArray)) echo( 'checked=\"true\"'); ?>>  Homeschooled<br>
                            <input type="checkbox" name="over_committed" value="X" <?php if(in_array('Overcommitment', $myArray)) echo( 'checked=\"true\"'); ?>>  Overcommitment<br>
                            <input type="checkbox" name="homesick" value="X" <?php if(in_array('Homesickness', $myArray)) echo( 'checked=\"true\"'); ?>>  Homesick<br>
                            <input type="checkbox" name="isolated" value="X" <?php if(in_array('Isolation', $myArray)) echo( 'checked=\"true\"'); ?>>  Feeling isolated<br>
                            <input type="checkbox" name="overwhelmed" value="X" <?php if(in_array('Overwhelmed', $myArray)) echo( 'checked=\"true\"'); ?>>  Feeling Overwhelmed<br>
                            <input type="checkbox" name="anxiety" value="X" <?php if(in_array('Anxiety', $myArray)) echo( 'checked=\"true\"'); ?>>  Feelings of anxiety<br>
                            <input type="checkbox" name="no_alcohol" value="X" <?php if(in_array('Alcohol-free activities', $myArray)) echo( 'checked=\"true\"'); ?>>  No alcohol use<br>
                            <input type="checkbox" name="extreme_alcohol" value="X" <?php if(in_array('Extreme alcohol use', $myArray)) echo( 'checked=\"true\"'); ?>>  Extreme alcohol use<br>
                            <input type="checkbox" name="drugs" value="X" <?php if(in_array('Drug abuse', $myArray)) echo( 'checked=\"true\"'); ?>>  Illegal drug use<br>
                        </div>
                        <div id="rightForm">
                            <input type="checkbox" name="caps" value="X" <?php if(in_array('CAPS', $myArray)) echo( 'checked=\"true\"'); ?>>  Dealt with CAPS<br>
                            <input type="checkbox" name="eating_disorder" value="X" <?php if(in_array('Eating Disorder', $myArray)) echo( 'checked=\"true\"'); ?>>  Eating disorder<br>
                            <input type="checkbox" name="money" value="X" <?php if(in_array('Financial problems', $myArray)) echo( 'checked=\"true\"'); ?>>  Money problems<br>
                            <input type="checkbox" name="roommate" value="X" <?php if(in_array('Roommate problems', $myArray)) echo( 'checked=\"true\"'); ?>>  Roommate problems<br>
                            <input type="checkbox" name="family" value="X" <?php if(in_array('Family issues', $myArray)) echo( 'checked=\"true\"'); ?>>  Family problems<br>
                            <input type="checkbox" name="relationship" value="X" <?php if(in_array('Relationships', $myArray)) echo( 'checked=\"true\"'); ?>>  Relationship problems<br>
                            <input type="checkbox" name="fail_test" value="X" <?php if(in_array('Failed a test', $myArray)) echo( 'checked=\"true\"'); ?>>  Failed a test<br>
                            <input type="checkbox" name="fail_class" value="X" <?php if(in_array('Failed a class', $myArray)) echo( 'checked=\"true\"'); ?>>  Failed a class<br>
                            <input type="checkbox" name="academic_probation" value="X" <?php if(in_array('Academic Probation', $myArray)) echo( 'checked=\"true\"'); ?>>  Academic probation<br>
                            <input type="checkbox" name="disability" value="X" <?php if(in_array('Disability', $myArray)) echo( 'checked=\"true\"'); ?>>  Disability<br>
                            <input type="checkbox" name="suicide" value="X" <?php if(in_array('Suicide', $myArray)) echo( 'checked=\"true\"'); ?>>  Suicide<br>
                            <input type="checkbox" name="depression" value="X" <?php if(in_array('Depression', $myArray)) echo( 'checked=\"true\"'); ?>>  Depression<br>
                            <input type="checkbox" name="death" value="X" <?php if(in_array('Death', $myArray)) echo( 'checked=\"true\"'); ?>>  Death<br>
                        </div>
                    </div>
                </p> 
    
                <br><br>
                <div padding-top: 100px;">
                    <p>
                        <input type="submit" class="button" id="submit" value="Update" name="submit"/>
                    </p>
                </div>
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