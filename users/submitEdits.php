<?
    include_once '../classes/mysql.php';
    session_start();

    $mysql = New Mysql();
    if(!isset($_SESSION['user_id'])) {
        header("location: ../index.php");
    }


    if($_POST) {
        $activities = $_POST['activities'];
        $array = explode("\n", $activities);
        $mysql->updateProfile($_POST['year'], $_POST['age'], $_POST['region'], $_POST['major'], $_POST['major2'], 
                              $_POST['minor'], $_POST['minor2'], $_POST['activities'], $_POST['bio']);  
            
        // experiences
        $mysql->removeExperiences($_SESSION['user_id']);
        $cbnames=array_keys($_POST);
        if(count($cbnames) != 0) {
           $id_numbers=array();
           foreach($cbnames as &$val) {
               if (isset($_POST[$val]) && substr($val, 0, 1) == 'x') {
                   $str = substr($val, 1);
                   if(is_numeric($str)) {
                        $mysql->addExperience($_SESSION['user_id'], $_POST[$val], "Mentor");
                   }
               } 
           }
        }
        header("location:userHome.php?select=2");
    }
?>