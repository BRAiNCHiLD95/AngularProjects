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
        <title>JTP BackEnd | View Content</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="ckeditor/ckeditor.js"></script>
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
                    <li class="text-success breadcrumb-item active">View Content</li>
                </ol>
                <!-- DataTable -->
                <div class="table-responsive">
                    <table id="contents_table" class="display">
                        <thead>
                            <tr class="text-center ">
                                <th>Subject Name</th>
                                <th>Subtopic Name</th>
                                <th>Content Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $fetch = "SELECT * FROM `subjects` INNER JOIN `subtopics` ON `subjects`.`subject_id` = `subtopics`.`subject_id` INNER JOIN `contents` ON `contents`.`subtopic_id` = `subtopics`.`subtopic_id`";
                            $run = mysqli_query($conn, $fetch);
                            $srno = 1;
                            while ($res = mysqli_fetch_assoc($run)) { ?>
                                <tr>
                                    <td class="text-center"> <?php echo $res['subject_name']; ?></td>
                                    <td> <?php echo $res['subtopic_name']; ?> </td>
                                    <td> <?php echo $res['content_title']; ?> </td>
                                    <td class="text-center">
                                        <a class="btn btn-info col-md-2 mx-md-1 ml-md-5 mt-1 mt-md-0" data-toggle="modal" data-target="#content_edit" id="edit_content" onclick="edit_content(<?php echo $res['content_id'];?>)"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger col-md-2" id="del_content" href="contentOps.php?delete=<?php echo $res['content_id'];?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subject Name</th>
                                <th>Subtopic Name</th>
                                <th>Content Title</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a class="badge badge-light text-right my-2" style="font-size: 16px; color: #243E60; display: inline-block !important; float: right;" href="add_content.php">Add More Content</a>
                <?php require('footer.php'); ?>
            </div>
        </div>
        <!-- Closing wrapper from common -->
        </div>
        <div class="modal fade" id="content_edit" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="contentModalLabel">Edit Post Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
              <form action="contentOps.php" method="POST">
                <div class="modal-body">
                    <div class="form-row my-2">
                        <input type="hidden" name="content_id">
                        <label for="subject" class="col-md-2 my-2"> Subject:</label>
                        <select id="subject" class="form-control col-md-8" name="subject_id" required>
                            <option disabled>Select a Subject</option>
                            <?php 
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
                    <div class="form-row my-2">
                        <label for="subtopic" class="col-md-2 my-2"> Subtopic:</label>
                        <select id="subtopic" class="form-control col-md-8" name="subtopic_id" required>
                        </select>
                    </div>
                    <div class="form-row my-2">
                        <label for="title" class="col-md-2"> Content Title:</label>
                        <input type="text" id="title" class="form-control col-md-8" name="title" required placeholder="Enter content title">
                    </div>
                    <div class="form-group">
                        <label for="content" class="my-3"> Content Body:</label>
                        <textarea name="content" id="content" class="form-control col-md-8"></textarea>
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
                $('#contents_table').DataTable({
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
                $('table').on('click', '#del_content', function() {
                    var redirectDelete = confirm('Are you sure you want to delete '+$(this).parent().prev().text()+'?');
                    return redirectDelete;
                });
            });
            function edit_content(contentID) {
                $.ajax({
                    url:"contentOps.php?editContent="+contentID,
                    datatype:"json",
                    success:function(response){
                        $res = JSON.parse(response);
                        console.log($res);
                        $contentEditor = CKEDITOR.instances['content'];
                        if ($contentEditor) { $contentEditor.destroy(true); }
                        CKEDITOR.replace( 'content', {
                            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
                            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
                        });
                        $('input[name="content_id"]').val($res.content_id);
                        $('#subject').val($res.subject_id);
                        CKEDITOR.instances['content'].setData($res.content_body);
                        $('#title').val($res.content_title);
                        $.ajax({
                            url: 'contentOps.php?subjectID='+$res.subject_id,
                            datatype: 'json',
                            success: function(response) {
                                $res = JSON.parse(response);
                                $subtopics = '';
                                for (var topic in $res) {
                                    $subtopics += '<option value="'+$res[topic].subtopic_id+'">'+$res[topic].subtopic_name+'</option>';
                                }
                                $('#subtopic').html($subtopics);
                            }
                        });
                    }
                });
            }
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