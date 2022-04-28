<?php

$page_title="SJCM Course Search";
include('includes/header.html');
require("db_connect_sjcm.php");

//I'm so sorry for how this code turned out

//General Search Box
echo '<div class="box1">';
echo '<h1>General Search Criteria</h1>';

echo '<form action="searchpage.php" method="POST">';

//If just semester
//Variable set
if(isset($_POST['sem_name'])) {
    $sem_name=$_POST['sem_name'];
} else {
    $sem_name=NULL;
}
//query
$q="SELECT sem_name FROM semName";
$r=mysqli_query($dbc, $q);

if($r) {
    echo '<label for="sem_name">Semester:</label>';
    echo '<select name="sem_name" id="sem_name">';
    while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<option value="' . $row['sem_name'] . '">' . $row['sem_name'] . '</option>';
    }
    echo '</select><br/>';
}

//departments
if(isset($_POST['dept'])) {
    $dept=$_POST['dept'];
} else {
    $dept=NULL;
}
//query
$q2="SELECT dept FROM departments";
$r2=mysqli_query($dbc, $q2);
if($r2) {
    echo '<label for="dept">Department:</label>';
    echo '<select name="dept" id="dept">';
    while($row2=mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        echo '<option value="' . $row2['dept'] . '">' . $row2['dept'] . '</option>';
    }
    echo '</select><br/>';
}

//professors
if(isset($_POST['prof_last'])) {
    $prof_last=$_POST['prof_last'];
} else {
    $prof_last=NULL;
}
//query
$q3="SELECT prof_last FROM professors";
$r3=mysqli_query($dbc, $q3);
if($r3) {
    echo '<label for="prof_last">Professor:</label>';
    echo '<select name="prof_last" id="prof_last">';
    while($row3=mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
        echo '<option value="' . $row3['prof_last'] . '">' . $row3['prof_last'] . '</option>';
    }
    echo '</select><br/>';
}
    echo '<input type="submit" value="Search Courses" name="General"/>';

echo '</form>';

//NOTE: I apologize for all the new queries and the whole mess that is this upcoming block of code. For some reason, doing $q5.="WHERE --" or any iteration of it, the PHP would not read it as a MySQL statement (I assume it was reading as a string), therefore it would connect to the end of the query but not be read as part of the query––therefore it would still just read q5 as it was originally coded under if-post-general and bring up all the classes as a result.

