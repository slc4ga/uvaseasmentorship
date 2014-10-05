<?
    session_start(); // on every page that sessions are used in
    require_once '../../classes/mysql.php';
    $mysql = new Mysql();    
?>

<div class="col-md-11">
    <?

        $result=$mysql->getAppNum();	
        if ($result==0) {
            echo "<h2><center>No new requests right now.</h2>";
        } else {
            echo "
                <form style=\"width: 90%;\" class=\"form-inline\" action=\"../actions/execApprove.php\" method=\"post\"><fieldset>  
                    <table class=\"table table-hover\">  
                        <thead>  
                            <tr>  
                                <th>Name</th>  
                                <th>Year</th>  
                                <th>Major</th> 
                                <th>Region</th>
                                <th>Training</th>
                                <th>Approve?</th>
                            </tr>  
                        </thead>  
                    <tbody> ";
            
            $result=$mysql->getApplicants();
            if (gettype($result) == "boolean") {
                echo "failed<br>";
            } else {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td><a class='inline' href=\"#" . $row['0'] . "\">" . $row['1'] . " " . $row[2] . "</a></td>";
                        echo "<td>" . $row[3] . "</td>";
                        echo "<td>" . $row[6] . "</td>";
                        echo "<td>" . $row[5] . "</td>";
                        echo "<td>" . $row[11] . "</td>";
                        echo "<td>
                                <div class=\"controls\"><input name=\"cb".$row[0]."\"type=\"checkbox\"></label></div></td>";
                    echo "</tr>";
                    
                    // now make hidden box
                    echo "<div style='display:none'>";
                        echo "<div id='" . $row[0] . "' style='padding:10px; background:#fff;'>";
                            echo "<h1>" . $row[1] . " " . $row[2] . "</h1>";
                            echo "<p> Class of " . $row[3] . "<br>";
                            echo $row[4] . " years old<br>";
                            echo $row[6] . "<br>";
                            if(strlen($row[7]) > 0) { 
                                echo $row[7] . "<br>"; 
                            }
                            if(strlen($row[8]) > 0) { 
                                echo $row[8] . " Minor<br>"; 
                            }
                            if(strlen($row[9]) > 0) { 
                                echo $row[9] . " Minor<br>"; 
                            }
                            echo $row[5] . "<br>";
                            echo "Willing to commit " . $row[10] . " hours a week to mentorship</p>";
                            echo "<h4> Previous Mentoring Experience: </h4>
                                    <p>" . $row[12] . "</p>";
                            echo "<h4>Why does " . $row[1] . " " . $row[2] . " want to join Mentorship? </h4>
                                    <p>" . $row[13] . "</p>";
                            echo "<h4>Interests: </h4>
                                    <p>" . $row[14] . "</p>";
                        echo "</div>";
                    echo "</div>";
                }
            }
            echo "
                        </tbody>  
                    </table> 
                    <div class=\"form-actions\">  
                        <button type=\"submit\" style=\"float:right\" class=\"btn btn-lg btn-success\">Approve!</button>  
                    </div>  
                </fieldset>  
            </form>";
        }
    
    ?>
                              
</div>

<script src="../bootstrap/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
           $(".inline").colorbox({inline:true, width:"50%"});
    });
</script>