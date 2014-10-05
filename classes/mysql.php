<?php

require_once 'constants.php';
session_start();

class Mysql {
     
    private $mysqli;
    private $conn;
     
     // basically constructor
     function __construct() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) OR DIE ("Unable to 
            connect to database! Please try again later.");
        if (mysqli_connect_errno()) {
            printf("Can't connect to MySQL Server. Error code: %s\n", mysqli_connect_error());
            return null;
        }
    }
    
    // escape sql injections
    function quote_smart($value) {
       if (get_magic_quotes_gpc()) {
           $value = stripslashes($value);
       }
    
       if (!is_numeric($value)) {
           $value = $this->mysqli->real_escape_string($value);
       }
       return $value;
    }
    
    function sendMessage($name, $email, $subject, $message) {
        //$to = 'seas-mentorshipexec@virginia.edu';
        $to = 'slc4ga@virginia.edu';
        $headers = "From: info@uvaseasmentorship.com";
        $headers .= "Reply-to: " . $name . " <" . $email . ">";
        
        $site = "UVa SEAS Mentorship";
        $subject = $site . " - " . $subject;
        
        mail($to, $subject, $message, $headers);
        header("location: ../public/contactSuccess.php");
    }
    
    function addUser($un, $pw, $role, $fname, $lname, $year, $major, $major2, $minor, $minor2, $age, $region, 
                     $time, $training, $reasons, $previous, $interests) {
        $un = $this->quote_smart($un);
        $fname = $this->quote_smart($fname);
        $lname = $this->quote_smart($lname);
        $year = $this->quote_smart($year);
        $major = $this->quote_smart($major);
        $major2 = $this->quote_smart($major2);
        $minor = $this->quote_smart($minor);
        $minor2 = $this->quote_smart($minor2);
        $age = $this->quote_smart($age);
        $region = $this->quote_smart($region);
        $pw = $this->quote_smart($pw);
        $time = $this->quote_smart($time);
        $previous = $this->quote_smart($previous);
        $reasons = $this->quote_smart($reasons);
        $interests = $this->quote_smart($interests);
        $training = $this->quote_smart($training);
        
        // check if username already exists
        $checkUN = "select * from users where username='$un'";
        $result = $this->mysqli->query($checkUN) or die('ERROR: could not validate 
            username');
        $num = $result->num_rows;
        
        $checkapp = "select * from applicants where username='$un'";
        $result1 = $this->mysqli->query($checkapp) or die('ERROR: could not validate 
            username');
        $num1 = $result1->num_rows;
        //echo $num1;
        
        $num = $num + num1;
        
        if($num == 0) {
            if($role != "Pending") {
                //echo $role;
                $md5 = md5($pw);
                $sql = "insert into users values('$un', '$md5', '$role');";
                $result = $this->mysqli->query($sql) or die('mentee add'); 
                
                $sql = "insert into profiles values('$un', '$fname', '$lname', $year, $age, '$region', '$major', '$major2', 
                        '$minor', '$minor2', null, null);";
                $result = $this->mysqli->query($sql) or die('mentee profile add');
                
                $this->login($un, $pw);
                
            } else {   
                $sql = "insert into applicants values('$un', '$fname', '$lname', $year, $age, '$region', '$major', '$major2', 
                        '$minor', '$minor2', '$time', '$training', '$interests', '$reasons', '$previous');";
                $result = $this->mysqli->query($sql) or die('mentor profile add'); 
            }
            
            //send email
            $to = $un . '@virginia.edu';
            $subject = "New UVa SEAS Mentorship Account!";
            $message = "
            <html>
                <head>
                    <title>New UVa SEAS Mentorship Account</title>
                </head>
                <body>
                    <p>Welcome to the UVa SEAS Mentorship website. Most of our business will be conducted through your account here. Your login credentials are as follows:</p>
                    <br>
                    <p>
                        Username: " . $un . "<br>
                        Password: " . $md5 . "<br>
                    </p>
                    <br>
                    <p>
                        Please navigate to <a href=\"http://uvaseasmentorship.com/\">http://uvaseasmentorship.com/</a> to
                        change your password and edit and view your profile as soon as possible.
                    </p>
                </body>
            </html>";       
        
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From: " . WEBMASTER_EMAIL;        
            mail($to, $subject, $message, $headers);

                       
            $headers = "From: info@uvaseasmentorship.com";
            $to = "seas-mentorshipwebmaster@virginia.edu";
            $role = strtolower($role);
            $subject = "New $role!";
            $message = "A new $role has signed up at uvaseasmentorship.com! Make sure you go update the listserv.";
            mail($to, $subject, $message, $headers);
            
            return 'success';
            
        }
        //header("location: application.php?select=1&error=un");
        return 'userexists';
    }
    
    function login($un, $pw) {
        $un = $this->quote_smart($un);
        $pw = $this->quote_smart($pw);
        $md5 = md5($pw);
        $sql = "SELECT * FROM users WHERE username = '$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $sql = "SELECT * FROM users WHERE username = '$un' AND password = '$md5'";
            $result = $this->mysqli->query($sql) or die("password");
            $num = $result->num_rows;
            if($num == 1) {
                $_SESSION['role'] = $this->getRole($un);
                $_SESSION['user_id'] = $un;
                return "";
            }
            else return "password";
        }
        return "username";
    }
    
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    function getPass($un) {
        // escape sql injections
        $un = $this->quote_smart($un, $db_handle);
        
        $sql = "SELECT password FROM users WHERE username = '$un'";
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $pw = $this->randomPassword();
            $md5 = md5($pw);
            $sql = "update users set password='$md5' where username = '$un'";
            $result = $this->mysqli->query($sql) or die("password set");
            $to = $un . "@virginia.edu";
            $headers = 'From: ' . "\r\n" . "info@uvaseasmentorship.com";
            $headers .= 'Reply-To: ';
            $subject = "Password Retrieval";
            $message = "You have requested your password from the UVa SEAS Mentorship website. Your password has been reset, and your 
                    new login information is as follows: \n\nUsername: " . $un . "\nPassword: " . $pw;
            mail($to, $subject, $message, $headers);
            header("location: ../public/passResult.php?status=1");
            return "1";
        }
        header("location: ../public/passResult.php?status=0");
        return "0";
    }
    
    function resetPass($old, $new) {
        $old = $this->quote_smart($old);
        $new = $this->quote_smart($new);
        
        $md5old = md5($old);
        $md5new = md5($new);
        $un = $_SESSION['user_id'];
        $sql = "select * from users where password='$md5old' and username='$un'";
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("username");
        $num = $result->num_rows;
        if ($num == 1) {
            $sql = "update users set password='$md5new' where password='$md5old' and username='$un'";
            $result = $this->mysqli->query($sql) or die("username");
            return "success";
        } else {
            return "old";
        }
    }
    
    
    function getRole($un) {
        $sql = "select role from users where username='$un'";
        $result = $this->mysqli->query($sql) or die("get role");
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
        
    function addExperience($un, $exp, $status) {
        if($status != "Pending") {
            $sql = "insert into experiences values('$un', '$exp')";
            $result = $this->mysqli->query($sql) or die("add experience");
            return $result;
        } else {
            $sql = "insert into appexp values('$un', '$exp')";
            //echo $sql;
            $result = $this->mysqli->query($sql) or die("add pending experience");
            return $result;
        }
    }
    
    function getFullName($un) {
        $sql = "select first_name,last_name from profiles where username='$un'";
        $result = $this->mysqli->query($sql) or die("get first name");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0] . " " . $row[1];
    }
        
    function getMajor($un) {
        $sql = "select major from profiles where username='$un'";
        $result = $this->mysqli->query($sql) or die("get first name");  
        $row = $result->fetch_array(MYSQLI_NUM);
        if($row[0] != "Engineering Science") {
            return str_replace("Engineering", "", $row[0]);
        } else 
            return $row[0];
    }
    
    function checkWebmaster($un) {
        $sql = "select * from leadership where username='$un' and position='W'";
        $result = $this->mysqli->query($sql) or die("check webmaster");  
        $row = $result->fetch_array(MYSQLI_NUM);
        if($result->num_rows == 1) {
            return true;
        }
        return false;
    }
    
    function checkRole($un) {
        $sql = "select role from users where username='$un'";
        $result = $this->mysqli->query($sql) or die("check role");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
    function getNumAnnouncements() {
        $sql = "select * from announcements";
        $result = $this->mysqli->query($sql) or die("num announcemens");
        $num = $result->num_rows;
        return $num;
    }
    
    function getAnnouncements($num, $to) {
        $sql = "select * from announcements where post_to like '%$to%' or post_to like '%seas_mentorship%' order by date desc limit $num";
        if($to == "Exec") {
            $sql = "select * from announcements order by date desc limit $num";
        }
        $result = $this->mysqli->query($sql) or die("announcemens");
        return $result;
    }
    
    function checkExec($un) {
        $sql = "select * from leadership where username='$un'";
        $result = $this->mysqli->query($sql) or die("check exec");  
        $row = $result->fetch_array(MYSQLI_NUM);
        if($result->num_rows == 1) {
            return true;
        }
        return false;
    }
    
    function getInfo($un) {
        $sql = "select * from profiles where username='$un'";
        $result = $this->mysqli->query($sql) or die("user info"); 
        return $result;
    }
    
    function getLeadership($id) {
        $sql = "SELECT posList.position FROM leadership LEFT JOIN posList ON posList.id = leadership.position 
            WHERE leadership.username = '$id'"; 
        $result = $this->mysqli->query($sql) or die("leadership lookup");  
        $row = $result->fetch_array(MYSQLI_NUM);
        return $row[0]; 
    }
    
    function updateProfile($year, $age, $region, $major, $major2, $minor, $minor2, $activities, $bio) {
        $activities = $this->quote_smart($activities);
        $bio = $this->quote_smart($bio);
        $id = $_SESSION['user_id'];
        $sql = "update profiles set year=$year, age='$age', region='$region', major='$major', major2='$major2', 
            minor='$minor', minor2='$minor2', activities='$activities', bio='$bio' where username='$id'";
        $result = $this->mysqli->query($sql) or die("update profile");  
        return true;
    }
    
    function getNumExperiences($un) {
        $sql = "select * from experiences where username = '$un'";
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("num experiences");
        $num = $result->num_rows;
        return $num;
    }
    
    function getExperiences($un) {
        $sql = "select * from experiences where username = '$un'";
        $result = $this->mysqli->query($sql) or die("num experiences");
        return $result;
    }
    
    function getNumMentees($mentorUN) {     
        $sql = "select count(*) from pairs where mentor_un='$mentorUN'";
        $result = $this->mysqli->query($sql) or die("mentee un");
        $row = $result->fetch_array(MYSQLI_NUM);
        $mentee_un = $row[0];
        return $mentee_un;
    }
    
    function getMyMentees($mentorUN) {     
        $sql = "select mentee_un from pairs where mentor_un='$mentorUN'";
        $result = $this->mysqli->query($sql) or die("mentee un");
        return $result;
    }

    function getMyMentor($menteeUN) {
        $sql = "select mentor_un from pairs where mentee_un='$menteeUN'";
        $result = $this->mysqli->query($sql) or die("mentor un");
        $row = $result->fetch_array(MYSQLI_NUM);
        $mentor_un = $row[0];
        return $mentor_un;
    }
    
    function saveLog($mentee, $activity, $concerns, $academic, $summary) {
        $un = $_SESSION['user_id'];
        $sql = "insert into mentor_log values (NOW(), '$un', '$mentee', '$activity', '$concerns', '$academic', '$summary');";
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("save log");
    }
    
    function removeExperiences($un) {
        $sql = "delete from experiences where username='$un'";
        $result = $this->mysqli->query($sql) or die("remove exp");
        return $result;
    }
    
    function addAnnouncement($sub, $email, $text) {
        date_default_timezone_set('America/New_York');
        $datetime = date_create()->format('Y-m-d H:i:s');
        $un = $_SESSION['user_id'];
        $sql = "insert into announcements values('$datetime', '$un', '$email', '$sub', '$text')";
        //echo $sql;
        $result = $this->mysqli->query($sql) or die("add announcement");
        
        $headers="From: seas-mentorshipExec@virginia.edu";
        $fixed = str_replace("<br>", "\n", $text);
        
        if (get_magic_quotes_gpc()) {
            $fixed = stripslashes($fixed);
        } 

        //mail($email, $sub, $fixed, $headers);
        return $sql;  
    }
    
    function getAppNum() {
        $sql = "select * from applicants";
        $result = $this->mysqli->query($sql) or die("app num");
        $num = $result->num_rows;    
        return $num;
    }
    
    function getApplicants() {
        $sql = "select * from applicants";
        $result = $this->mysqli->query($sql) or die("app info");
        return $result;
    }
    
    function getRow($un) {
        $sql = "select * from applicants where username='$un'";
        $result = $this->mysqli->query($sql) or die("approve transfer");
        return $result;
    }
    
    function transferExperiences($un) {
        $sql = "select * from appexp where username = '$un'";
        $result = $this->mysqli->query($sql) or die("transfer exp");
        
        while ($row = mysqli_fetch_array($result)) {
            $sql = "insert into experiences values ('$un', '$row[1]')";
            $result1 = $this->mysqli->query($sql) or die("insert transfer exp");
        }
        
        $sql = "delete from appexp where username = '$un'";
        $result = $this->mysqli->query($sql) or die("delete transfer exp");
        
        return $result;     
    }
    
    function deleteApplicant($un) {
        $sql = "delete from applicants where username='$un';";
        $result = $this->mysqli->query($sql) or die("delete applicant");
        return $result;
    }

    function getPairNum() {
        $sql = "select * from pairs";
        $result = $this->mysqli->query($sql) or die("num pairs");
        $num = $result->num_rows;
        return $num;
    }
    
    function getPairs() {
        $sql = "select * from pairs order by mentor_un";
        $result = $this->mysqli->query($sql) or die("get pairs");
        return $result;
    }
    
    function deletePair($mentor_un, $mentee_un) {
        $sql = "delete from pairs where mentor_un='$mentor_un' and mentee_un='$mentee_un'";
        $result = $this->mysqli->query($sql) or die("delete pairs");
        return $result;
    }
    
    function undoPair($menteeUN) {
        $sql = "delete from pairs where mentee_un='$menteeUN'";
        echo $sql;
        $result = $this->mysqli->query($sql) or die("undo pairs");
        return $result;
    }
    
    function getMenteeNum() {
        $sql = "select * from users where role='Mentee'";
        $result = $this->mysqli->query($sql) or die("num mentees");
        $num = $result->num_rows;
        return $num;
    }
    
    function getMentors() {
        $sql = "SELECT * FROM users left join profiles on users.username = profiles.username where users.role='Mentor'";
        $result = $this->mysqli->query($sql) or die("get mentors");
        return $result;
    }
    
    function getMentees() {
        $sql = "SELECT * FROM users left join profiles on users.username = profiles.username where users.role='Mentee'";
        $result = $this->mysqli->query($sql) or die("get mentees");
        return $result;
    }
    
    function checkMenteePaired($un) {
        $sql = "select * from pairs where mentee_un = '$un'";
        $result = $this->mysqli->query($sql) or die("check paired");
        $num = $result->num_rows;
        if ($num == 0) {
            return false;
        }
        return true;
    }
    
    function getPairedInfo($un, $role) {
        $sql = "select * from users left join profiles on users.username = profiles.username where users.username='$un' 
                and users.role='$role'";
        $result = $this->mysqli->query($sql) or die("get user info for paired");
        $row = mysqli_fetch_array($result);
        return $row;
    }
    
    function addPair($mentorUID,$menteeUID,$comments) {
        $sql = "insert into pairs values('$mentorUID', '$menteeUID','" . $this->quote_smart($comments) . "');";
        $result = $this->mysqli->query($sql) or die("add pair");
        
        $to = $mentorUID . '@virginia.edu';
        $subject = 'SEAS Mentorship: You\'ve been matched!';
        $message = 'Your mentee for the next semester is:  ' . $this->getFullName($menteeUID) . "\nThey can be reached at: \t " . $menteeUID . "@virginia.edu. \n\nPlease contact them within the next three days, and let Exec know if you haven't heard back from them in a timely manner. \n\nThanks for volunteering to be a mentor!";
        $from = 'From: info@uvaseasmentorship.com';
        mail($to, $subject, $message, $from);       
        
        $to = $menteeUID . '@virginia.edu';
        $message = 'Your mentor for the next semester is:  ' . $this->getFullName($mentorUID) . "\nThey can be reached at: \t " . $mentorUID . "@virginia.edu. \n\nThey should be contacting you within the next three days. Please let Exec know if you don't hear from your mentor in a timely manner! \n\nThanks for signing up for the program!";
        mail($to, $subject, $message, $from);
    }
    
    function getLogDate() {
        $un = $_SESSION['user_id'];
        $sql = "select * from mentor_log where mentor_un = '$un' order by date_time desc";
        $result = $this->mysqli->query($sql) or die("get most recent date");
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

// END EDITS 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

function verify_Username_and_PW($un, $pw) { 

  $query = "SELECT * FROM users WHERE username = '$un' AND password = '$pw'";
  $result = mysql_query($query) or die(mysql_error());
  $num = mysql_numrows($result);
  if ($num == 1) {
    return true;
  }

}

function getAttendanceCount($event) {
  $query = "select * from attendance where event1='$event';";
  $result = mysql_query($query) or die(mysql_error());
  $num = mysql_numrows($result);
  return $num;
}

function getAllEvents() {
  $query = "select * from events order by semester";
  $result = mysql_query($query) or die(mysql_error());
  return $result;
}


function getEvents($sem) {
  $query = "select * from events where semester='$sem'";
  $result = mysql_query($query) or die(mysql_error());
  return $result;
}

function recordAttendance($un, $event) {
  $query = "select user_id from users where username='$un';";
  $result = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($result);
  $query1 = "insert into attendance values(null, $row[0], '$event');";
  $result1 = mysql_query($query1) or die(mysql_error());
  return $result;
} 

function setPass($un, $pass) {
  $query = "update users set password='$pass' where username='$un';";
  $result = mysql_query($query) or die(mysql_error());
  return $result;
}

function getPass2($un) {
  $query = "select password from users where username='$un';";
  $result = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($result);
  return $row[0];
}

function checkUser($un) {
  $query = "select * from users where username = '$un'";
  $result = mysql_query($query) or die(mysql_error());
  $num = mysql_numrows($result);
  if ($num == 0) {
   return false;
 }
 return true;
}

function checkMentorPaired($user_id) {
  $query = "select * from pairs where mentor_id = $user_id";
  $result = mysql_query($query) or die(mysql_error());
  $num = mysql_numrows($result);
  if ($num == 0) {
   return false;
 }
 return true;
}




function getExecFromNum($uNum) {
  $query = "select concat(first_name,' ',last_name) as full_name from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecPhotoName($uNum) {
  $query = "select concat(first_name,last_name,'.jpg') as pic_path from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecMajor1($uNum) {
  $query = "select major1 from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  if($row[0] == 'MECH') { return "Mechanical Engineering"; }
  if($row[0] == 'CS') { return "Computer Science"; }
  if($row[0] == 'CPE') { return "Computer Engineering"; }
  if($row[0] == 'AERO') { return "Aerospace Engineering"; }
  if($row[0] == 'BIOMED') { return "Biomedical Engineering"; }
  if($row[0] == 'CHEME') { return "Chemical Engineering"; }
  if($row[0] == 'ESCI') { return "Engineering Science"; }
  if($row[0] == 'EE') { return "Electrical Engineering"; }
  if($row[0] == 'CIVIL') { return "Civil Engineering"; }
  if($row[0] == 'SYS') { return "Systems Engineering"; }
}

function getExecMajor2($uNum) {
  $query = "select major2 from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecMinor1($uNum) {
  $query = "select minor1 from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecMinor2($uNum) {
  $query = "select minor2 from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecYear($uNum) {
  $query = "select year from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecAge($uNum) {
  $query = "select age from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecRegion($uNum) {
  $query = "select region from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecPos($uNum) {
  $query = "select position from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecPersonal($uNum) {
  $query = "select personal from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecFirstName($uNum) {
  $query = "select first_name from exec where user_id=$uNum";

  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecLastName($uNum) {
  $query = "select last_name from exec where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getExecExp($uNum) {
  $array = array("ex_id", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","u_id");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=0; $i < 28; $i++) {
    if($row[$i] == "X") {
     $toReturn = $toReturn . "<br>" . $array[$i];
   }
 }
 return $toReturn;
}

function getExecExpArray($uNum) {
  $array = array();
  $cols = array("x", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","x");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=1; $i < 27; $i++) {
    if($row[$i] == "X") {
     $array[] = $cols[$i];
   }
 }
 return $array;
}

function getUserID($un) {
  $uidLookup = "select user_id from users where username='$un'";
  $uid = mysql_query($uidLookup) or die(mysql_error());

  $row = mysql_fetch_row($uid);

  return $row[0];
}

function getUN($uID) {
  $query = "select username from users where user_id=$uID";
  $name = $mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($name);
  return $row[0];
}

function addNewUser($un, $pw, $role) {
  $sql = "insert into users values (null, '$un','$pw', '$role')";
  mysql_query($sql) or die(mysql_error());
}

function checkRows($un) {
  $SQL = "select * from users where username='$un'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}

function checkExecRows($name1) {
  $SQL = "select * from exec where username='$name1'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}

function checkMentorRows($un) {
  $SQL = "select * from mentors where username='$un'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}

function checkMenteeRows($un) {
  $SQL = "select * from mentees where username='$un'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}

function checkApplicantRows($un) {
  $SQL = "select * from applicants where username='$un'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}


function addNewApplicant($name1, $name2, $un, $grad, $previous, $age, $major1, $region, $top10, $time, $reason, $major2, $minor1, $minor2, $experience, $training) {
 $name = $name1 . " " . $name2;
 $sql = "insert into applicants values (null, '$name', '$un', $grad, '$previous', $age, '$major1', '$region', '$top10', '$time', '$reason', '$major2', '$minor1', '$minor2', '$experience', '$training', null)";
 mysql_query($sql) or die(mysql_error());

}

function addNewExec($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region, $pos) {
  $uidLookup = "select user_id from users where username='$un'";
  $uid = mysql_query($uidLookup) or die(mysql_error());
  $num = mysql_numrows($uid);

  $row = mysql_fetch_row($uid);
  if($num == 1) {
   $sql = "insert into exec values (null, $row[0], '$name1', '$name2', '$un', $grad, '$major1', '$major2', '$minor1', '$minor2', $age, '$region', '$pos', null)";
   $result = mysql_query($sql) or die(mysql_error());
 }
}

function addNewMentor($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region) {
  $uidLookup = "select user_id from users where username='$un'";
  $uid = mysql_query($uidLookup) or die(mysql_error());
  $num = mysql_numrows($uid);

  $row = mysql_fetch_row($uid);
  if($num == 1) {
   $sql = "insert into mentors values (null, $row[0], '$un', '$name1', '$name2', $grad, '$major1', '$major2',
     '$minor1', '$minor2', $age, '$region', null)";
mysql_query($sql) or die(mysql_error());
}
}

function addNewMentee($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region) {
  $uidLookup = "select user_id from users where username='$un'";
  $uid = mysql_query($uidLookup) or die(mysql_error());
  $num = mysql_numrows($uid);

  $row = mysql_fetch_row($uid);
  if($num == 1) {
   $sql = "insert into mentees values (null, $row[0], '$un', '$name1', '$name2', $grad, '$major1', '$major2',
     '$minor1', '$minor2', $age, '$region', null)";
mysql_query($sql) or die(mysql_error());
}
}

function checkExperienceRow($uID) {
  $SQL = "select * from experiences where user_id='$uID'";
  $result = mysql_query($SQL) or die(mysql_error());
  $num = mysql_numrows($result);

  return $num;
}

function addNewExperience($overwhelmed, $fail_test, $anxiety, $over_committed, $fail_class, $homesick, $family, 
  $isolated, $roommate, $depression, $death, $relationships, $caps, $no_alcohol, $extreme_alcohol, $eating_disorder, 
  $suicide, $disability, $drugs, $homeschool, $money, $greek, $transfer, $international, $academic_probation, $military, 
  $uID) {
 $sql = "insert into experiences values (null, '$overwhelmed', '$fail_test', '$anxiety', '$over_committed', '$fail_class', '$homesick', '$family', '$isolated', '$roommate', '$depression', '$death', '$relationships', '$caps', '$no_alcohol', '$extreme_alcohol', '$eating_disorder', '$suicide', '$disability', '$drugs', '$homeschool', '$money', '$greek', '$transfer', '$international', '$academic_probation', '$military', $uID)";
 mysql_query($sql) or die(mysql_error());
}

function updateExperience($overwhelmed, $fail_test, $anxiety, $over_committed, $fail_class, $homesick, $family,
 $isolated, $roommate, $depression, $death, $relationships, $caps, $no_alcohol, $extreme_alcohol, $eating_disorder, 
 $suicide, $disability, $drugs, $homeschool, $money, $greek, $transfer, $international, $academic_probation, $military, 
 $uID) {
  $sql = "update experiences set overwhelmed='$overwhelmed', fail_test='$fail_test', anxiety='$anxiety', 
  over_committed='$over_committed', fail_class='$fail_class', homesick='$homesick', family='$family', isolated='$isolated',
  roommate='$roommate', depression='$depression', death='$death', relationships='$relationships', caps='$caps', 
  no_alcohol='$no_alcohol', extreme_alcohol='$extreme_alcohol', eating_disorder='$eating_disorder', suicide='$suicide', 
  disability='$disability', drugs='$drugs', homeschool='$homeschool', money='$money', greek='$greek', transfer='$transfer', 
  international='$international', academic_probation='$academic_probation', military='$military' where user_id=$uID";

  mysql_query($sql) or die(mysql_error());
}

function updateExecUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID) {
  $sql = "update exec set major1='$major1', major2='$major2', minor1='$minor1', minor2='$minor2', year=$year, region='$region', personal='$personal' where user_id=$uID";
  $result = mysql_query($sql) or die(mysql_error());
  header("location: profile.php");

}

function addEvent($name, $details, $date, $sem) {
  $sql = "insert into events values(null, '$name', '$details', '$date', '$sem')";
  $result = mysql_query($sql) or die(mysql_error());
  return $result;
}

function getNumEvents() {
  $sql = "select * from events";
  $result = mysql_query($sql) or die(mysql_error());
  $num = mysql_numrows($result);
  return $num;
}

function getNumEventsSem($sem) {
  $sql = "select * from events where semester='$sem'";
  $result = mysql_query($sql) or die(mysql_error());
  $num = mysql_numrows($result);
  return $num;
}

function getMentorFromNum($uNum) {
  $query = "select concat(first_name,' ',last_name) as full_name from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorPhotoName($uNum) {
  $query = "select concat(first_name,last_name,'.jpg') as pic_path from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorMajor1($uNum) {
  $query = "select major1 from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  if($row[0] == 'MECH') { return "Mechanical Engineering"; }
  if($row[0] == 'CS') { return "Computer Science"; }
  if($row[0] == 'CPE') { return "Computer Engineering"; }
  if($row[0] == 'AERO') { return "Aerospace Engineering"; }
  if($row[0] == 'BIOMED') { return "Biomedical Engineering"; }
  if($row[0] == 'CHEME') { return "Chemical Engineering"; }
  if($row[0] == 'ESCI') { return "Engineering Science"; }
  if($row[0] == 'EE') { return "Electrical Engineering"; }
  if($row[0] == 'CIVIL') { return "Civil Engineering"; }
  if($row[0] == 'SYS') { return "Systems Engineering"; }

}

function getMentorMajor2($uNum) {
  $query = "select major2 from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorMinor1($uNum) {
  $query = "select minor1 from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorMinor2($uNum) {
  $query = "select minor2 from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorYear($uNum) {
  $query = "select year from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorAge($uNum) {
  $query = "select age from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorRegion($uNum) {
  $query = "select region from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorPos($uNum) {
  $query = "select position from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorPersonal($uNum) {
  $query = "select personal from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorFirstName($uNum) {
  $query = "select first_name from mentors where user_id=$uNum";

  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorLastName($uNum) {
  $query = "select last_name from mentors where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMentorExp($uNum) {
  $array = array("ex_id", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","u_id");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=0; $i < 28; $i++) {
    if($row[$i] == "X") {
     $toReturn = $toReturn . "<br>" . $array[$i];
   }
 }
 return $toReturn;
}

function getMentorExpArray($uNum) {
  $array = array();
  $cols = array("x", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","x");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=1; $i < 27; $i++) {
    if($row[$i] == "X") {
     $array[] = $cols[$i];
   }
 }
 return $array;
}


function updateMentorUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID) {
  $sql = "update mentors set major1='$major1', major2='$major2', minor1='$minor1', minor2='$minor2', year=$year, region='$region', personal='$personal' where user_id=$uID";
  $result = mysql_query($sql) or die(mysql_error());
  header("location: profile.php");
}

function getMenteeFromNum($uNum) {
  $query = "select concat(first_name,' ',last_name) as full_name from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteePhotoName($uNum) {
  $query = "select concat(first_name,last_name,'.jpg') as pic_path from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeMajor1($uNum) {
  $query = "select major1 from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  if($row[0] == 'MECH') { return "Mechanical Engineering"; }
  if($row[0] == 'CS') { return "Computer Science"; }
  if($row[0] == 'CPE') { return "Computer Engineering"; }
  if($row[0] == 'AERO') { return "Aerospace Engineering"; }
  if($row[0] == 'BIOMED') { return "Biomedical Engineering"; }
  if($row[0] == 'CHEME') { return "Chemical Engineering"; }
  if($row[0] == 'ESCI') { return "Engineering Science"; }
  if($row[0] == 'EE') { return "Electrical Engineering"; }
  if($row[0] == 'CIVIL') { return "Civil Engineering"; }
  if($row[0] == 'SYS') { return "Systems Engineering"; }

}

function getMenteeMajor2($uNum) {
  $query = "select major2 from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeMinor1($uNum) {
  $query = "select minor1 from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeMinor2($uNum) {
  $query = "select minor2 from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeYear($uNum) {
  $query = "select year from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeAge($uNum) {
  $query = "select age from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeRegion($uNum) {
  $query = "select region from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteePos($uNum) {
  $query = "select position from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteePersonal($uNum) {
  $query = "select personal from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeFirstName($uNum) {
  $query = "select first_name from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeLastName($uNum) {
  $query = "select last_name from mentees where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  return $row[0];
}

function getMenteeExp($uNum) {
  $array = array("ex_id", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","u_id");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=0; $i < 28; $i++) {
    if($row[$i] == "X") {
     $toReturn = $toReturn . "<br>" . $array[$i];
   }
 }
 return $toReturn;
}

function getMenteeExpArray($uNum) {
  $array = array();
  $cols = array("x", "Overwhelmed","Failed a test","Anxiety","Overcommitment","Failed a class","Homesickness","Family issues","Isolation","Roommate problems","Depression","Death","Relationships","CAPS","Alcohol-free activities","Extreme alcohol use","Eating Disorder", "Suicide","Disability","Drug abuse","Homeschooled","Financial problems","Greek Life","Transfer student","International student","Academic Probation","Military","x");
  $query = "select * from experiences where user_id=$uNum";
  $un = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_row($un);
  $toReturn="";
  for($i=1; $i < 27; $i++) {
    if($row[$i] == "X") {
     $array[] = $cols[$i];
   }
 }
 return $array;
}


function updateMenteeUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID) {
  $sql = "update mentees set major1='$major1', major2='$major2', minor1='$minor1', minor2='$minor2', year=$year, region='$region', personal='$personal' where user_id=$uID";
  $result = mysql_query($sql) or die(mysql_error());
  header("location: profile.php");
}

function getCar($un) {
  $query = "select people from cars where username='$un'";
  $people = mysql_query($query) or die(mysql_error());
  $num = mysql_numrows($people);
  if($num == 0) {  return "2"; }
  else {
      $row = mysql_fetch_row($people);
      return $row[0];
  }
}



function changeUser($un, $role) {
  $sql = "update users set role='$role' where username='$un'";
  $people = mysql_query($sql) or die(mysql_error());
}

}