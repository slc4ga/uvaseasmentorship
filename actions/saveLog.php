<?php

    require_once '../classes/mysql.php';
    $mysql = new Mysql();
    session_start();

    if($_POST) {
        if(!empty($_POST['activity']) && !empty($_POST['concerns']) && !empty($_POST['academic']) && !empty($_POST['summary'])) {
            $mentee = $mysql->getNumMentees($_SESSION['user_id']);
            if($mentee > 1) {
                $mysql->saveLog($_POST['mentee'], $_POST['activity'], $_POST['concerns'], $_POST['academic'], $_POST['summary']);
            } else {
                $mysql->saveLog($_SESSION['mentee'], $_POST['activity'], $_POST['concerns'], $_POST['academic'], $_POST['summary']);
                unset($_SESSION['mentee']);
            }

            $_SESSION['er'] = "success";
            header("location: ../users/userHome.php");
        }
        else {
            $_SESSION['er'] = "details";
            header("location:../users/userHome.php?select=6");
        }
    }
?>