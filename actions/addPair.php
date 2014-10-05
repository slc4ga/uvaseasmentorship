<?   
    session_start(); // on every page that sessions are used in
    require_once '../classes/mysql.php';
    $mysql = new Mysql();

    //check POST data, pair mentors if they exist
    if($_POST && !empty($_POST['mentors']) && !empty($_POST['mentees'])) {
        $mentor_id = $_POST['mentors'];
        $mentee_id = $_POST['mentees'];
        $_SESSION["mentee_id"] = $mentee_id;
        $_SESSION["mentor_id"] = $mentor_id;
        $comments = $_POST['comments'];
        $pair_id = $mysql->addPair($mentor_id, $mentee_id, $comments);
        $_SESSION["paired"] = 1;
        header("location: ../users/exec.php?select=3");
    }
?>