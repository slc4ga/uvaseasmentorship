<?
    session_start();
?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8"/>	
        <title>UVa SEAS Mentorship</title> 

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="bootstrap/js/bootbox.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
    
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="bootstrap/css/carousel.css" >
        <link rel="stylesheet" href="bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />

        
    </head>

    <body>
        <div class="container">
            <? 
                include 'nav/navbar.php'; 
            ?>
	 
            <div class="jumbotron" style="padding: 0px; height: 425px">
                <div id="myCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="item active" style="height: 425px">
                            <img src="img/static/thornton.jpg" alt="E School" style="height: 425px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <? 
                    include 'nav/sidemenu.php';
                ?>
                <div class="col-md-8">	
                    <h1>Welcome!</h1>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        The Rotunda - classic UVA...but few engineers every actually visit Central Grounds. Instead, the home of 
                        the UVa School of Engineering and Applied Sciences, Thornton Hall, is the meeting place for most students 
                        looking to get some work done. The newly founded SEAS mentoring program holds study hours here, attempting 
                        to help students of all years handle the tough engineering workload while still having a great time in
                        Charlottesville. Mentors are carefully screened and trained to deal with anything their mentees might 
                        need help with, and are in contact with the Exec Board and a faculty member on a regular basis. <br>
                    </p>
                    
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        The Engineering Mentorship program, founded and sponsored by Assistant Dean and APMA Professor Mary Beck,
                        brings students together based primarily on major, but also on life experiences. We undersatnd that 
                        students come from all different backgrounds, and we aim to make sure that every Engineering student is 
                        able to make the most of their experience here at Mr. Jefferson's University.<br>
                    </p>
                    
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        While our founding goal was aimed at academic success, the Mentorship program is working on bringing our 
                        mentors and mentees closer together. We have study sessions once a week where our mentors and mentees can 
                        get to know each other, semester hikes up Humpback Mountain and other local hiking trails, visits to the 
                        Farmer's Market on the Downtown Mall, and more pizza parties than you can count! Engineers work hard, but 
                        we also appreciate a little down time sometimes. Check out our website and let us know if you have any 
                        questions or concerns - we welcome new members and are always open to new ideas for the program!<br>
                    </p>
                    <br>
                    <p>
                        Need to sign up for an account? Click the link above.
                    </p>
                    <br>
                    <p>
                        Looking for more information? Try the email link to the Exec Board on the right.
                    </p>
            
                    
                    <br> 
                </div>
            </div>
    
        <!-- footer starts here-->	
        <?
            include 'nav/footer.php';
        ?>
        </div>
    </body>
</html>