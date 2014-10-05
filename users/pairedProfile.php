<?php
	include_once('../classes/mysql.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


    $role = $mysql->checkRole($_SESSION['user_id']);

    if($role == 'Mentor') { 
        $num = $mysql->getNumMentees($_SESSION['user_id']);
        if($num > 1) {
            $log = 1;
            $result = $mysql->getMyMentees($_SESSION['user_id']);
        } else if ($num == 1) {
            $log = 1;
            $row = mysqli_fetch_array($mysql->getMyMentees($_SESSION['user_id']));
            $row = mysqli_fetch_array($mysql->getInfo($row[0]));
        }
    } else {
        $log = 1;
        $row = mysqli_fetch_array($mysql->getInfo($mysql->getMyMentor($_SESSION['user_id'])));
    }

?>

<div id="profile" class='col-md-12'>
    <? if ($log == 1) {
        if($role == 'Mentor' && $num > 1) {
            echo "<select name='mentees' id='mentees' onchange='profile()'>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value=$row[0]>" . $mysql->getFullName($row[0]) . "</option>";
                }
            echo "</select>";
            $result = $mysql->getMyMentees($_SESSION['user_id']);
            $row = mysqli_fetch_array($result);
            echo '<div id="content2" name="content"><h2 style="color:#0088cc">' . $mysql->getFullName($row[0]) . '</h2>';
            echo "<hr>";   
        } else {
            echo '<div id="content2" name="content"><h2 id="name" style="color:#0088cc">' . $mysql->getFullName($row[0]) . '</h2>';
            echo "<hr>";   
        }
        echo '<div class="row">
                <div class="col-md-4">';
                    $imgPath="../img/uploads/" . $row[0] . ".jpg";
                    echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                    height: 300px; width: 250px\">";
                    if(file_exists($imgPath)) {
                        echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                    } else {
                        echo "<br><br><br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                    }
                    echo '</div>
                </div>
                <div class="col-md-6">
                    <span style="font-size:1.25em"><b> Graduation Year: </b></span>' .
                        $row[3] . '
                    <br>
                    <span style="font-size:1.25em"><b> Age: </b></span>' . 
                        $row[4] . '
                    <br>
                    <span style="font-size:1.25em"><b> Region: </b></span>' .  
                        $row[5] . '
                    <br><br>
                    <span style="font-size:1.25em"><b> Major: </b></span><br>' .
                        $row[6] . '<br>';
                        if(isset($row[7])) {
                            echo "<p>" . $row[7] . "</p>"; 
                        }
        
                        if(isset($row[8]) && strlen($row[8] > 0)) {
                            echo "<br><span style=\"font-size:1.25em\"><b> Minor: </b></span> ";
                            echo $row[8];
                            if(isset($row[9])) {
                                echo "<br><p>" . $row[9] . "</p>";
                            }
                        }
                    echo '<br>
                    <span style="font-size:1.25em"><b> Activities: </b></span><br>';
                        $array = explode("\n", $row[10]);
                        if(count($array) - 1 > 0) {
                            echo "<ul>";
                            for($i = 0; $i < count($array); ++$i) {
                                echo "<li>" . $array[$i] . "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "No activities entered yet.";
                        }
                    echo '<br>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-size:1.25em"><b> Bio: </b></span><br>';
                            if(isset($row[11]) && strlen($row[11]) > 0) {
                                echo $row[11]; 
                            } else {
                                echo "No bio entered yet."; 
                            }
                    echo '<br>
                </div>
            </div>';
            if(strlen($mysql->getLeadership( $_SESSION['user_id'] )) > 0) {
                echo '<br>
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-size:1.25em"><b> User Experiences: </b></span><br>
                            <p>
                                <em>Keep in mind that you can only see this part because you\'re on Exec!</em>
                            </p>';
                                $num = $mysql->getNumExperiences($row[0]);
                                if($num == 0) {
                                    echo "No user experiences entered yet."; 
                                } else {
                                    $result=$mysql->getExperiences($row[0]);
                                    if (gettype($result) == "boolean") {
                                        echo "failed<br>";
                                    } else {
                                        echo "<ul>";
                                        while ($row2 = mysqli_fetch_array($result)) {
                                            echo "<li>" . $row2[1] . "</li>";
                                        }
                                        echo "</ul>";
                                    }
                                }
                        echo "</div>
                    </div></div>";
            }
        } else {
                echo '
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <h4> You aren\'t paired yet, so there\'s nothing to display here! This page will show up as soon as 
                        you are matched...make sure to check back later! </h4>
                    </div>
                </div>';
        }
    ?>
</div>	
<script type="text/javascript">
    function profile() {
        var un = document.getElementById("mentees").value;
        $.ajax({
            url: 'paired.php',
            data: { user: un }, 
            success: function(data){
                $('#content2').html(data);   
            }
        });
    }
</script>