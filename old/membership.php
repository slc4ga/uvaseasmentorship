<?php

require 'mysql.php';

class Membership {
    
    function validate_user($un, $pw) {
        $mysql = New Mysql();
        
        // to hash password:
        // md5($pw);
        
        $ensure_credentials = $mysql->verify_Username_and_PW($un, $pw);
        
        if($ensure_credentials) {
            $role = $mysql->getUserRole($un);
            setcookie("role", $row[0], time()+3600);
            setcookie("user", $un, time()+3600);
            $_SESSION['status'] = 'authorized';
            $_SESSION['type'] = '$role';
            if($role == 'EXEC') {
                header( "location:../exec/execIndex.php");
                $_SESSION['role']=1;
            }
            else if($role == 'MENTOR') {
                header( "location:../mentors/mentorIndex.php");
                $_SESSION['role']=2;
            }
            else if($role == 'MENTEE') {
                header("location:../mentees/menteeIndex.php");
                $_SESSION['role']=3;
            }
            $_SESSION['username']=$un;
        }
        
    }

    function getApplicantNum() {
        $mysql = New Mysql();
        return $mysql->getAppNum();
    }

    function getPairNum() {
        $mysql = New Mysql();
        return $mysql->getPairNum();
    }

    function getCar($un) {
        $mysql = New Mysql();
        return $mysql->getCar($un);
    }

    function addEvent($name, $details, $date, $sem) {
        $mysql = New Mysql();
        return $mysql->addEvent($name, $details, $date, $sem);
    }

    function deleteApplicant($un) {
        $mysql = New Mysql();
        $mysql->deleteApp($un);
    }

    function deletePair($id) {
        $mysql = New Mysql();
        $mysql->deletePair($id);
    }

    function getAllEvents() {
        $mysql = New Mysql();
        return $mysql->getAllEvents();
    }

    function addExperience($un, $list) {
        $mysql = New Mysql();
        return $mysql->addExperience($un, $list);
    }

    function getAttendanceCount($event) {
        $mysql = New Mysql();
        return $mysql->getAttendanceCount($event);
    }

    function recordAttendance($un, $event) { 
        $mysql = New Mysql();
        return $mysql->recordAttendance($un, $event);
    }

    function setPass($un, $pass) {
        $mysql = New Mysql();
        $mysql->setPass($un, $pass);
    }

    function getPass($un) {
        $mysql = New Mysql();
        return $mysql->getPass($un);
    }

    function getApplicants() {
        $mysql = New Mysql();
        return $mysql->getApplicants();
    }

    function getPairs() {
        $mysql = New Mysql();
        return $mysql->getPairs();
    }

    function getMenteeNum() {
        $mysql = New Mysql();
        return $mysql->getMenteeNum();
    }

    function getMentees() {
        $mysql = New Mysql();
        return $mysql->getMentees();
    }

    function getMentors() {
        $mysql = New Mysql();
        return $mysql->getMentors();
    }

    function toProfile() { 
        header("location:../exec/profile.php");
    }

    function sign_in($un, $pw) {
        $mysql = New Mysql();
        $role = $mysql->getUserRole($un);
            $_SESSION['status'] = 'authorized';
            $_SESSION['type'] = '$role';
            if($role == 'EXEC') {
                $_SESSION['role']=1;
            }
            else if($role == 'MENTOR') {
                $_SESSION['role']=2;
            }
            else if($role == 'MENTEE') {
                $_SESSION['role']=3;
            }
            $_SESSION['username']=$un;
        header("location: experiences.php");
    }
    
    function add_user($un, $pw, $role) {
        $mysql = New Mysql();
        
        // to hash password:
        // md5($pw);
        
        $num = $mysql->checkRows($un);

        if($num == 0) {
           $mysql->addNewUser($un, $pw, $role);
        } else echo "User already exists";
        
    }
    
    function redirect() {
        header( "location:../public/login.php");
        echo redirecting;
    }

    function newRedirect() {
        if($_SESSION['role'] == 2) {
             header( "location: ../mentors/mentorIndex.php");
        }
        if($_SESSION['role'] == 3) {
             header( "location: ../mentees/menteeIndex.php");
        }
    }

