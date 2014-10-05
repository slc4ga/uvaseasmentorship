<?
    require_once '../classes/mysql.php';
    session_start();

    $mysql = new Mysql();

    if(!isset($_SESSION['user_id']) || strlen($mysql->getLeadership($_SESSION['user_id'])) <= 0) {
        header("location:../index.php");
    }

    if($_POST) {
        if(!empty($_POST['letter']) && !empty($_POST['info'])) {
            $mysql->addPledgeClass($_POST['letter'], $_POST['info']);
            header("location:webmaster.php?select=2");
        }
    }

?>

<!DOCTYPE html>
<html>
        <head>
        
        <meta charset="utf-8">
        <title> Mentorship Exec </title>
            
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
            
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="../bootstrap/js/bootbox.min.js"></script>
    
        <script src="../bootstrap/js/bootstrap.js"></script>
            
        
    </head>
    <body>
    
        <div class="container">
            <?
                include '../nav/navbar.php';
            ?>
            
            <div class="row">            
                <div class="col-md-3">
     
                    <ul class="nav nav-pills nav-stacked">
                        <li id="postLi" class="active">
                            <a href="javascript.void(0);" id="post">Post Announcement</a></li>
                        <li id="approveLi" >
                            <a href="javascript.void(0);" id="approve">Approve Mentors</a></li>
                        <li id="matchLi" >
                            <a href="javascript.void(0);" id="match">Match Mentees</a></li>
                        <li id="listsLi" >
                            <a href="javascript.void(0);" id="lists">Member List</a></li>
                    </ul>
                     
                 </div>
                
                <div class="col-md-9">
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav li').removeClass('active');
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'exec/post.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("postLi").className += " active";
                            } else if(select.indexOf(2) != -1) {
                                $.ajax({
                                    url: 'exec/approve.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("approveLi").className += " active";
                            } else if(select.indexOf(3) != -1) {
                                $.ajax({
                                    url: 'exec/match.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("matchLi").className += " active";
                            } else if(select.indexOf(4) != -1){
                                $.ajax({
                                    url: 'exec/members.php',
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("listsLi").className += " active";
                            }
                        </script>
                    </div>
                </div>
            </div>
            <? include '../nav/footer.php'; ?> 
        </div>
        <script type="text/javascript">
            window.onload = function() {
                
                document.getElementById("post").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'exec/post.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("postLi").className += " active";
                    return false;
                }
                
                document.getElementById("approve").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'exec/approve.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("approveLi").className += " active";
                    return false;
                }
                
                document.getElementById("match").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'exec/match.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("matchLi").className += " active";
                    return false;
                }
                
                document.getElementById("lists").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'exec/members.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("listsLi").className += " active";
                    return false;
                }
            }
        </script>
    </body>
</html>