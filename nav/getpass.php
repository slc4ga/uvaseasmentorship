<?php
    session_start(); 
    require_once '../classes/mysql.php';
    $mysql = new Mysql();
    
    if($_POST && !empty($_POST['un'])) {
        $mysql->getPass($_POST['un']);
    }

    $er=$_GET['er'];
    if($er == 'username') {
        $er = "That username does not exist.";
    }
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
                <h3>Password Retrieval</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <form class="form-inline" action="#" method="POST">
                                <fieldset>
                                    <div id="legend">
                                        <legend class="">Find Account Info</legend>
                                    </div>    
                                        <!-- Username -->
                                        <input type="text" class="form-control" style="width: 20%" id="username" name="un" 
                                               placeholder="Username" class="input-xlarge"
                                               placeholder="Username"/> 
                                    <hr>
                                    <!-- Button -->
                                        <button class="btn btn-success">Submit</button>
                                </fieldset>
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 