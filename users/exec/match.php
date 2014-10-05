<?

    session_start(); // on every page that sessions are used in
    require_once '../../classes/mysql.php';
    $mysql = new Mysql();
    $paired = $_SESSION["paired"];
    $pairedphrase = "";

    //check POST data, pair mentors if they exist
    if($paired == 1) {
        $mentor_name = $mysql->getFullName($_SESSION["mentor_id"]);
        $mentee_name = $mysql->getFullName($_SESSION["mentee_id"]);
        $mentee_id = $_SESSION['mentee_id'];
        $pairedphrase = "Paired $mentor_name and $mentee_name successfully! ";
        $pairedphrase .= "<br><br><h4><a href = \"javascript:void(0)\" onclick=\"undopair('$mentee_id')\">
                        Click here to undo this pairing.</a></h4>";
        unset($_SESSION["paired"]);
    }
?>

<div class="col-md-11">
    <?
        if ($paired == 1) {
            echo "<h3 id=\"pairedphrase\">$pairedphrase</h3>";
        }

        $result = $mysql->getMenteeNum(); 
        if ($result==0) {
            echo "<h2><center>No mentees right now.</h2>";
        } else {
            echo "<form method=\"post\" action=\"../actions/addPair.php\" class=\"form-inline\" style=\"height:695px;\">";
            echo "<h2>Pair Mentors and Mentees</h2><hr>";
            
            //mentor dropdown            
                //get array of mentors and populate 
                $result = $mysql->getMentors();
                if (gettype($result) == "boolean") {
                    echo "failed<br>";
                } else {
                    echo "<div class=\"row\">
                            <div class=\"col-md-6\">
                               <span style=\"font-size:1.25em;\"><b>Mentors: </b></span> <br>
                                <select name=\"mentors\" id=\"mentors\">";
                                while ($row = mysqli_fetch_array($result)) {
                                    $id = $row['username'];
                                    $firstname = $row['first_name'];
                                    $lastname = $row['last_name'];
                                    $major = $row['major'];
                                    if($major != "Engineering Science") {
                                        $major = str_replace("Engineering", "", $major);
                                    }
                                    if ($major != "") {
                                        $displaytext=$firstname." ".$lastname." | ".$major;
                                    } else {
                                        $displaytext=$firstname." ".$lastname;
                                    }
                                    if(strlen($displaytext) > 0 && strlen($id) > 0) {
                                        echo "<option value=\"$id\">$displaytext</option>";
                                    }
                                }
                            echo "</select>
                        </div>";
                }
            
            //mentee dropdown
            //get array of mentees and populate 
            $result = $mysql->getMentees();
            
            if (gettype($result) == "boolean") {
                echo "failed<br>";
            } else {
                echo "<div class=\"col-md-6\">";
                    echo "<span style=\"font-size:1.25em;\"><b>Mentees: </b></span><br>";
                    echo "<select name=\"mentees\" id=\"mentees\">";
                    while ($row = mysqli_fetch_array($result)) {
                        // echo "$row['mentee_id']</br>";
                        $id = $row['username'];     
                        if(!$mysql->checkMenteePaired($id)) { 
                            echo "here";
                            $firstname = $row['first_name'];
                            $lastname = $row['last_name'];
                            $major = $row['major1'];
                            if ($major != "") {
                                $displaytext=$firstname." ".$lastname." | ".$major;
                            } else {
                                $displaytext=$firstname." ".$lastname;
                            }
                            echo "<option value=\"$id\">$displaytext</option>";
                        }
                    }
                    echo "</select>
                    </div>
                </div>";
            }
            echo "<br>";
            //formrow that uses JS to display personal info
            echo "<div class=\"row\">
                <div class=\"col-md-6\">";
                    echo "<div id=\"mentorInfoSection\"></div>";
                echo "</div>";
                echo "<div class=\"col-md-6\">";
                    echo "<div id=\"menteeInfoSection\"></div>";
                echo "</div>
                </div>";
            
            echo "<br>";
            
            //text field to write a note about why the pairing was made
            echo "<div class=\"row\">";
                echo "<div class=\"col-md-12\">";
                    echo "<textarea name=\"comments\" rows=\"3\" class=\"form-control\"
                            placeholder=\"Write a little note about why these two were paired.\"></textarea>";
                echo "</div>";
            echo "</div>";
            
            //submit button
            echo "<br>
                <div class=\"row\">
                    <div class=\"col-md-6\">";
                    echo "<input class=\"btn btn-lg btn-success\" type=\"submit\" id=\"submit\" value=\"Pair!\" name=\"submit\" />";
                echo "</div>
                </div>";
            echo "</form>";
        }
    ?>

</div>            

<script>
    $( "#mentors" ).change(function () {
        var id = $("#mentors option:selected").val();
        $.get('../actions/mentorInfo.php?mentor_id=' + id,function(data) {
            $( "#mentorInfoSection" ).html( data);
        });
    }).change();

    $( "#mentees" ).change(function () {
        var id = $("#mentees option:selected").val();
        $.get('../actions/menteeInfo.php?mentee_id=' + id,function(data) {
            $( "#menteeInfoSection" ).html( data);
        });
    }).change();

    function undopair(pair_id) {
        $.get('../actions/undoPair.php?mentee_id=' + pair_id);
        $( "#pairedphrase").text("Pairing undone successfully.");
    }
</script>