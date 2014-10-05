<!DOCTYPE html>

<html>
    
    <head>
        <meta charset="utf-8"/>	
        <title>UVa SEAS Mentorship Calendar</title> 

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="../bootstrap/js/bootbox.min.js"></script>
        <script src="../bootstrap/js/bootstrap.js"></script>
        
        <script src="../bootstrap/lightbox/js/jquery-1.10.2.min.js"></script>
        <script src="../bootstrap/lightbox/js/lightbox-2.6.min.js"></script>
    
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="../bootstrap/css/carousel.css" >
        <link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
        <link href="../bootstrap/lightbox/css/lightbox.css" rel="stylesheet" />
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet" />

        
    </head>

    <body>
        <div class="container">
            <? 
                include '../nav/navbar.php'; 
            ?>
        
            <div class="row">
                <? 
                    include '../nav/sidemenu.php';
                ?>
                <div class="col-md-8">	
                    <h1>Calendar</h1>
                    <span>
                        <em>
                            We try to keep this calendar updated with our event schedule, but bear with us if some 
                            events don't show up!
                        </em>
                    </span>
                    <hr>
                    <iframe src="https://www.google.com/calendar/embed? src=uvaseasmentorship%40gmail.com&title=UVa%20SEAS%20Mentorship&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=400&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=America%2FNew_York" 
                            style=" border-width:0 " width="600" height="400" frameborder="0" scrolling="no"></iframe>
	           </div>
            </div>					  
            <br>
            <?
                include '../nav/footer.php';
            ?>
        </div>
    </body>
</html>