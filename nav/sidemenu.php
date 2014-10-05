<?
    $pageName = $_SERVER['PHP_SELF'];
?> 

<div class="col-md-3">
     
     <ul class="nav nav-pills nav-stacked">
        <li class="nav-header">Who we are?</li>
        <li <? if ($pageName == "/~Steph/Mentorship/index.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/Mentorship/index.php">Home</a></li>
        <li <? if ($pageName == "/~Steph/Mentorship/public/calendar.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/Mentorship/public/calendar.php">Calendar</a></li>
        <li <? if ($pageName == "/~Steph/Mentorship/public/pics.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/Mentorship/public/pics.php">Photos</a></li>
        <li <? if ($pageName == "/~Steph/Mentorship/public/contact.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/Mentorship/public/contact.php">Contact Us</a></li>
        <hr>
        <li class="nav-header">Useful links</li>
        <li ><a href="http://www.virginia.edu/">UVa Home </a></li>
        <li ><a href="http://seas.virginia.edu/">UVa Engineering</a></li>
        <li ><a href="/~Steph/Mentorship/public/signup.php">Sign Up</a></li>
    </ul>
     
</div>
									