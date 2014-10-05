<?php
	include_once('../classes/mysql.php');
	session_start();
	$mysql = new Mysql();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    $row = $mysql->getInfo($_SESSION['user_id'])->fetch_array(MYSQLI_NUM);
    $role = $mysql->checkRole($_SESSION['user_id']);

?>

<div id="profile" class='col-md-12'>
    <h2 style="color:#0088cc"> <? echo $mysql->getFullName($_SESSION['user_id']); ?> </h2>
    <?
        //check leadership
        $pos = $mysql->getLeadership($_SESSION['user_id']);
        if(isset($pos)) {
            echo "<h3>" . $pos . "</h3>";
        }
    ?>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?
                $imgPath="../img/" . $_SESSION['user_id'] . ".jpg";
                echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                height: 300px; width: 250px\">";
                if(file_exists($imgPath)) {
                    $imgPath="http://uvaseasmentorship.com/img/" . $_SESSION['user_id'] . ".jpg?" . Time();
                    echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                } else {
                    echo "<br><br><br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                }
                echo "</div>";
            ?>
        </div>
        <div class="col-md-6">
            <span style="font-size:1.25em"><b> Graduation Year: </b></span>
                <? echo $row[3]; ?>
            <br>
            <span style="font-size:1.25em"><b> Age: </b></span> 
                <? echo $row[4]; ?>
            <br>
            <span style="font-size:1.25em"><b> Region: </b></span> 
                <? echo $row[5]; ?>
            <br><br>
            <span style="font-size:1.25em"><b> Major: </b></span><br>
            <?
                echo $row[6] . "<br>";
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
            ?>
            <br>
            <span style="font-size:1.25em"><b> Activities: </b></span><br>
            <? 
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
            ?>
            <br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span style="font-size:1.25em"><b> Bio: </b></span><br>
                <? 
                    if(isset($row[11]) && $row[11] != "NULL") {
                        echo $row[11]; 
                    } else {
                        echo "No bio entered yet."; 
                    }
                ?>
            <br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span style="font-size:1.25em"><b> User Experiences: </b></span><br>
            <p>
                <em>Don't worry, only Exec can see these!</em>
            </p>
            <? 
                $num = $mysql->getNumExperiences($_SESSION['user_id']);
                if($num == 0) {
                    echo "No user experiences entered yet."; 
                } else {
                    $result=$mysql->getExperiences($_SESSION['user_id']);
                    if (gettype($result) == "boolean") {
                        echo "failed<br>";
                    } else {
                        echo "<ul>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<li>" . $row[1] . "</li>";
                        }
                        echo "</ul>";
                    }
                }
            ?>
        </div>
    </div>
</div>
		