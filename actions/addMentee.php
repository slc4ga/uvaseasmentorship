<?
    include '../classes/mysql.php';
    $mysql = New Mysql();

    if($_POST && $_POST['submit']) {
        $response = $mysql->addUser($_POST['un'], $_POST['pw'], "Mentee", $_POST['fname'], $_POST['lname'],
                                        $_POST['year'], $_POST['major'], $_POST['major2'],
                                        $_POST['minor'], $_POST['minor2'], $_POST['age'],
                                        $_POST['region'], null, null, null, null, null);
        if($response == "userexists") {
            header("location: ../public/application.php?select=1&error=un");
        } else {
        
            // experiences
            $cbnames=array_keys($_POST);
            if(count($cbnames) != 0) {
               $id_numbers=array();
               foreach($cbnames as &$val) {
                   if (isset($_POST[$val]) && substr($val, 0, 1) == 'x') {
                       $str = substr($val, 1);
                       if(is_numeric($str)) {
                            $mysql->addExperience($_POST['un'], $_POST[$val], "Mentee");
                       }
                   } 
               }
            }
            
            header("location: ../users/userHome.php");
        }
    } 
?>