<?php 
    // phpinfo();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('./config/Database.php');
    include_once('./models/DataModel.php');

    $database = new Database();
    $db = $database->connect();
    
    $content = new DataModel($db);
    
    // binding
    $content->id = isset($_GET['cid']) ? $_GET['cid'] : die();
    // fetch
    $content->getSingleContent();

    $singlePost = array(
        'id' => $content->content_id,
        'subject' => $content->subject_name,
        'subtopic' => $content->subtopic_name,
        'title' => $content->title,
        'body' => $content->body,
        'created_at' => $content->created_at,
    );

    print_r(json_encode($singlePost));
?>