<?

    session_start(); // on every page that sessions are used in
    require_once '../../classes/mysql.php';
    $mysql = new Mysql();

?>

<div class="col-md-11">
    <?
        $result = $mysql->getPairNum();	
        if ($result==0) {
            echo "<h2><center>No pairings exist right now.</h2>";
        } else {
            echo "
                <form style=\"width: 100%;\" class=\"form-inline\" action=\"../actions/deletePair.php\" method=\"post\">  
                <table class=\"table table-hover\">  
                    <thead>  
                        <tr>  
                            <th>Mentor Name</th>  
                            <th>Mentor Major</th>  
                            <th>Mentee Name</th>
                            <th>Mentee Major</th>
                            <th>Delete?</th>
                        </tr>  
                    </thead>  
                <tbody> ";
        
        $result = $mysql->getPairs();
        if (gettype($result) == "boolean") {
            echo "failed<br>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $mysql->getFullName($row[0]) . "</td>";
                echo "<td>" . $mysql->getMajor($row[0]) . "</td>";
                echo "<td>" . $mysql->getFullName($row[1]) . "</td>";
                echo "<td>" . $mysql->getMajor($row[0]) . "</td>";
                echo "<td>
                        <div class=\"controls\">
                            <input name=\"cb" . $row[0] . ":" . $row[1] . "\"type=\"checkbox\">
                        </div>
                    </td>";
                echo "</tr>";
        
            }
        }
        echo "
                </tbody>  
            </table> 
            <div class=\"form-actions\">  
                <button type=\"submit\" style=\"float:right\" class=\"btn btn-lg btn-danger\">Delete Pair!</button>  
            </div>  
        </fieldset></form>";
        }
    ?>
</div>					  	