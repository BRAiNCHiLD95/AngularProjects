<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {  
        require_once('config.php');
        // check with operation is being requested
    
    // ADD OPERATION
        if (isset($_GET['subjectName']) && $_GET['subjectName'] != '') {
            $subjectName = $_GET['subjectName'];
            $checkDB = "SELECT * FROM `subjects` WHERE `subject_name` = '$subjectName'";
            $fetch = mysqli_query($conn, $checkDB);
            if (mysqli_num_rows($fetch) == 0) {
                $addSubject = "INSERT INTO subjects (`subject_name`) VALUE ('$subjectName')";
                $add = mysqli_query($conn, $addSubject); 
                if ($add == 1) {
                    header('Location: subjects.php');
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
                alert("Subject Already Exists in Database!");
                window.location.href="subjects.php"
                </script>';
            }
        }

    // EDIT OPERATION
        // EDIT-FETCH OPERATION
        else if (isset($_GET['editSub']) && $_GET['editSub'] != '') {
            $idToEdit = $_GET['editSub'];
            $fetchSubject = "SELECT * FROM `subjects` WHERE `subject_id` = $idToEdit";
            $query = mysqli_query($conn, $fetchSubject);
            $res = mysqli_fetch_assoc($query);
            echo json_encode($res);
        }
        // EDIT-UPDATE OPERATION 
        else if (isset($_GET['sub_id']) && $_GET['sub_id'] != '') {
            $idToUpdate = $_GET['sub_id'];
            $newSubjectName = $_GET['newname'];
            $updateDB = "UPDATE `subjects` SET `subject_name` = '$newSubjectName' WHERE `subject_id`= $idToUpdate";
            $updated = mysqli_query($conn, $updateDB);
            if ($updated == 1) {
                header('Location: subjects.php');
            } else {
                echo
                '<script language="javascript">
                alert("Database Error! Contact Us for help!");
                </script>';
            }
        }

    // DELETE OPERATION
        else if (isset($_GET['deleteSub']) && $_GET['deleteSub'] != '') {
            $idToDelete = $_GET['deleteSub'];
            $deleteQuery = "DELETE FROM subjects WHERE `subject_id` = $idToDelete";
            $subjectDeleted = mysqli_query($conn, $deleteQuery);
            if ($subjectDeleted == 1) {
                header('Location: subjects.php');
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