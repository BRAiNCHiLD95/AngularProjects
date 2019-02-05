<?php
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] !== '') {
        session_destroy();
        header('Location: login.php');
    }
    else {
        echo
        '<script language="javascript">
        alert("You are not logged in!");
        window.location.href="login.php"
        </script>';
    }
?>