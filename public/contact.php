<?
    include_once '../classes/mysql.php';
    
    $mysql = New Mysql();

    if($_POST) {
        if(!empty($_POST['name']) && !empty($_POST['reply']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
            $mysql->sendMessage($_POST['name'], $_POST['reply'], $_POST['subject'], $_POST['message']);
        }
        else {
            header("location:contact.php?er=details");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>	
        <title>Contact Mentorship Exec</title> 

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
                    <h1>Contact Exec</h1>
                    <span>
                        <em>
                            Please fill out the form below to send a message to the Mentorship Exec Board. Someone will get back to you as 
                            soon as possible, but please be patient! That being said, please send your message again if you haven't 
                            received a response within <b>3</b> days. <b>All fields are required.</b>
                        </em>
                    </span>
                    <?
                        $er = $_GET['er'];
                        if($er == 'details') {
                            echo "<div class=\"alert alert-danger\">  
                                    <a class=\"close\" data-dismiss=\"alert\">×</a>  
                                    <strong>Uh-oh!</strong> Some details are missing. Try filling out the form again.
                                </div>";      
                        }
                     ?>
                    <hr>
                    <form name="myForm" method="post" action="#">
                        <div class="row"> 
                            <div class="col-md-5">
                                <label for="name">Name: </label>
                                <input type="text" class="form-control" name="name" />
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="reply">Reply-To: </label>
                                <input type="email" class="form-control" name="reply" placeholder="email@example.com"/>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="subject">Subject: </label>
                                <input type="text" name="subject" class="form-control" />
                            </div>  
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="message">Message Content: </label>
                                <textarea id="message" class="form-control" name="message" 
                                      placeholder="Type message here." style="width:100%" rows="6"></textarea>
                            </div> 
                        </div>
                        <br>
                        <button class="btn btn-lg btn-success" type="submit"> Send Message </button>   
                     </form>
                </div>	
            </div>
            <?
                include '../nav/footer.php';
            ?>
        </div>
    </body>
</html>