<?php
    session_start();
    require_once '../classes/mysql.php';
    $mysql = new Mysql();

    $status = $_GET['status'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Retrieve SEAS Mentorship Password </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="modal-header">
                <h3> Retrieve SEAS Mentorship Password</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <form class="form-inline" action="#" method="POST">
                                <fieldset>
                                    <div id="legend">
                                        <legend class="">
                                        <? 
                                            if ($status == 1) { 
                                                echo "Password retrieved successfully!";
                                            } else {
                                                echo "User not found...";
                                            }
                                        ?>
                                        </legend>
                                    </div>    
                                    <? 
                                        if ($status == 1) { 
                                            echo "<p> You will receive an email with your password shortly. </p>";
                                        } else {
                                            echo "<p> Try making a <a href=\"application.php\">new account</a>.</p>";
                                        }
                                    ?>
                                    <hr>
                                    <!-- Button -->
                                        <a class="btn btn-success" href="../index.php">Mentorship Home</a>
                                </fieldset>
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 