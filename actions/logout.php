<?
    session_start();
    unset($_SESSION["user_id"]);  
    unset($_SESSION['role']); 
    header("Location: ../index.php");
?>