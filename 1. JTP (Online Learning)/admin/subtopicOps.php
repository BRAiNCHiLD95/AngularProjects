<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {  
        require_once('config.php');
        // check with operation is being requested
    
    // ADD OPERATION
        if (isset($_GET['subtopicName']) && $_GET['subtopicName'] != '') {
            $subtopicName = $_GET['subtopicName'];
            $subjectID = $_GET['subjectID'];
            $checkDB = "SELECT * FROM `subtopics` INNER JOIN `subjects` ON `subjects`.`subject_id` = $subjectID  WHERE `subtopics`.`subtopic_name` = '$subtopicName'";
            $fetch = mysqli_query($conn, $checkDB);
            if (mysqli_num_rows($fetch) == 0) {
                $addSubtopic = "INSERT INTO subtopics (`subject_id`,`subtopic_name`) VALUES ($subjectID, '$subtopicName')";
                $add = mysqli_query($conn, $addSubtopic); 
                if ($add == 1) {
                    header('Location: subtopics.php');
                }
                else {
                    echo
                    '<script language="javascript">
                    alert("Database Error! Contact Us for help!");
                    </script>';
                }       
            }
            else {
                echo
                '<script language="javascript">
                alert("Subtopic Already Exists in Database!");
                window.location.href="subtopics.php"
                </script>';
            }
        }

    // EDIT OPERATION
        // EDIT-FETCH OPERATION
        else if (isset($_GET['editSubtopic']) && $_GET['editSubtopic'] != '') {
            $idToEdit = $_GET['editSubtopic'];
            $fetchSubtopic = "SELECT * FROM `subjects` INNER JOIN `subtopics` ON `subtopics`.`subject_id` = `subjects`.`subject_id` WHERE `subtopic_id` = $idToEdit";
            $query = mysqli_query($conn, $fetchSubtopic);
            $res = mysqli_fetch_assoc($query);
            echo json_encode($res);
        }
        // EDIT-UPDATE OPERATION 
        else if (isset($_GET['subtopic_id']) && $_GET['subtopic_id'] != '') {
            $idToUpdate = $_GET['subtopic_id'];
            $newSubjectID = $_GET['subject_id'];
            $newSubtopicName = $_GET['newsubtopic'];
            $updateDB = "UPDATE `subtopics` SET `subtopic_name` = '$newSubtopicName', `subject_id` = $newSubjectID WHERE `subtopic_id`= $idToUpdate";
            $updated = mysqli_query($conn, $updateDB);
            if ($updated == 1) {
                header('Location: subtopics.php');
            } else {
                echo
                '<script language="javascript">
                alert("Database Error! Contact Us for help!");
                </script>';
            }
        }

    // DELETE OPERATION
        else if (isset($_GET['deleteSubtopic']) && $_GET['deleteSubtopic'] != '') {
            $idToDelete = $_GET['deleteSubtopic'];
            $deleteQuery = "DELETE FROM `subtopics` WHERE `subtopic_id` = $idToDelete";
            $subtopicDeleted = mysqli_query($conn, $deleteQuery);
            if ($subtopicDeleted == 1) {
                header('Location: subtopics.php');
            } else {
                echo
                '<script language="javascript">
                alert("Database Error! Contact Us for help!");
                </script>';
            }
        }

    // FOR THE SMARTASSES
        else {
            header('Location: 404.php');
        }
    }
    else {
        echo
        '<script language="javascript">
        alert("Please Login to Access AdminPanel");
        window.location.href="login.php"
        </script>';
    }
?>