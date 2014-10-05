<?php
    session_start(); // on every page that sessions are used in
    require_once '../classes/mysql.php';
    $mysql = new Mysql();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> SEAS Mentorship Application </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="modal-header">
                <h3>Application submitted successfully!</h3>
            </div>
            <div class="modal-body">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="login">
                            <div id="legend">
                                <legend class="">Congrats!</legend>
                            </div>    
                            <p> 
                                You will receive an email from Exec by September 1 with further instructions if your application 
                                was approved. 
                            </p>
                            <hr>
                            <!-- Button -->
                                <a class="btn btn-success" href="../index.php">Mentorship Home</a>           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>