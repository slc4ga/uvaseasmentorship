<?    
    require_once '../classes/mysql.php';
    $mysql = new Mysql();

    $id=$_GET['mentor_id'];

    $result = $mysql->getPairedInfo($id, "Mentor");

    if (gettype($result)!="boolean") {
        $info = "<b>Name: </b> " . $result['first_name'] . " " . $result['last_name'] . "<br>";
        $info .= "<b>Year: </b> " . $result['year'] . "<br>";
        if (strlen($result['major']) > 0) {
                $info .= "<b>Major: </b> " . $result['major'] . "<br>";
        }
        if (strlen($result['major2']) > 0) {
                $info .= "<b>Major 2: </b> " . $result['major2'] . "<br>";
        }
        if (strlen($result['minor']) > 0) {
                $info .= "<b>Minor: </b> " . $result['minor'] . "<br>";
        }
        if (strlen($result['major2']) > 0) {
                 $info .= "<b>Minor 2: </b> " . $result['minor2'] . "<br>";
        }
        $info .= "<b>Age: </b> " . $result['age'] . "<br>";
        if (strlen($result['bio']) > 0) {
                 $info .= "<b>Bio: </b> " . $result['bio'] . "<br>";
        }
        echo $info;
    } else {
	   echo "failed";
    }
?>