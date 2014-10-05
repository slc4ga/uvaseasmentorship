<?    
    require_once '../classes/mysql.php';
    $mysql = new Mysql();
    
    echo $_GET['mentee_id'];

    $mysql->undoPair($_GET["mentee_id"]);
    header("location: ../users/exec.php?select=4");
?>