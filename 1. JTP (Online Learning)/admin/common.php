<!-- Navbar -->
<nav class="navbar navbar-expand navbar-dark mybgcolor static-top border-bottom border-warning" style="padding: 0px 10px;">
    <a class="navbar-brand" href="index.php"><img src="assets/images/jtp_logo1.png" height="55px" width="100px"></a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i style="color: #243E60" class="fa fa-user-circle fa-fw"></i>
                <?php if(isset($_SESSION['user_name']) && $_SESSION['user_name'] !== '' ) { ?>
                <span style="color: #243E60"><?php echo $_SESSION['user_name']; }?></span>
                <i style="color: #243E60" class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="userDropdown">
                <a class="dropdown-item py-2" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to end your current session?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No, Keep Me Logged In</button>
                    <a class="btn btn-primary" href="logout.php">Yes, Logout.</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav mybgcolor border-right border-warning">
        <li class="nav-item active">
            <a class="nav-link border-top border-bottom border-warning" href="index.php">
            <i class="fa fa-tachometer mr-2"></i>
            <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle border-top border-bottom border-warning" href="#" id="subjectDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-th mr-2"></i>
                <span>Subjects</span>
            </a>
            <div class="dropdown-menu mx-0 py-0 border-0 bg-dark" aria-labelledby="subjectDropdown">
                <a id="pages" class="dropdown-item py-2 border-bottom border-warning" href="add_subject.php">Add Subject</a>
                <a id="pages" class="dropdown-item py-2" href="subjects.php">View Subjects</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle border-top border-bottom border-warning" href="#" id="subTopicDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-list mr-2"></i>
                <span>SubTopics</span>
            </a>
            <div class="dropdown-menu mx-0 py-0 border-0 bg-dark" aria-labelledby="subTopicDropdown">
                <a id="pages" class="dropdown-item py-2 border-bottom border-warning" href="add_subtopic.php">Add SubTopic</a>
                <a id="pages" class="dropdown-item py-2" href="subtopics.php">View SubTopics</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle border-top border-bottom border-warning" href="#" id="contentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-tasks mr-2"></i>
                <span>Content</span>
            </a>
            <div class="dropdown-menu mx-0 py-0 border-0 bg-dark" aria-labelledby="subTopicDropdown">
                <a id="pages" class="dropdown-item py-2 border-bottom border-warning" href="add_content.php">Add Content</a>
                <a id="pages" class="dropdown-item py-2" href="view_content.php">View Contents</a>
            </div>
        </li>
    </ul>