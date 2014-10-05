<html>
<body>
<form method="post" action="#" style="height: 300px; width:100%;">
                

                <div id="formRow">
                <h4>Add New Event</h4>
		    <div style="padding-right: 30px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Event Name:</b></p>
			<input type="text" name="name" style = "width: 30%; float:left; margin-top: 10px;"/><br><br>
		    </div>
		    <div style="padding-right: 10px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Semester: </b></p>
			<select name="sem" style="width: 40%; margin-left: 20px; float:left; margin-top: 10px;">
			    <option value="Fall 2013" selected>Fall 2013</option>
			    <option value="Spring 2014">Spring 2014</option>
			    <option value="Fall 2014">Fall 2014</option>
			    <option value="Spring 2015">Spring 2015</option>
			</select><br><br>
		    </div>

		    <div style="padding-right: 10px;">
			<p style="padding-right: 20px; float:left; font-size:14px;"><b>Event Date:</b></p>
			<input type="datetime-local" name="date" style="float:left; margin-top: 10px; margin-left: 10px;">
                        <br><br>
		    </div>

		    <div style="padding-left: 10px;">
			<p style="font-size:14px; float:left; margin-left: -10px;"><b>Event Details:</b></p>
                        <textarea name=details rows="2" style="width: 65%; float:left; height: 40px; margin-top: 10px; color: #000000; margin-left: -3px;"></textarea>
		    </div>
		</div>

                <div id="formRow">
                    <div id="leftForm">
                       <input class="button" type="submit" id="submit" value="Create" name="submit" />
                    </div>
                    <div id="rightForm"> </div>
                </div>
                
            </form>
</body>
</html>