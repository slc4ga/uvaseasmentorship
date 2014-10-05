<?php

    session_start(); // on every page that sessions are used in
    require_once '../../classes/mysql.php';
    $mysql = new Mysql();
    

    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        header("location: ../../actions/logout.php");
    }

?>
<div class="col-md-11">
   <h2>Post an Announcement</h2>
    <hr>
    <form class="form-inline" method="POST" action="../actions/post.php">
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Post by: </b></span> &nbsp;
                <? echo $mysql->getFullName($_SESSION['user_id']); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Post to: </b></span> &nbsp;
                <select name="emails" style="margin-bottom: 15px; margin-top: 15px">
                    <option value="seas-mentorship@virginia.edu">All</option>
                    <option value="seas-mentorshipMentors@virginia.edu">Mentors</option>
                    <option value="seas-mentorshipMentees@virginia.edu">Mentees</option>
                    <option value="seas-mentorshipExec@virginia.edu">Exec</option>
               </select> <br>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Subject: </b></span> &nbsp;
                <input style="width: 70%" class="form-control" type="text" name="subject"><br>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em"><b> Announcement: </b></span> <br>
                <textarea name="announcement" id="announcement" rows="8" class="form-control"></textarea>
            </div>
        </div>
        <br><br>
        <input type="submit" class="btn btn-lg btn-success" id="submit" value="Post Announcement" name="submit"/>
    </form> 
</div>					  