<?    
    require_once '../classes/mysql.php';
    $mysql = new Mysql();

    $cbnames=array_keys($_POST);
    if(count($cbnames) != 0) {
        $id_numbers=array();
        foreach($cbnames as &$val) {
            $str = $val;
            if (isset($_POST[$str])) {
                // delete pair
                $str = substr($str, 2);
                //echo $str . "<br>";
                $array = explode(":", $str);
                $mysql->deletePair($array[0], $array[1]);
                header("location: ../users/exec.php?select=4");
            }
        }
    }
?>