<?
    require_once '../nav/mysql.php';
    session_start(); 

    $mysql = new Mysql();
    $class = $_GET['class'];

    if(!isset($_SESSION['user_id']) || $mysql->getPos($_SESSION['user_id']) != 'W') {
        header("location:../index.php");
    }

    $result = $mysql->getClassMembers($class);
    
    echo "<form method=\"post\" action=\"deleteSister.php\"> <fieldset> 
            <table class=\"table table-hover\">  
            <thead>  
            <tr>  
            <th>Name</th>  
            <th>Year</th>
            <th>Major</th>
            <th>Delete?</th>
            </tr>  
            </thead>  
            <tbody> ";

    if (gettype($result) == "boolean") {
        echo "failed<br>";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td><a href=\"../sisters/sisters.php?select=" . $row[0] . "\">" . $row[1] . " " . $row[2] . "</a></td>";
            echo "<td>" . $row[3] . "</td>";
            echo "<td>" . $row[4] . "</td>";
            echo "<td><div class=\"controls\"><input name=\"cb".$row['0']."\"type=\"checkbox\" 
                            ></div></td>";
            echo "</tr>";
        }
    }
    echo "</tbody>  
    </table>
    <div class=\"form-actions\">  
        <input class=\"btn btn-danger\" id=\"delete\" name=\"delete\" type=\"submit\" 
            style=\"float:right\" value=\"Delete\">
    </div>
    </form>
    </fieldset>";

	
?>