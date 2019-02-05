<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {   
        require_once('config.php');
?>
<!doctype html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>JTP BackEnd | Add Content</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="ckeditor/ckeditor.js"></script>
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
                    <li class="text-success breadcrumb-item active">Add Content</li>
                </ol>
                <!-- Add Content Form -->
                <div class="row">
                    <div class="col-md-12 py-3">
                        <form action="contentOps.php" method="POST">
                            <h3 class="text-center font-weight-bold my-3">ADD CONTENT</h3>    
                            <div class="form-group form-inline">
                                <?php 
                                    if ((isset($_GET['id']) && $_GET['id'] != '') && (isset($_GET['sub_id']) && $_GET['sub_id'] != '' )) {                                        
                                        $subjectID = $_GET['id'];
                                        $subtopicID = $_GET['sub_id'];
                                        $fetchData = "SELECT * FROM `subjects` INNER JOIN `subtopics` ON `subjects`.`subject_id` = $subjectID WHERE `subtopic_id` = $subtopicID";
                                        $fetch = mysqli_query($conn, $fetchData);
                                        $data = mysqli_fetch_assoc($fetch);
                                        $fetchSubjects = "SELECT * FROM `subjects`"; 
                                        $subjectsFetched = mysqli_query($conn, $fetchSubjects);
                                        $fetchSubtopics = "SELECT * FROM `subtopics` WHERE `subject_id` = $subjectID"; 
                                        $subtopicsFetched = mysqli_query($conn, $fetchSubtopics);
                                ?>
                                    <label for="subject" class="my-3 col-md-2"> Select Subject:</label>
                                    <select id="subject" class="form-control col-md-8" name="subjectName">
                                    <option selected hidden value="<?php echo $data['subject_id']; ?>"><?php echo $data['subject_name']; ?></option>
                                    <?php 
                                        while($subjects = mysqli_fetch_assoc($subjectsFetched)) {
                                    ?>
                                        <option value="<?php echo $subjects['subject_id']; ?>"><?php echo $subjects['subject_name']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select><div class="col-md-2"></div>
                                <label for="subtopic" class="my-3 col-md-2"> Select Subtopic:</label>
                                <select id="subtopic" class="form-control col-md-8" name="subtopicName">
                                    <option selected hidden value="<?php echo $data['subtopic_id']; ?>"><?php echo $data['subtopic_name']; ?></option>
                                    <?php
                                        while($subtopics = mysqli_fetch_assoc($subtopicsFetched)) {
                                    ?>
                                        <option value="<?php echo $subtopics['subtopic_id']; ?>"><?php echo $subtopics['subtopic_name']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <?php 
                                    } else {
                                ?>
                                    <label for="subject" class="my-3 col-md-2"> Select Subject:</label>
                                    <select id="subject" class="form-control col-md-8" name="subjectName">
                                        <option selected disabled hidden>Select Subject</option>
                                <?php
                                    $fetchSubjects = "SELECT * FROM `subjects`"; 
                                    $subjectsFetched = mysqli_query($conn, $fetchSubjects);
                                    while ($data = mysqli_fetch_assoc($subjectsFetched)) {
                                ?>
                                    <option value="<?php echo $data['subject_id']; ?>"><?php echo $data['subject_name']; ?></option>                                     
                                <?php
                                    }
                                ?>
                                </select>
                                <div class="col-md-2"></div>
                                <label for="subtopic" class="my-3 col-md-2"> Select Subtopic:</label>
                                <select id="subtopic" class="form-control col-md-8" name="subtopicName">
                                    <option selected disabled hidden>Select a subject first!</option>
                                </select>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="form-group form-inline">
                                <label for="content" class="col-md-2"> Content Title:</label>
                                <input type="text" class="form-control col-md-8" name="title" required placeholder="Enter content title">
                            </div>
                            <div class="form-group ml-md-4 pl-md-2">
                                <label for="content" class="my-3"> Content Body:</label>
                                <textarea name="content" class="form-control col-md-8"></textarea>
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
        <script>
            $(document).ready(function() {
                CKEDITOR.replace( 'content', {
                    filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
                    filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
                });
                $(document).on('change', '#subject', function() {
                    $id = $(this).find(":selected").val();
                    $.ajax({
                        url: 'contentOps.php?subjectID='+$id,
                        datatype: 'json',
                        success: function(response) {
                            $res = JSON.parse(response);
                            $subtopics = '';
                            for (var topic in $res) {
                                $subtopics += '<option value="'+$res[topic].subtopic_id+'">'+$res[topic].subtopic_name+'</option>';
                            }
                            $('#subtopic').html($subtopics);
                        }
                    })
                });
            });
        </script>
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