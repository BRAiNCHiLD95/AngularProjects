<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {   
?>
<!doctype html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>JTP BackEnd | Add SubTopic</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <style>
          .icons {
            font-size: 40px;
          }
        </style>
    </head>
    <body>
    <?php require('common.php'); ?>
        <div id="content-wrapper" class="mybgcolor">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb bg-warning">
                    <li class="breadcrumb-item">
                        <a style="color: #243E60" href="index.php">Dashboard</a>
                    </li>
                    <li class="text-success breadcrumb-item active">Add SubTopic</li>
                </ol>
                <!-- Add Subject Form -->
                <div class="row">
                    <div class="col-md-8 offset-md-2 my-5 py-3">
                        <form action="subtopicOps.php" method="GET">
                            <h3 class="text-center font-weight-bold my-3">ADD A SUB-TOPIC</h3>    
                            <div class="form-group offset-md-2">
                                <label for="subject" class="my-3"> Subject:</label>
                                <select id="subject" class="form-control col-md-8" name="subjectID" required>
                                    <?php
                                        if(isset($_GET['id']) && $_GET['id'] != '') {
                                            require_once('config.php');
                                            $subjectID = $_GET['id'];
                                            $fetchCurrSubject = "SELECT * FROM `subjects` WHERE `subject_id` = $subjectID";
                                            $fetch = mysqli_query($conn, $fetchCurrSubject);
                                            $currSubject = mysqli_fetch_assoc($fetch);
                                        ?>
                                        <option selected hidden value="<?php echo $currSubject['subject_id']; ?>"> <?php echo $currSubject['subject_name']; ?>
                                    <?php
                                        } else {
                                    ?>
                                        <option selected disabled hidden>Select a Subject</option>
                                    <?php 
                                        }
                                        require_once('config.php');
                                        $fetchSubject = "SELECT * FROM `subjects`";
                                        $subjects = mysqli_query($conn, $fetchSubject);
                                        while ($data = mysqli_fetch_assoc($subjects)) {
                                        ?>
                                            <option value="<?php echo $data['subject_id']; ?>"><?php echo $data['subject_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                                <label for="subtopicName" class="my-3">SubTopic Name:</label>    
                                <input type="text" class="form-control my-3 col-md-8" name="subtopicName" id="subtopicName" required placeholder="Enter a Subtopic Name">
                            </div>
                            <div class="row">
                                <div class="col-md-8 my-3 mx-auto">
                                    <button class="btn btn-primary col-md-5 mx-0" type="submit" name="submit">ADD</button>
                                    <button class="btn btn-danger col-md-5 mx-0 mt-2 mt-md-0" type="reset">CLEAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php require('footer.php'); ?>
            </div>
        </div>
        <!-- Closing wrapper from common -->
        </div>
    </body>
</html>
<?php }
    else {
      echo
      '<script language="javascript">
      alert("Please Login to Access AdminPanel");
      window.location.href="login.php"
      </script>';
    }
?>