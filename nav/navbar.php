<?
    $pageName = $_SERVER['PHP_SELF'];
?>

<div class="row">
    <div class="col-md-9">
        <h1>
            <a href="/index.php">UVa SEAS Mentorship</a>
        </h1>
        <h4 style="margin-left: 40px;"> est. 2012</h4>
    </div>
</div>
<div class="navbar navbar-default" role="navigation">
        <ul class="nav navbar-nav">
            <li <? if ($pageName == "/~Steph/Mentorship/index.php") { echo "class=\"active\""; } ?> >
                <a href="/~Steph/Mentorship/index.php">Home</a></li>
            <li <? if ($pageName == "/~Steph/Mentorship/public/pics.php") { echo "class=\"active\""; } ?> >
                <a href="/~Steph/Mentorship/public/pics.php">Photos</a></li>
            <li  <? if ($pageName == "/~Steph/Mentorship/public/calendar.php") { echo "class=\"active\""; } ?>>
                <a href="/~Steph/Mentorship/public/calendar.php">Calendar</a></li>
            <li <? if ($pageName == "/~Steph/Mentorship/public/contact.php") { echo "class=\"active\""; } ?> >
                <a href="/~Steph/Mentorship/public/contact.php">Contact</a></li>
        </ul>
        
        <ul class="nav navbar-nav pull-right" role="navigation">
            <?
                
                if(isset($_SESSION['user_id'])) {
                    echo "<li";
                        if ($pageName === "/~Steph/Mentorship/users/userHome.php") { 
                            echo " class=\"active\""; 
                        } 
                    echo "> <a href=\"/~Steph/Mentorship/users/userHome.php\">My Account </a></li>";
                } else {
                     echo "<li";
                        if ($pageName === "/~Steph/Mentorship/public/application.php") { 
                            echo " class=\"active\""; 
                        } 
                    echo "> <a href=\"/~Steph/Mentorship/public/application.php\">Sign Up </a></li>";
                }
            ?>
            <li class="divider-vertical"></li>
            <?
                if(!isset($_SESSION['user_id'])) {
                    echo "<li class=\"dropdown\">";
                    echo "<a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Sign In  
                        <strong class=\"caret\"></strong></a>
                    <div class=\"dropdown-menu\" style=\"padding: 15px; width:225px\">
                <!-- Login form here -->";
                    include "file:///Users/Steph/Sites/Mentorship/public/login.php";
                    echo "</div></li>";
                } else {
                    echo "<li> <a href=\"/~Steph/Mentorship/actions/logout.php\">Logout </a></li>";
                }
                ?>
                <li></li>
        </ul>
</div>