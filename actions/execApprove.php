<?
    session_start(); // on every page that sessions are used in
    require_once '../classes/mysql.php';
    $mysql = new Mysql(); 

    $cbnames=array_keys($_POST);
    if(count($cbnames) != 0) {
        $id_numbers=array();
        foreach($cbnames as &$val) {
            $str = $val;
            if (isset($_POST[$str])) {
                // add user first
                $str = substr($str, 2);
                $row = $mysql->getRow($str)->fetch_array(MYSQLI_NUM);
                $pw = substr(md5(rand()), 0, 8);
                $mysql->addUser($row[0], $pw, 'Mentor', $row[1], $row[2], $row[3], $row[6], $row[7], $row[8], $row[9], $row[4], 
                                $row[5], null, null, null, null, null);
                $mysql->transferExperiences($row[0]);
                $to = $row[0] . '@virginia.edu';
                $subject = 'SEAS Mentorship Approval';
                $message = "Congratulations! \n\nYou've been accepted as a mentor in the SEAS Mentorship program. An account has been made for you on the website with the following credentials: \n\nUsername: " . $row[0] . "\nPassword: " . $pw . "\n\nPlease log on and complete your user profile as soon as possible. In addition to holding your user information, all announcements will be sent out and attendance at events will be taken through the website, and you will be able to submit your bi-weekly mentor logs. \n\nAs a newly accepted mentor, you are now eligible to be matched with mentees, and we will send you another email with your mentee's name and email as soon as you are matched. \n\nPlease do not hesitate to contact the exec board with any questions at seas-mentorshipexec@virginia.edu. \n\nFind any website issues? Contact our webmaster at seasmentorship-webmaster@virginia.edu";
                $from = 'From: info@uvaseasmentorship.com';
                mail($to, $subject, $message, $from);
                
                
                $headers = "From: info@uvaseasmentorship.com";
                $to = "seas-mentorshipwebmaster@virginia.edu";
                $subject = "New mentor!";
                $message = "A new mentor has been approved at uvaseasmentorship.com! Make sure you go update the appropriate listserv.";
                mail($to, $subject, $message, $headers);
                $mysql->deleteApplicant($row[0]);
                
                header("location: ../users/exec.php?select=4");
            }
        }
    }
?>