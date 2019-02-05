<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {  
        require_once('config.php');
        // check with operation is being requested

    //FETCH LISTS
        if(isset($_GET['subjectID']) && $_GET['subjectID'] != '') {
           $subjectID = $_GET['subjectID'];
           $fetchSubtopics = "SELECT * FROM `subtopics` WHERE `subject_id` = $subjectID";
           $fetch = mysqli_query($conn, $fetchSubtopics);
           $arrayOfSubtopics = [];
           while ($data = mysqli_fetch_assoc($fetch)) {
               array_push($arrayOfSubtopics, $data);
           }
           echo json_encode($arrayOfSubtopics);
        }

    // ADD OPERATION
        else if ((isset($_POST['content']) && $_POST['content'] != '') && (!isset($_POST['content_id']))) {
            $subjectID = $_POST['subjectName'];
            $subtopicID = $_POST['subtopicName'];
            $contentTitle = mysqli_real_escape_string($conn, $_POST['title']);
            $contentBody = mysqli_real_escape_string($conn, $_POST['content']);
            $checkDB = "SELECT * FROM `contents` WHERE `content_title` = '$contentTitle' AND `subtopic_id` = $subtopicID";
            $fetch = mysqli_query($conn, $checkDB);
            if (mysqli_num_rows($fetch) == 0) {
                $addContent = "INSERT INTO  `contents` (`subtopic_id`, `subject_id`,`content_title`, `content_body`) VALUES ($subtopicID, $subjectID, '$contentTitle', '$contentBody')";
                $add = mysqli_query($conn, $addContent); 
                if ($add == 1) {
                    header('Location: view_content.php');
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
                alert("Content Title Already Exists in Database!");
                window.location.href="add_content.php"
                </script>';
            }
        }

    // EDIT OPERATION

        // EDIT-FETCH OPERATION
        else if (isset($_GET['editContent']) && $_GET['editContent'] != '') {
            $idToEdit = $_GET['editContent'];
            $fetchContent = "SELECT * FROM `contents` INNER JOIN `subjects` ON `subjects`.`subject_id` = `contents`.`subject_id` INNER JOIN `subtopics` ON `subtopics`.`subtopic_id` = `contents`.`subtopic_id` WHERE `content_id` = $idToEdit";
            $query = mysqli_query($conn, $fetchContent);
            $res = mysqli_fetch_assoc($query);
            echo json_encode($res);
        }

        // EDIT-UPDATE OPERATION 
        else if (isset($_POST['content_id']) && $_POST['content_id'] != '') {
            $idToUpdate = $_POST['content_id'];
            $newSubjectID = $_POST['subject_id'];
            $newSubtopicID = $_POST['subtopic_id'];
            $newContentTitle = $_POST['title'];
            $newContentBody = $_POST['content'];
            $updateDB = "UPDATE `contents` SET `subtopic_id` = '$newSubtopicID', `subject_id` = $newSubjectID, `content_title` = '$newContentTitle', `content_body` = '$newContentBody' WHERE `content_id`= $idToUpdate";
            $updated = mysqli_query($conn, $updateDB);
            if ($updated == 1) {
                header('Location: view_content.php');
            } else {
                echo
                '<script language="javascript">
                alert("Database Error! Contact Us for help!");
                </script>';
            }
        }

    // DELETE OPERATION
        else if (isset($_GET['delete']) && $_GET['delete'] != '') {
            $idToDelete = $_GET['delete'];
            $deleteQuery = "DELETE FROM `contents` WHERE `content_id` = $idToDelete";
            $contentDeleted = mysqli_query($conn, $deleteQuery);
            if ($contentDeleted == 1) {
                header('Location: view_content.php');
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