<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {   
?>
<!doctype html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>JTP BackEnd | Add Subject</title>
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
                    <li class="text-success breadcrumb-item active">Add Subject</li>
                </ol>
                <!-- Add Subject Form -->
                <div class="row">
                    <div class="col-md-8 offset-md-2 my-5 py-3">
                        <form action="subjectOps.php" method="GET">
                            <h3 class="text-center font-weight-bold my-3">ADD A SUBJECT</h3>    
                            <input type="text" class="form-control my-3 col-md-8 offset-md-2" name="subjectName" required placeholder="Enter a Subject Name">
                            <div class="row">
                                <div class="col-md-8 my-3 mx-auto">
                                    <button class="btn btn-primary col-md-5 mx-mt-3" type="submit" name="submit">ADD</button>
                                    <button class="btn btn-danger col-md-5 mx-mt-3 mt-2 mt-md-0" type="reset">CLEAR</button>
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