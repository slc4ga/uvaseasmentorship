<?php
	include_once('../classes/mysql.php');
	session_start();
    date_default_timezone_set('America/New_York');

	$mysql = new Mysql();
    $er = $_SESSION['er'];

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $role = $mysql->checkRole($_SESSION['user_id']);

?>

<div class='col-md-11'>
    <?
        if($er == "success") {
            echo "<div class=\"alert alert-success alert-dismissable\">  
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                    <strong>Thanks!</strong> Submitted log sucessfully.
                </div>"; 
            unset($_SESSION['er']);
        }

        $date = $mysql->getLogDate();
        $time = strtotime($date);
        $two = strtotime('-2 weeks');
        
        if( $time < $two ) { 
            echo "<div class=\"alert alert-danger\">  
                    <strong>You're slacking!</strong> Looks like you haven't submitted a log in at least 2 weeks...go fix that now! 
                        Remember, you get points for completing those!
                </div>"; 
        }

        $announce = $mysql->getNumAnnouncements();
        if($announce > 15) { 
            $announce = 15; 
        }
        if($announce == 0) { 
            echo "<h4>No new announcements right now.</h4>"; 
        } else {
            if($mysql->checkExec($_SESSION['user_id'])) {
                $result=$mysql->getAnnouncements($announce, "Exec");
            } else {
                $result=$mysql->getAnnouncements($announce, $role);
            }
            if (gettype($result) == "boolean") {
                echo "failed<br>";
            } else {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class=\"row\">
                            <div class=\"col-md-11\">";
                                echo "<h3 style=\"color: #428bca\"><b>Subject " . $row[3] . "</b></h3>";
                                echo $row[4];
                                // footer
                                echo "<br><br>
                                    <small><div class=\"row\">";
                                    echo "<div class=\"col-md-6\">
                                        <b>Posted by: </b>" . $mysql->getFullName($row[1]) . "<br>
                                        <b>Posted to: </b>" . $row[2] . "<br><br>";
                                    echo "</div>";
                                    echo "<div class=\"col-md-6\">";
                                        $date = new DateTime($row[0]);
                                        echo "<span class=\"pull-right\"><em>" . $date->format('D M j, Y') . "</em></span>";
                                    echo "</div>";
                                echo "</div></small><br><br>";
                            echo "</div>";
                        echo "</div><br>";
                }
            }
        }

    ?>

</div>		