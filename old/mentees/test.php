<?php
    require_once '../classes/membership.php';
    $membership = new Membership();
?>
<html>
<head>
</head> <body>
<input type=number name=car min="2" max="200" style="margin-top: 10px;" value='<? echo $membership->getCar($_SESSION['username']) ?>'>
</body>
</html>