
<?    
    require_once '../classes/membership.php';
    $mysql = new mysql();
    $sem=$_GET['sem'];
    if(strlen($sem) > 0) {
    }
    else { echo "No sem found"; }
    if($sem == "All") {
        $result = $mysql->getAllEvents();
	$num=$mysql->getNumEvents();
    } else {
        $result = $mysql->getEvents($sem);
	$num=$mysql->getNumEventsSem($sem);
    }
    if ($num == 0) {
	echo "<h3>No events right now.</h3>";
    }
    else if (gettype($result)!="boolean") {
        echo "<table style=\"width: 100%\">  
	<thead>  
	<tr> 
	<th>Semester</th>   
	<th>Event</th>  
	<th>Date</th> 
	<th>Count</th>   
	</tr>  
	</thead>
	<tbody>";

	while ($row = mysql_fetch_array($result)) {
	    echo "<tr style=\"color:#AFAFAF;\">";
	    echo "<td>" . $row['semester'] . "</a></td>";
	    echo "<td>" . $row['name'] . "</td>";
	    $datetime = strtotime($row['date']);
	    $mysqldate = date("m/d/y g:i A", $datetime);
	    echo "<td>" . $mysqldate . "</td>";
	    echo "<td>" . $row['event_id'] . "</td>";
	    echo "</tr>";
	}
	echo "</tbody>  
	</table>
	</fieldset>  ";
    } else {
	echo "failed sem lookup";
    }
?>
<html>
<form method="post" action="#" style="height: 285px; width:96.5%;">
                <h4>Add New Event</h4>
		    <div style="padding-right: 30px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Event Name:</b></p>
			<input type="text" name="name" style = "width: 31%; float:left; margin-top: 10px;"/><br><br>
		    </div>
		    <div style="padding-right: 10px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Semester: </b></p>
			<select name="sem" style="width: 32%; margin-left: 20px; float:left; margin-top: 10px;">
			    <option value="Fall 2013" selected>Fall 2013</option>
			    <option value="Spring 2014">Spring 2014</option>
			    <option value="Fall 2014">Fall 2014</option>
			    <option value="Spring 2015">Spring 2015</option>
			</select><br><br>
		    </div>

		    <div style="padding-right: 10px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Event Date:</b></p>
			<input type="datetime-local" name="date" style="float:left; width: 30%; margin-top: 10px; margin-left: 10px;">
                        <br><br>
		    </div>

		    <div style="padding-left: 10px;">
			<p style="font-size:14px; float:left; margin-left: -10px;"><b>Event Details:</b></p>
                        <textarea name=details rows="2" style="width: 65%; float:left; height: 40px; margin-top: 10px; color: #000000; margin-left: -3px;"></textarea>
		    </div>
                    <div style="padding-left: 10px; margin-top: 75px">
                       <input class="button" type="submit" id="submit" value="Add Event" name="submit" />
                    </div>
                    <div id="rightForm"> </div>
                
            </form>
</html>