//If
if($_SERVER['REQUEST_METHOD']=='POST') {
    if($_POST['General']) {
        $q5="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof";
        $r5=mysqli_query($dbc, $q5);
        //all instances w/semester
        if($sem_name) {
            $q6="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE sem_name='$sem_name'";
            $r6=mysqli_query($dbc, $q6);
            while($gresult=mysqli_fetch_array($r6, MYSQLI_ASSOC)) {
                echo "<h1>" . $gresult['dept'] . "</h1>";
                echo "<p><b>" . $gresult['course_dept'] . $gresult['course_num'] . ": " . $gresult['course_title'] . "</b></p>";
                echo "<p>" . $gresult['course_desc'] . "</p>";
                echo "<p><b>Semester(s): </b >" . $gresult['sem_name'] . "</p>";
                echo "<p><b>Instructor: </b>" . $gresult['course_prof'] . "</p>";
            }
            //Code will not read past q6 query, unsure how to fix
            if($dept) {
                $q7="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE sem_name='$sem_name' && course_dept='$dept'";
            $r7=mysqli_query($dbc, $q7);
            while($gresult2=mysqli_fetch_array($r7, MYSQLI_ASSOC)) {
                echo "<h1>" . $gresult2['dept'] . "</h1>";
                echo "<p><b>" . $gresult2['course_dept'] . $gresult2['course_num'] . ": " . $gresult2['course_title'] . "</b></p>";
                echo "<p>" . $gresult2['course_desc'] . "</p>";
                echo "<p><b>Semester(s): </b >" . $gresult2['sem_name'] . "</p>";
                echo "<p><b>Instructor: </b>" . $gresult2['course_prof'] . "</p>";
            }
                if($prof_last) {
                    $q8="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE sem_name='$sem_name' && course_dept='$dept' && course_prof='$prof_last'";
                    $r8=mysqli_query($dbc, $q8);
                    while($gresult3=mysqli_fetch_array($r8, MYSQLI_ASSOC)) {
                        echo "<h1>" . $gresult3['dept'] . "</h1>";
                        echo "<p><b>" . $gresult3['course_dept'] . $gresult3['course_num'] . ": " . $gresult3['course_title'] . "</b></p>";
                        echo "<p>" . $gresult3['course_desc'] . "</p>";
                        echo "<p><b>Semester(s): </b >" . $gresult3['sem_name'] . "</p>";
                        echo "<p><b>Instructor: </b>" . $gresult3['course_prof'] . "</p>";
                    }
                }
            }
        }
        //all instances no semester
        if($dept) {
            $q9="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE course_dept='$dept'";
            $r9=mysqli_query($dbc, $q9);
            while($gresult4=mysqli_fetch_array($r9, MYSQLI_ASSOC)) {
                echo "<h1>" . $gresult4['dept'] . "</h1>";
                echo "<p><b>" . $gresult4['course_dept'] . $gresult4['course_num'] . ": " . $gresult4['course_title'] . "</b></p>";
                echo "<p>" . $gresult4['course_desc'] . "</p>";
                echo "<p><b>Semester(s): </b >" . $gresult4['sem_name'] . "</p>";
                echo "<p><b>Instructor: </b>" . $gresult4['course_prof'] . "</p>";
            }
            if($prof_last) {
                $q10="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE dept='$dept' && course_prof='$prof_last'";
            $r10=mysqli_query($dbc, $q10);
            while($gresult=mysqli_fetch_array($r10, MYSQLI_ASSOC)) {
                echo "<h1>" . $gresult5['dept'] . "</h1>";
                echo "<p><b>" . $gresult5['course_dept'] . $gresult5['course_num'] . ": " . $gresult5['course_title'] . "</b></p>";
                echo "<p>" . $gresult5['course_desc'] . "</p>";
                echo "<p><b>Semester(s): </b >" . $gresult5['sem_name'] . "</p>";
                echo "<p><b>Instructor: </b>" . $gresult5['course_prof'] . "</p>";
            }
            }
        }
        //last one
        if($prof_last) {
            $q11="SELECT course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN semOffered AS o ON o.course_id=c.course_id INNER JOIN semName AS s ON s.sem_id=o.semester_id INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE course_prof='$prof_last'";
            $r11=mysqli_query($dbc, $q11);
            while($gresult6=mysqli_fetch_array($r11, MYSQLI_ASSOC)) {
                echo "<h1>" . $gresult6['dept'] . "</h1>";
                echo "<p><b>" . $gresult6['course_dept'] . $gresult6['course_num'] . ": " . $gresult6['course_title'] . "</b></p>";
                echo "<p>" . $gresult6['course_desc'] . "</p>";
                echo "<p><b>Semester(s): </b >" . $gresult6['sem_name'] . "</p>";
                echo "<p><b>Instructor: </b>" . $gresult6['course_prof'] . "</p>";
            }
        }
    }
}


echo '</div>';

//Course Search Box
echo '<div class="box2">';
echo '<h1>Course Search</h1>';
echo '<form action="searchpage.php" method="POST">';

//if course abr
if(isset($_POST['abr'])) {
    $abr=$_POST['abr'];
} else {
    $abr=NULL;
}

if(isset($_POST['course_num'])) {
    $course_num=$_POST['course_num'];
} else {
    $course_num=NULL;
}
//query
$q4="SELECT abr FROM departments";
$r4=mysqli_query($dbc, $q4);
if($r4) {
    echo '<label for="abr">Course Search:</label>';
    echo '<select name="abr" id="abr">';
    while($row4=mysqli_fetch_array($r4, MYSQLI_ASSOC)) {
        echo '<option value="' . $row4['abr'] . '">' . $row4['abr'] . '</option>';
    }
    echo '</select>';

    echo '<input type="text" name="course_num" id="course_num">';

    echo '<input type="submit" name="Course" value="Course Search"/>';
    echo '</form>';
}

if($_SERVER['REQUEST_METHOD']=='POST') {
    if($_POST['Course']) {
    $qs="SELECT course_id, course_dept, course_num, course_title, course_desc, course_prof FROM departments AS d INNER JOIN courses AS c ON c.course_dept=d.abr INNER JOIN professors AS p ON p.prof_last=c.course_prof WHERE course_num='$course_num' && course_dept='$abr'";
    $rs=mysqli_query($dbc, $qs);
    if($rs) {
    while($result=mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
        echo "<h1>" . $result['d.dept'] . "</h1>";
        echo "<p><b>" . $result['course_dept'] . $result['course_num'] . ": " . $result['course_title'] . "</b></p>";
        echo "<p>" . $result['course_desc'] . "</p>";
        echo "<p><b>Instructor: </b>" . $result['course_prof'] . "</p>";
    }
} else {
    echo "Sorry, we couldn't find a course with that name.";
}
}
}
//I know this one doesn't pull all of the required information but it works and I'm actually pretty proud of at least that much

echo '</div>';

//Again I'm very sorry for the state of this final
//On a brighter note I am proud of what I was able to get done because honestly it was more than I thought I would be able to do
//Thank you for this semester, I learned a lot! (despite the state of this final)
//See you for both 308 and 319 next semester!
?>