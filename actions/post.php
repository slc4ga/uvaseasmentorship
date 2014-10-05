<?
    session_start(); // on every page that sessions are used in
    require_once '../classes/mysql.php';
    $mysql = new Mysql();

    if(isset($_POST['submit'])) {
        $text = $_POST['announcement'];
        $fixed = str_replace("\n", "<br>", $text);
        $mysql->addAnnouncement($_POST['subject'], $_POST['emails'], $fixed);
        header("location:../users/exec.php");
    }
?>