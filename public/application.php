<?
    session_start(); // on every page that sessions are used in
    include '../classes/mysql.php';
    $mysql = New Mysql();
    
    // check to see if logout clicked
    if(isset($_SESSION['user_id'])) {
        header("location: ../users/userHome.php");
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>	
        <title>UVa SEAS Mentorship Accounts</title> 

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
        <script src="../bootstrap/lightbox/js/jquery-1.10.2.min.js"></script>
        <script src="../bootstrap/lightbox/js/lightbox-2.6.min.js"></script>
    
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="../bootstrap/css/carousel.css" >
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link href="../bootstrap/lightbox/css/lightbox.css" rel="stylesheet" />
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />

        
    </head>

    <body>
    <div class="container">
            <? 
                include '../nav/navbar.php'; 
            ?>
        
            <div class="row">          
                <div class="col-md-3">
 
                    <ul class="nav nav-pills nav-stacked">
                        <li id="menteeLi" class="active">
                            <a href="javascript.void(0);" id="mentee"><b>Mentee</b> Application</a></li>
                        <li id="mentorLi" >
                            <a href="javascript.void(0);" id="mentor"><b>Mentor</b> Application</a></li>
                    </ul> 
                </div>
                
                <div class="col-md-9">
                    <div>
                        <?
                            $message = $_GET['t'];
                            if(isset($message) && $message == "yes") {
                                echo "<div class=\"alert alert-success\">  
                                        <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                        <strong>Testimonial submission succeeded!</strong>
                                    </div>";     
                            }
                        ?>
                    </div>
                    <div id="content">
                        <script type="text/javascript">
                        
                            var select = window.location.href.toString().split("=")[1];
                            $('.nav li').removeClass('active');
                            if(typeof select === 'undefined' || select.indexOf(1) != -1){
                                $.ajax({
                                    url: 'menteeapp.php',
                                    data: {error:window.location.href.toString().split("=")[2]},
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("menteeLi").className += " active";
                            } else if(select.indexOf(2) != -1) {
                                $.ajax({
                                    url: 'mentorapp.php',
                                    data: {error:window.location.href.toString().split("=")[2]},
                                    success: function(data){
                                        $('#content').html(data);   
                                    }
                                });
                                document.getElementById("mentorLi").className += " active";
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
                
                document.getElementById("mentee").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'menteeapp.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("menteeLi").className += " active";
                    return false;
                }
                
                document.getElementById("mentor").onclick = function() {
                    $('.nav li').removeClass('active');
                    $.ajax({
                        url: 'mentorapp.php',
                        success: function(data){
                            $('#content').html(data);   
                        }
                    });
                    document.getElementById("mentorLi").className += " active";
                    return false;
                }
                
            }
        </script>
    </body>

</html>