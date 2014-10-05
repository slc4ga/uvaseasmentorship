<?
    require_once '../classes/mysql.php';
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $mysql = new Mysql();

    $role = $mysql->checkRole($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <title> SEAS Mentorship Account </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
        
    </head>
    <body>
    
        <div class="container"> 
            <?
                include '../nav/navbar.php';
            ?>
            <div class="col-md-12">
                <?
                    echo "<h1>Welcome " . $mysql->getFullName($_SESSION['user_id']) . "!</h1><hr>";
                ?>
            </div>

            <div class="row">            
                <div class="col-md-3">
     
                    <ul class="nav nav-pills nav-stacked">
                        <li id="announceLi" class="active">
                            <a href="javascript.void(0);" id="announcements">Announcements</a></li>
                        <li id="profileLi" class="active">
                            <a href="javascript.void(0);" id="profile">View Profile</a></li>
                        <li id="editLi" >
                            <a href="javascript.void(0);" id="edit">Edit Profile</a></li>
                        <li id="passwordLi" >
                            <a href="javascript.void(0);" id="password">Change Password</a></li>
                        <li id="pairLi" >
                            <a href="javascript.void(0);" id="pair">
                                <?
                                    if($role == "Mentor") { echo "Paired Mentee's Profile"; }
                                    else { echo "Paired Mentor's Profile"; }
                                ?>
                            </a></li>
                        <?

                            if($role == "Mentor") {
                                echo "<li id=\"logsLi\" >
                                            <a href=\"javascript.void(0);\" id=\"logs\">Mentor Logs</a></li>";
                            }
                            if(strlen($mysql->getLeadership($_SESSION['user_id'])) > 0) {
                                echo "<li>
                                    <a href='exec.php' id='exec'>Exec Privileges</a></li>";
                            }
                            if($mysql->checkWebmaster($_SESSION['user_id'])) {
                                echo "<li>
                                    <a href='../webmaster/webmaster.php' id='webmaster'>Webmaster Capabilities</a></li>";
                            } 

                        ?>
                    </ul>
                     
                 </div>
                
                <div class="col-md-9">
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav-pills li').removeClass('active');
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'announcements.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("announceLi").className += " active";
                            } else if(select.indexOf(2) != -1){
                                $.ajax({
                                    url: 'profile.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("profileLi").className += " active";
                            } else if(select.indexOf(3) != -1) {
                                $.ajax({
                                    url: 'editProfile.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("editLi").className += " active";
                            } else if(select.indexOf(4) != -1) {
                                $.ajax({
                                    url: 'pairedProfile.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("pairLi").className += " active";
                            } else if(select.indexOf(5) != -1) {
                                $.ajax({
                                    url: 'resetpass.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("passwordLi").className += " active";
                            } else if(select.indexOf(6) != -1) {
                                $.ajax({
                                    url: 'logs.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("logsLi").className += " active";
                            }
                        </script>
                    </div>
                </div>
            </div>
            <?
                include '../nav/footer.php';
            ?>
        </div>
         <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("announcements").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'announcements.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("announceLi").className += " active";
                    return false;
                }
                
                document.getElementById("profile").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'profile.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("profileLi").className += " active";
                    return false;
                }
                
                document.getElementById("edit").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'editProfile.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("editLi").className += " active";
                    return false;
                }
                
                document.getElementById("pair").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'pairedProfile.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("pairLi").className += " active";
                    return false;
                }
                                
                document.getElementById("password").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'resetPass.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("passwordLi").className += " active";
                    return false;
                }
                
                document.getElementById("logs").onclick = function() {
                    $('.nav-pills li').removeClass('active');
                    $.ajax({
                        url: 'logs.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("logsLi").className += " active";
                    return false;
                }
                                

                
            }
        </script>
    </body>

</html>