    function getExecUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        echo $mysql->getExecFromNum($uID);
    }


    function returnExecUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecFromNum($uID);
    }

    function checkMentorPaired($mentor_id) {
        $mysql = New Mysql();
        return $mysql->checkMentorPaired($mentor_id);
    }

    function checkMenteePaired($mentee_id) {
        $mysql = New Mysql();
        return $mysql->checkMenteePaired($mentee_id);
    }

    function getRow($uID) {
        $mysql = New Mysql();
        $row = $mysql->getRow($uID);
        return $row;
    }

    function getExecPhoto($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toReturn="../uploads/" . $mysql->getExecPhotoName($uID);
        return $toReturn;
    }

    function getExecMajor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getExecMajor1($uID);
        return $toPrint;
    }

    function getExecMajor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getExecMajor2($uID);
        return $toPrint2;
    }

    function getExecMinor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getExecMinor1($uID);
        return $toPrint;
    }

    function getExecMinor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getExecMinor2($uID);
        return $toPrint2;
    }
    
    function getExecYear($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecYear($uID);
    }

    function getExecAge($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecAge($uID);
    }

    function getExecRegion($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecRegion($uID);
    }

    function getExecPos($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecPos($uID);
    }

    function getExecPersonal($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecPersonal($uID);
    }

    function getExecExp($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecExp($uID);
    }

    function getExecExpArray($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecExpArray($uID);
    }

    function log_user_out() {
        if(isset($_SESSION['status'])) {
            unset($_SESSION['status']);
            // get rid of cookie on computer
            if(isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 10000);
                session_destroy();
            }
        }
    }
    
    function confirm_member() {
        session_start();
        if($_SESSION['status'] != 'authorized') {
             header("location: login.php");
        }
    }
    
    function add_exec($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region, $pos) {

        $mysql = New Mysql();

        $num = $mysql->checkExecRows($un);
        echo $num . " ";
        if($num == 0) {
            $mysql->addNewExec($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region, $pos);
        echo "membership ";
        } //else return "Exec user already exists";
    }

    function add_applicant($name1, $name2, $un, $grad, $previous, $age, $major1, $region, $top10, $time, $reason, $major2, $minor1, $minor2, $experience, $training) {
        $mysql = New Mysql();
        
        $num = $mysql->checkApplicantRows($name1);
        if($num == 0) {
            $mysql->addNewApplicant($name1, $name2, $un, $grad, $previous, $age, $major1, $region, $top10, $time, $reason, $major2, $minor1, $minor2, $experience, $training);
        } 
        
    }
    
    function add_mentor($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region) {
        $mysql = New Mysql();
        
        $num = $mysql->checkMentorRows($un);
        
        if($num == 0) {
            $mysql->addNewMentor($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region);
        } else echo "Mentor user already exists";
    }
    
     function add_mentee($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region) {
        $mysql = New Mysql();
        
        $num = $mysql->checkMenteeRows($un);
        
        if($num == 0) {
            $mysql->addNewMentee($name1, $name2, $un, $grad, $major1, $major2, $minor1, $minor2, $age, $region);
        } else echo "Mentee user already exists";
    }
    
    function add_experience($overwhelmed, $fail_test, $anxiety, $over_committed, $fail_class, $homesick, $family,
 $isolated, $roommate, $depression, $death, $relationships, $caps, $no_alcohol, $extreme_alcohol, $eating_disorder, 
$suicide, $disability, $drugs, $homeschool, $money, $greek, $transfer, $international, $academic_probation, $military) {
        $mysql = New Mysql();

        $uID = $mysql->getUserID($_SESSION['username']);

        $num = $mysql->checkExperienceRow($uID);

        if($num == 0) {
              $mysql->addNewExperience($overwhelmed, $fail_test, $anxiety, $over_committed, $fail_class, $homesick, 
$family, $isolated, $roommate, $depression, $death, $relationships, $caps, $no_alcohol, $extreme_alcohol, 
$eating_disorder, $suicide, $disability, $drugs, $homeschool, $money, $greek, $transfer, $international, 
$academic_probation, $military, $uID);
        }
        else {
              $mysql->updateExperience($overwhelmed, $fail_test, $anxiety, $over_committed, $fail_class, $homesick, 
$family, $isolated, $roommate, $depression, $death, $relationships, $caps, $no_alcohol, $extreme_alcohol, 
$eating_disorder, $suicide, $disability, $drugs, $homeschool, $money, $greek, $transfer, $international, 
$academic_probation, $military, $uID);
        }
    }

    function sendPass($un) {
        $mysql = New Mysql();
        $exists = $mysql->checkUser($un);
        if($exists) {
        $to = $un . '@virginia.edu';
        $subject = 'SEAS Mentorship Password';
        $pw = $mysql->getPass($un);
        $message = 'Your password for the SEAS Mentorship website is: ' . $pw;
        $from = 'From: info@uvaseasmentorship.com';
        mail($to, $subject, $message, $from);
        header("location: ../public/getpassconfirm.php"); }
        else {
           header("location: ../public/getpassreject.php"); }
    }

    function updateExecUser($un, $major1, $major2,$minor1, $minor2, $year, $region, $personal, $pos) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $mysql->updateExecUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID);
    }

    function getExecFirstName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecFirstName($uID);
    }

    function getExecLastName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getExecLastName($uID);
    }

    function addAnnouncement($sub, $email, $text) {
        $mysql = New Mysql();
        $mysql->addAnnouncement($sub, $_SESSION['username'], $email, $text); 
    }

    function getAnnouncementSubject($index) {
        $mysql = New Mysql();
        return $mysql->getAnnouncementSubject($index);
    }

    function getAnnouncementPostBy($index) {
        $mysql = New Mysql();
        return $mysql->getAnnouncementPostBy($index);
    }

    function getAnnouncementPostTo($index) {
        $mysql = New Mysql();
        return $mysql->getAnnouncementPostTo($index);
    }

    function getAnnouncementText($index) {
        $mysql = New Mysql();
        return $mysql->getAnnouncementText($index);
    }

    function getAnnouncementDate($index) {
        $mysql = New Mysql();
        return $mysql->getAnnouncementDate($index);
    }

    function getNumAnnouncements() {
        $mysql = New Mysql();
        return $mysql->getNumAnnouncements();
    }

    function getNumEvents() {
        $mysql = New Mysql();
        return $mysql->getNumEvents();
    }

    function getNumEventsSem($sem) {
        $mysql = New Mysql();
        return $mysql->getNumEventsSem($sem);
    }

    function updateMentorUser($un, $major1, $major2,$minor1, $minor2, $year, $region, $personal, $pos) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $mysql->updateMentorUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID);
    }

    function getMentorFirstName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorFirstName($uID);
    }

    function getMentorFirstNameById($UID) {
        $mysql = New Mysql();
        return $mysql->getMentorFirstNameById($UID);
    }

    function getMentorLastName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorLastName($uID);
    }

    function getMentorUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        echo $mysql->getMentorFromNum($uID);
    }


    function returnMentorUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorFromNum($uID);
    }

    function getMentorPhoto($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toReturn="../uploads/" . $mysql->getMentorPhotoName($uID);
        return $toReturn;
    }

    function getMentorMajor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getMentorMajor1($uID);
        return $toPrint;
    }

    function getMentorMajor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getMentorMajor2($uID);
        return $toPrint2;
    }

    function getMentorMinor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getMentorMinor1($uID);
        return $toPrint;
    }

    function getMentorMinor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getMentorMinor2($uID);
        return $toPrint2;
    }
    
    function getMentorYear($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorYear($uID);
    }

    function getMentorAge($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorAge($uID);
    }

    function getMentorRegion($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorRegion($uID);
    }

    function getMentorPos($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorPos($uID);
    }

    function getMentorPersonal($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorPersonal($uID);
    }

    function getMentorExp($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorExp($uID);
    }

    function getMentorExpArray($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMentorExpArray($uID);
    }

    function updateMenteeUser($un, $major1, $major2,$minor1, $minor2, $year, $region, $personal, $pos) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $mysql->updateMenteeUser($major1, $major2, $minor1, $minor2, $year, $region, $personal, $pos, $uID);
    }

    function getMenteeFirstName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeFirstName($uID);
    }

    function getMenteeLastName($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeLastName($uID);
    }

    function getMenteeUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        echo $mysql->getMenteeFromNum($uID);
    }


    function returnMenteeUser($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeFromNum($uID);
    }

    function getMenteePhoto($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toReturn="../uploads/" . $mysql->getMenteePhotoName($uID);
        return $toReturn;
    }

    function getMenteeMajor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getMenteeMajor1($uID);
        return $toPrint;
    }

    function getMenteeMajor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getMenteeMajor2($uID);
        return $toPrint2;
    }

    function getMenteeMinor($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint=$mysql->getMenteeMinor1($uID);
        return $toPrint;
    }

    function getMenteeMinor2($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        $toPrint2=$mysql->getMenteeMinor2($uID);
        return $toPrint2;
    }
    
    function getMenteeYear($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeYear($uID);
    }

    function getMenteeAge($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeAge($uID);
    }

    function getMenteeRegion($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeRegion($uID);
    }

    function getMenteePersonal($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteePersonal($uID);
    }

    function getMenteeExp($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeExp($uID);
    }

    function getMenteeExpArray($un) {
        $mysql = New Mysql();
        $uID = $mysql->getUserID($un);
        return $mysql->getMenteeExpArray($uID);
    }
    
    function addPair($mentorUID,$menteeuid,$comments) {
        $mysql = New Mysql();
        return $mysql->addPair($mentorUID,$menteeuid,$comments);
    }

    function getMentor($mentor_id) {
        $mysql = New Mysql();
        return $mysql->getMentor($mentor_id);
    }

    function getMentee($mentee_id) {
        $mysql = New Mysql();
        return $mysql->getMentee($mentee_id);
    }

    function getMyMentee($mentor_un) {
        $mysql = New Mysql();
        return $mysql->getMyMentee($mentor_un);
    }

    function getMyMentor($mentee_un) {
        $mysql = New Mysql();
        return $mysql->getMyMentor($mentee_un);
    }

}