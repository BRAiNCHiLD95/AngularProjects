<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {
      require_once('config.php');
      $fetchSubjects = "SELECT * FROM `subjects`";
      $fetchSubtopics = "SELECT * FROM `subtopics`";
      $fetchContents = "SELECT * FROM `contents`";
      $subjects = mysqli_query($conn, $fetchSubjects);
      $subtopics = mysqli_query($conn, $fetchSubtopics);    
      $contents = mysqli_query($conn, $fetchContents);
?>
<!doctype html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>JTP BackEnd | HomePage</title>
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
            <li class="text-success breadcrumb-item active">Overview</li>
          </ol>
          <!-- Icon Cards-->
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card text-white text-center bg-danger">
                <div class="card-body mt-3">
                  <div class="card-body-icon">
                    <i class="icons fa fa-th"></i>
                  </div>
                  <h3 class="my-3"><?php echo mysqli_num_rows($subjects); ?> New Subjects</h3>
                </div>
                <a class="card-footer text-white my-2" href="subjects.php">
                  <span class="float-left">View All Subjects</span>
                  <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card text-white text-center bg-warning">
                <div class="card-body mt-3">
                  <div class="card-body-icon">
                    <i class="icons fa fa-list"></i>
                  </div>
                  <h3 class="my-3"><?php echo mysqli_num_rows($subtopics); ?> New Sub-topics</h3>
                </div>
                <a class="card-footer text-white my-2" href="subtopics.php">
                  <span class="float-left">View All Sub-topics</span>
                  <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card text-white text-center bg-success">
                <div class="card-body mt-3">
                  <div class="card-body-icon">
                    <i class="icons fa fa-server"></i>
                  </div>
                  <h3 class="my-3"><?php echo mysqli_num_rows($contents); ?> New Posts</h3>
                </div>
                <a class="card-footer text-white my-2" href="view_content.php">
                  <span class="float-left">View All Posts</span>
                  <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php require('footer.php'); ?>
        </div>
      </div>
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