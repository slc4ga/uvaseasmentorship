<?
    include_once '../classes/mysql.php';
    session_start();
    
    $mysql = New Mysql();

    $er = $_SESSION['er'];

    $role = $mysql->checkRole($_SESSION['user_id']);

    if($role == 'Mentor') { 
        $mentee = $mysql->getNumMentees($_SESSION['user_id']);
        if($mentee > 0) {
            $log = 1;
            $result = $mysql->getMyMentees($_SESSION['user_id']);
        }
    } 
?>
<div class="col-md-11">
    <h2>Submit Log</h2>
    <br>
    <?
        if($log == 1) {             // if matched, should be able to submit log
            echo '
            <span>
                <em>
                    Please fill out the form below to submit a Mentor log. These logs should be completed every two weeks. 
                    <b>All fields are required.</b>
                </em>
            </span>';
                if($er == "details") {
                    echo "<br><br><div class=\"alert alert-danger alert-dismissable\">  
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                            <strong>Uh-oh!</strong> Some details are missing. Try filling out the form again.
                        </div>"; 
                    unset($_SESSION['er']);
                }
            echo '<hr>
            <form name="myForm" method="post" action="../actions/saveLog.php">
                <div class="row"> 
                    <div class="col-md-5">
                        <span style="font-size: 1.1em"><b>Mentee:   </b></span>';
                        if($mentee > 1) { 
                            echo "<select name='mentee'>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value=" . $row[0] . ">" . $mysql->getFullName($row[0]) . "</option>";
                            }
                            echo "</select>";
                        } else {
                            $row = mysqli_fetch_array($result);
                            echo "<input type='text' class='form-control' readonly 
                                    value='" . $mysql->getFullName($row[0]) . "'/>";
                            $_SESSION['mentee'] = $row[0];
                        }
                    echo '</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="activity">Activity: </label>
                        <textarea id="activity" class="form-control" name="activity" 
                              placeholder="What did you and your mentee do?" style="width:100%" rows="6"></textarea>
                    </div> 
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="concerns">Concerns: </label>
                        <textarea id="concerns" class="form-control" name="concerns" 
                              placeholder="Do you have any concerns about your mentee?" style="width:100%" rows="6"></textarea>
                    </div> 
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="academic">Academic Satus: </label>
                        <textarea id="academic" class="form-control" name="academic" 
                              placeholder="How is your mentee doing academically?" style="width:100%" rows="6"></textarea>
                    </div> 
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="summary">Summary: </label>
                        <textarea id="summary" class="form-control" name="summary" 
                              placeholder="Please give a few sentence summary of your mentee\'s status and progress." 
                              style="width:100%" rows="6"></textarea>
                    </div> 
                </div>
                <br>
                <button class="btn btn-lg btn-success" type="submit"> Submit Log </button>   
             </form>';
        } else {
            echo '
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h4> You don\'t have a mentee yet, so don\'t worry about submitting a log! This page will show up as soon as 
                    you are matched...make sure to check back later! </h4>
                </div>
            </div>';
        }
    ?>
</div>