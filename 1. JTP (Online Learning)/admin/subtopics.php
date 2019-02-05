<?php 
    session_start();
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {   
?>
<!doctype html>
  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>JTP BackEnd | View SubTopics</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
                    <li class="text-success breadcrumb-item active">View Subtopics</li>
                </ol>
                <!-- DataTable -->
                <div class="table-responsive">
                    <table id="subtopics_table" class="display">
                        <thead>
                            <tr class="text-center ">
                                <th>Subject Name</th>
                                <th>Subtopic Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            require_once('config.php');
                            $fetch = "SELECT * FROM `subjects` INNER JOIN `subtopics` ON `subjects`.`subject_id` = `subtopics`.`subject_id`";
                            $run = mysqli_query($conn, $fetch);
                            $srno = 1;
                            while ($res = mysqli_fetch_assoc($run)) { ?>
                                <tr>
                                    <td class="text-center"> <?php echo $res['subject_name']; ?></td>
                                    <td> <?php echo $res['subtopic_name']; ?> </td>
                                    <td>
                                        <a class="btn btn-info col-md-1 mx-md-1 ml-md-5 mt-1 mt-md-0" data-toggle="modal" data-target="#subtopic_edit" id="edit_subtopic" onclick="edit_subtopic(<?php echo $res['subtopic_id'];?>)"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger col-md-1 mx-md-1 mt-1 mt-md-0" id="del_subtopic" href="subtopicOps.php?deleteSubtopic=<?php echo $res['subtopic_id'];?>"><i class="fa fa-trash-o"></i></a>
                                        <a class="btn btn-success col-md-3 mx-md-1 mt-1 mt-md-0" id="add_content" href="add_content.php?id=<?php echo $res['subject_id'];?>&sub_id=<?php echo $res['subtopic_id'] ?>">Add Content</a>
                                    </td>
                                </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subject Name</th>
                                <!-- <th>Subtopic Name</th> -->
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a class="badge badge-light text-right my-2" style="font-size: 16px; color: #243E60; display: inline-block !important; float: right;" href="add_subtopic.php">Add Another Subtopic</a>
                <?php require('footer.php'); ?>
            </div>
        </div>
        <!-- Closing wrapper from common -->
        </div>
        <div class="modal fade" id="subtopic_edit" tabindex="-1" role="dialog" aria-labelledby="subtopicModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="subtopicModalLabel">Edit Subtopic Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
              <form action="subtopicOps.php" method="GET">
                <div class="modal-body">
                    <div class="form-row my-2">
                        <label for="subject" class="col-md-2 my-2"> Subject:</label>
                        <select id="subject" class="form-control col-md-8" name="subject_id" required>
                            <option disabled>Select a Subject</option>
                            <?php 
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
                    </div>
                    <div class="form-row">
                        <input type="hidden" name="subtopic_id">
                        <label for="name" class="ml-1 my-2"> Current SubTopic Name:</label>
                        <input class="form-control" type="text" name="oldsubtopic" id="oldsubtopic" readonly>
                        <label for="name" class="ml-1 my-2"> New Name:</label>
                        <input class="form-control" type="text" name="newsubtopic" required placeholder="Enter new subtopic name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
			  </form>
			</div>
		  </div>
		</div>
        <script>
            $(document).ready( function () {
                $('#subtopics_table').DataTable({
                    columnDefs: [
                    { type: 'natural', targets: [1] }
                    ],
                    initComplete: function () {
                        this.api().columns().every( function () {
                            var column = this;
                            var select = $('<select class="form-control"><option value=""></option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
            
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    }
                });
                $('table').on('click', '#del_subtopic', function() {
                    var redirectDelete = confirm('Are you sure you want to delete '+$(this).parent().prev().text()+'?');
                    return redirectDelete;
                });
            });
            function edit_subtopic(subtopicID) {
                $.ajax({
                    url:"subtopicOps.php?editSubtopic="+subtopicID,
                    datatype:"json",
                    success:function(response){
                        $res = JSON.parse(response);
                        $('#subject').val($res.subject_id);
                        $('input[name="subtopic_id"]').val($res.subtopic_id);
                        $('input[name="oldsubtopic"]').val($res.subtopic_name);
                    }
                });
            }
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