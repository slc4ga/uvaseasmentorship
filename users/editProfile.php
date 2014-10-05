<?

    require_once '../classes/mysql.php';
    require_once '../classes/constants.php';
    
    $mysql = new Mysql();
                                            
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }

    
    $row = $mysql->getInfo($_SESSION['user_id'])->fetch_array(MYSQLI_NUM);

?>
<div class="col-md-11">
    <h2> Edit Profile </h2>
    <p>
        Fill out the form below to edit your profile.
    </p>
    <hr>
        <div class="row">
            <div class="col-md-5">
                <?
                    $imgPath="../img/" . $_SESSION['user_id'] . ".jpg";
                    //echo $imgPath;
                    echo "<div style=\"text-align: center; border-style: solid; border-radius: 1px; 
                    height: 300px; width: 250px\">";
                    if(file_exists($imgPath)) {
                        $imgPath="http://uvaseasmentorship.com/img/" . $_SESSION['user_id'] . ".jpg?" . Time();
                        echo "<img src=\"$imgPath\" style=\"height: 294px; width: 244px\">";
                    } else {
                        echo "<br><br><br><br><em><b>No picture uploaded yet!</b></em>";
                    }
                    echo "</div>";
                ?>
            </div>
            <div class="col-md-6" style="margin-left: -40px">
                <form action="picUpload.php" method="post" enctype="multipart/form-data" >
                     <label> Please specify a picture file: </label>
                     <input type="file" name="file" id="file"><br><br>
                     <input type="submit" name="picUpload" class="btn btn-success" value="Upload">
                </form>
            </div>
        </div>
        <br>
        <form action="submitEdits.php" class="form-inline" method="post" >
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Year: </b></span> 
                <input type="number" name="year" class = "form-control" style="width: 50%" min="2014" max="2040" 
                       <? 
                            if(isset($row[4])) {
                                echo "value=\"$row[3]\""; 
                            } else {
                                echo "placeholder=\"2017\"";
                            }
                       ?> />
                <br><br>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em"><b> Age: </b></span> 
                <input type="number" name="age" class = "form-control" style="width: 50%" min="16" max="30" 
                       <? 
                            if(isset($row[4])) {
                                echo "value=\"$row[4]\""; 
                            } else {
                                echo "placeholder=\"20\"";
                            }
                       ?> />
                <br><br>
            </div>
        </div>
        <br>
        <div class="row">
		    <div class="col-md-6">
                <span style="font-size:1.25em;"><b> Region: </b></span><br>
                <div class="radio">
                    <input type="radio" id="region" name="region" value="In-state" 
                           <? if($row[5] == "In-state") { echo "checked"; } ?> >  In-State<br>
                    <input type="radio" id="region" name="region" value="Out-of-state" 
                           <? if($row[5] == "Out-of-state") { echo "checked"; } ?> >  Out-of-State<br>
                    <input type="radio" id="region" name="region" value="International" 
                           <? if($row[5] == "International") { echo "checked"; } ?> >  International<br>
                </div>
		    </div>
		</div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <span style="font-size:1.25em" ><b> Major: </b></span><br>
                <input type="radio" id="major" name="major" value="Aerospace Engineering" 
                       <? if($row[6] == "Aerospace Engineering") { echo "checked"; } ?> /> Aerospace <br>
                <input type="radio" id="major" name="major" value="Chemical Engineering"
                       <? if($row[6] == "Chemical Engineering") { echo "checked"; } ?> /> Chemical <br>
                <input type="radio" id="major" name="major" value="Computer Engineering" 
                       <? if($row[6] == "Computer Engineering") { echo "checked"; } ?> /> Computer <br>
                <input type="radio" id="major" name="major" value="Electrical Engineering"
                       <? if($row[6] == "Electrical Engineering") { echo "checked"; } ?> /> Electrical <br>
                <input type="radio" id="major" name="major" value="Mechanical Engineering"
                       <? if($row[6] == "Mechanical Engineering") { echo "checked"; } ?> /> Mechanical <br>
                <input type="radio" id="major" name="major" value="Biology"
                       <? if($row[6] == "Biology") { echo "checked"; } ?> /> Biology <br>
            </div>
            <div class="col-md-3">
                <br>
                <input type="radio" id="major" name="major" value="Biomedical Engineering" 
                       <? if($row[6] == "Biomedical Engineering") { echo "checked"; } ?> /> Biomedical <br>
                <input type="radio" id="major" name="major" value="Civil Engineering"
                       <? if($row[6] == "Civil Engineering") { echo "checked"; } ?> /> Civil <br>
                <input type="radio" id="major" name="major" value="Computer Science" 
                       <? if($row[6] == "Computer Science") { echo "checked"; } ?> /> Computer Science <br>
                <input type="radio" id="major" name="major" value="Engineering Science"
                       <? if($row[6] == "Engineering Science") { echo "checked"; } ?> /> Engineering Science <br>
                <input type="radio" id="major" name="major" value="Systems Engineering"
                       <? if($row[6] == "Systems Engineering") { echo "checked"; } ?> /> Systems <br>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Second Major: </b></span>
                <input type="text" id="major2" name="major2" class="form-control" style="width: 70%"                     
                        <? 
                            if(!isset($row[6])) { 
                                echo "disabled"; 
                            } else {
                                if(isset($row[7]) && strlen($row[7]) > 0) {
                                    echo "value=\"$row[7]\""; 
                                } else {
                                    echo "placeholder=\"Second Major\"";
                                }
                            }
                        ?> />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Minor: </b></span> 
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="minor" name="minor" class="form-control" style="width: 70%"                     
                            <? 
                                if(isset($row[8]) && strlen($row[8]) > 0) {
                                    echo "value=\"$row[8]\""; 
                                } else {
                                    echo "placeholder=\"Minor\"";
                                }
                            ?> />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em" ><b> Second Minor: </b></span> 
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="minor2" name="minor2" class="form-control" style="width: 70%"                     
                            <? 
                                if(!isset($row[8]) || strlen($row[8]) < 1) { 
                                    echo "disabled"; 
                                } else {
                                    if(isset($row[9])) {
                                        echo "value=\"" . $row[9] . "\""; 
                                    } else {
                                        echo "placeholder=\"Second Minor\"";
                                    }
                                }
                            ?> />
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-11">
                <span style="font-size:1.25em;"><b> User Experiences </b></span>
                <p> 
                    Check the top 7 topics you would feel comfortable discussing.<br>
                </p>
            </div>
        </div>
        <?
            $num = $mysql->getNumExperiences($_SESSION['user_id']);
            if($num !== 0) {
                $result=$mysql->getExperiences($_SESSION['user_id']);
                $exp = "";
                while ($row1 = mysqli_fetch_array($result)) {
                    $exp .= $row1[1] . ", ";
                }
            }
        ?>
        <div class="row">
		    <div class="col-md-6">
                <input type="checkbox" name="x1" value="Transfer student"
                       <? if (strpos($exp,'Transfer student') !== false) { echo 'checked'; } ?> >  Transfer student<br>
                <input type="checkbox" name="x2" value="International student"
                       <? if (strpos($exp,'International student') !== false) { echo 'checked'; } ?> >  International student<br>
                <input type="checkbox" name="x3" value="Military connections"
                       <? if (strpos($exp,'Military connections') !== false) { echo 'checked'; } ?> >  Military connections<br>
                <input type="checkbox" name="x4" value="Greek life"
                       <? if (strpos($exp,'Greek life') !== false) { echo 'checked'; } ?> >  Greek life<br>
                <input type="checkbox" name="x5" value="Homeschooled"
                       <? if (strpos($exp,'Homeschooled') !== false) { echo 'checked'; } ?> >  Homeschooled<br>
                <input type="checkbox" name="x6" value="Overcommitted"
                       <? if (strpos($exp,'Overcommitted') !== false) { echo 'checked'; } ?> >  Overcommitted<br>
                <input type="checkbox" name="x7" value="Homesickness"
                       <? if (strpos($exp,'Homesickness') !== false) { echo 'checked'; } ?> >  Homesick<br>
                <input type="checkbox" name="x8" value="Feeling isolated"
                       <? if (strpos($exp,'Feeling isolated') !== false) { echo 'checked'; } ?> >  Feeling isolated<br>
                <input type="checkbox" name="x9" value="Feeling overwhelmed"
                       <? if (strpos($exp,'Feeling overwhelmed') !== false) { echo 'checked'; } ?> >  Feeling overwhelmed<br>
                <input type="checkbox" name="x10" value="Feelings of anxiety"
                       <? if (strpos($exp,'Feelings of anxiety') !== false) { echo 'checked'; } ?> >  Feelings of anxiety<br>
                <input type="checkbox" name="x11" value="No alcohol use"
                       <? if (strpos($exp,'No alcohol use') !== false) { echo 'checked'; } ?> >  No alcohol use<br>
                <input type="checkbox" name="x12" value="Extreme alcohol use"
                       <? if (strpos($exp,'Extreme alcohol use') !== false) { echo 'checked'; } ?> >  Extreme alcohol use<br>
                <input type="checkbox" name="x13" value="Illegal drug use"
                       <? if (strpos($exp,'Illegal drug use') !== false) { echo 'checked'; } ?> >  Illegal drug use<br>
		    </div>
		    <div class="col-md-6">
                <input type="checkbox" name="x14" value="Dealt with CAPS"
                       <? if (strpos($exp,'Dealt with CAPS') !== false) { echo 'checked'; } ?> >  Dealt with CAPS<br>
                <input type="checkbox" name="x15" value="Eating disorder"
                       <? if (strpos($exp,'Eating disorder') !== false) { echo 'checked'; } ?> >  Eating disorder<br>
                <input type="checkbox" name="x16" value="Money problems"
                       <? if (strpos($exp,'Money problems') !== false) { echo 'checked'; } ?> >  Money problems<br>
                <input type="checkbox" name="x17" value="Roommate problems"
                       <? if (strpos($exp,'Roommate problems') !== false) { echo 'checked'; } ?> >  Roommate problems<br>
                <input type="checkbox" name="x18" value="Family problems"
                       <? if (strpos($exp,'Family problems"') !== false) { echo 'checked'; } ?> >  Family problems<br>
                <input type="checkbox" name="x19" value="Relationship problems"
                       <? if (strpos($exp,'Relationship problems') !== false) { echo 'checked'; } ?> >  Relationship problems<br>
                <input type="checkbox" name="x20" value="Failed a test"
                       <? if (strpos($exp,'Failed a test') !== false) { echo 'checked'; } ?> >  Failed a test<br>
                <input type="checkbox" name="x21" value="Failed a class"
                       <? if (strpos($exp,'Failed a class') !== false) { echo 'checked'; } ?> >  Failed a class<br>
                <input type="checkbox" name="x22" value="Academic probation"
                       <? if (strpos($exp,'Academic probation') !== false) { echo 'checked'; } ?> >  Academic probation<br>
                <input type="checkbox" name="x23" value="Disability"
                       <? if (strpos($exp,'Disability') !== false) { echo 'checked'; } ?> >  Disability<br>
                <input type="checkbox" name="x24" value="Suicide"
                       <? if (strpos($exp,'Suicide') !== false) { echo 'checked'; } ?> >  Suicide<br>
                <input type="checkbox" name="x25" value="Depression"
                       <? if (strpos($exp,'Depression') !== false) { echo 'checked'; } ?> >  Depression<br>
                <input type="checkbox" name="x26" value="Death"
                       <? if (strpos($exp,'Death') !== false) { echo 'checked'; } ?> >  Death<br>
		    </div>
		</div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em"><b> Activities: </b></span> <br>
                <em>Please enter one activity per line.</em>
                <textarea name="activities" id="activities" class="form-control" rows="6"><? 
                            $array = explode("\n", $row[10]);
                            if(count($array) - 1 > 0) {
                                for($i = 0; $i < count($array); ++$i) {
                                    echo $array[$i];
                                }
                            }
                        ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em"><b> Bio: </b></span>
                <textarea name="bio" id="bio" class="form-control" rows="6"><? 
                    if( isset($row[11]) && $row[11] != "NULL") { echo trim($row[11]); } ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <input type='submit' class="btn btn-lg btn-success" type="submit" value="Submit Changes" />
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    
    $( "#minor" ).keyup(function(){
        if( $( "#minor" ).val().length > 0) {
            $( "#minor2" ).prop('disabled', false);
            $( "#minor2" ).attr("placeholder", "Second Minor");
        } else {
            $( "#minor2" ).prop('disabled', true);
            $( "#minor2" ).attr("placeholder", "");
        }
    });
    
    $( "input[name='major']" ).change(function(){
        if (!$("input[name='major']:checked").val()) {
           $( "#major2" ).prop('disabled', true);
        }
        else {
            $( "#major2" ).prop('disabled', false);
            $( "#major2" ).attr("placeholder", "Second Major");
        } 
    });

</script> 
        