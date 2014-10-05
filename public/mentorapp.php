<?php
    session_start(); // on every page that sessions are used in
    require_once '../classes/mysql.php';
    $mysql = new Mysql();
    
    // check to see if logout clicked
    if(isset($_GET['status']) && $_GET['status'] == 'loggedOut') {
        $mysql->log_user_out();
    }

?>
<div class="col-md-11">        
    <h1>New Mentor Account</h1>
    <p>
        Fill out the form below to apply for the program as a <em><b>mentor</b></em> only. Required fields are labeled in red.
    </p>
    <hr>
    
    <? 
        $error = $_GET['error'];
        if(isset($error) && $error == 'un') {
            echo "<div class=\"alert alert-danger alert-dismissable\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                    <strong>Uh-oh!</strong> Looks like that username is already taken...try again! If you're sure you typed it right, 
                            try <a href=\"getpass.php\">retreiving your password</a>.
                </div>";        
        }
    ?>
    
    <form method="post" action="../actions/addMentor.php" class="form-inline"><fieldset>
<div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em; color: red"><b> First Name: </b></span> <br>
                <input type="text" name="fname" id="fname" class="form-control required" style="width: 50%" />
            </div>
            <div class="col-md-6">
                <span style="font-size:1.25em; color:red"><b> Last Name: </b></span> <br>
                <input type="text" name="lname" id="lname" class="form-control required" style="width: 50%" />
            </div>
        </div>
		<br>
		<div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em; color:red"><b> Computing ID: </b></span><br>
                <input type="text" name="un" id="un" class="form-control required" style="width: 50%" placeholder="abc1de"/>
            </div>
		    <div class="col-md-6">
                <span style="font-size:1.25em; color:red"><b> Graduation year: </b></span><br>
                <input type="number" class="form-control required" style="width: 25%" name="year" id="year"
                       min="2010" max="2030" placeholder="2015">
		    </div>               
		</div>
        <br>
		<div class="row">  
            <div class="col-md-6">
                <span style="font-size:1.25em; color:red"><b> Age: </b></span><br>
                <input type="number" name="age" min="15" max="30" id="age"
                       class="form-control required" style="width: 20%" placeholder="18">
            </div>
		    <div class="col-md-6">
                <span style="font-size:1.25em; color: red"><b> Region: </b></span><br>
                <div class="radio">
                    <input type="radio" id="region" name="region" value="In-state" >  In-State<br>
                    <input type="radio" id="region" name="region" value="Out-of-state" >  Out-of-State<br>
                    <input type="radio" id="region" name="region" value="International" >  International<br>
                </div>
		    </div>
        </div>	
        <br>
		<div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em; color:red"><b> Major: </b></span><br>
            </div>
		    <div class="col-md-4">
                <span style="font-size:1.25em;"><b> Second Major: </b></span><br>
            </div>
        </div>
        <div class="row">
		    <div class="col-md-3">
                <input type="radio" class="required" id="major" name="major" value="Aerospace Engineering">  Aerospace<br>
                <input type="radio" class="required" id="major" name="major" value="Chemical Engineering">  Chemical<br>
                <input type="radio" class="required" id="major" name="major" value="Computer Engineering">  Computer <br>
                <input type="radio" class="required" id="major" name="major" value="Electrical Engineering">  Electrical<br>
                <input type="radio" class="required" id="major" name="major" value="Mechanical Engineering">  Mechanical<br>
		    </div>
		    <div class="col-md-3">
			    <input type="radio" class="required" id="major" name="major" value="Biomedical Engineering">  Biomedical<br>
			    <input type="radio" class="required" id="major" name="major" value="Civil Engineering">  Civil/Environmental<br>
			    <input type="radio" class="required" id="major" name="major" value="Computer Science">  Computer Science<br>
			    <input type="radio" class="required" id="major" name="major" value="Engineering Science">  Engineering Science<br>
			    <input type="radio" class="required" id="major" name="major" value="Systems Engineering">  Systems<br>
		    </div> 
            <div class="col-md-4">
                <input type="text" class="form-control required" name="major2" id="major2" style="width: 80%" disabled/>
            </div>
		</div>
        <br>
		<div class="row">
		    <div class="col-md-6">
                <span style="font-size:1.25em;"><b> Minor: </b></span><br>
                <input type="text" name="minor" id="minor" class="form-control required" style="width: 50%" disabled/>    
		    </div>
            <div class="col-md-6">
                <span style="font-size:1.25em;"><b> Second Minor: </b></span><br>
                <input type="text" name="minor2" id="minor2" class="form-control required" style="width: 50%" disabled/>
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
        <div class="row">
		    <div class="col-md-6">
                <input type="checkbox" name="x1" value="Transfer student">  Transfer student<br>
                <input type="checkbox" name="x2" value="International student">  International student<br>
                <input type="checkbox" name="x3" value="Military connections">  Military connections<br>
                <input type="checkbox" name="x4" value="Greek life">  Greek life<br>
                <input type="checkbox" name="x5" value="Homeschooled">  Homeschooled<br>
                <input type="checkbox" name="x6" value="Overcommitted">  Overcommitted<br>
                <input type="checkbox" name="x7" value="Homesickness">  Homesick<br>
                <input type="checkbox" name="x8" value="Feeling isolated">  Feeling isolated<br>
                <input type="checkbox" name="x9" value="Feeling overwhelmed">  Feeling overwhelmed<br>
                <input type="checkbox" name="x10" value="Feelings of anxiety">  Feelings of anxiety<br>
                <input type="checkbox" name="x11" value="No alcohol use">  No alcohol use<br>
                <input type="checkbox" name="x12" value="Extreme alcohol use">  Extreme alcohol use<br>
                <input type="checkbox" name="x13" value="Illegal drug use">  Illegal drug use<br>
		    </div>
		    <div class="col-md-6">
                <input type="checkbox" name="x14" value="Dealt with CAPS">  Dealt with CAPS<br>
                <input type="checkbox" name="x15" value="Eating disorder">  Eating disorder<br>
                <input type="checkbox" name="x16" value="Money problems">  Money problems<br>
                <input type="checkbox" name="x17" value="Roommate problems">  Roommate problems<br>
                <input type="checkbox" name="x18" value="Family problems">  Family problems<br>
                <input type="checkbox" name="x19" value="Relationship problems">  Relationship problems<br>
                <input type="checkbox" name="x20" value="Failed a test">  Failed a test<br>
                <input type="checkbox" name="x21" value="Failed a class">  Failed a class<br>
                <input type="checkbox" name="x22" value="Academic probation">  Academic probation<br>
                <input type="checkbox" name="x23" value="Disability">  Disability<br>
                <input type="checkbox" name="x24" value="Suicide">  Suicide<br>
                <input type="checkbox" name="x25" value="Depression">  Depression<br>
                <input type="checkbox" name="x26" value="Death">  Death<br>
		    </div>
		</div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span style="font-size:1.25em; color: red"><b> Time commitment: </b></span><br>
                <div class="radio">
                    <input type="radio" id="time" name="time" value="0-2">  0-2 hours<br>
                    <input type="radio" id="time" name="time" value="3-5">  3-5 hours<br>
                    <input type="radio" id="time" name="time" value="6-7">  6-7 hours<br>
                    <input type="radio" id="time" name="time" value="8">  8+ hours<br>
                </div>
            </div>
            <div class="col-md-5">
                <span style="font-size:1.25em; color: red"><b> Available for training?: </b></span><br>
                Mentor training this semester is on <b><em>Sunday, September 15th</em></b> from 3-4 p.m. <br>
                <div class="radio">
                    <input type="radio" id="training" name="training" value="Yes">  Yes<br>
                    <input type="radio" id="training" name="training" value="No">  No<br>
                </div>
            </div>
		</div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em; color: red"><b> Describe any previous mentoring experience. </b></span><br>
                <textarea name="previous" id="previous" rows="6" class="form-control"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em; color: red"><b> Why do you want to participate in the Mentorship program? </b></span><br>
                <textarea name="reason" id="reason" rows="6" class="form-control"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span style="font-size:1.25em; color: red"><b> Describe your personal interests. </b></span><br>
                <textarea name="interests" id="interests" rows="6" class="form-control"></textarea>
            </div>
        </div>
        <br>
        <hr>
        <input type="submit" class="btn btn-success btn-lg" id="submit" value="Create" name="submit" disabled/>
    </fieldset></form>
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
            $( "#minor" ).prop('disabled', true);
        }
        else {
            $( "#major2" ).prop('disabled', false);
            $( "#major2" ).attr("placeholder", "Second Major");
            
            $( "#minor" ).prop('disabled', false);
            $( "#minor" ).attr("placeholder", "Minor");
        } 
        validate();
    });
    
    $( "input[name='region']" ).change(function(){
        validate();
    });
    
    $( "input[name='time']" ).change(function(){
        validate();
    });
    
    $( "input[name='training']" ).change(function(){
        validate();
    });
    
    $( '#fname, #lname, #un, #year, #age, #previous, #reason, #interests' ).keyup(function(){
        validate();
    });

    
    function validate(){
        if (!!$("#fname").val()  &&
            !!$("#lname").val()  &&
            !!$("#un").val()  &&
            !!$("#year").val()  &&
            !!$("#age").val()  &&
            !!$("#reason").val()  &&
            !!$("#previous").val()  &&
            !!$("#interests").val()  &&
            !!$("#major").val() ) {
            $("input[type=submit]").prop("disabled", false);
        } else {
            $("input[type=submit]").prop("disabled", true);
        }
    }

</script>