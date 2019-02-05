<?php 
    // phpinfo();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('./config/Database.php');
    include_once('./models/DataModel.php');

    $database = new Database();
    $db = $database->connect();

    // Content Object

    $content = new DataModel($db);

    $content->subject_id = isset($_GET['sid']) ? $_GET['sid'] : die();
    
    $result = $content->getAllSubtopics();

    $numOfRows = $result->rowCount();

    if ($numOfRows > 0) {
        $subtopicsArray = array(); 
        $titles = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $subtopic = array(
                'id' => $subtopic_id,
                'content_id' => $content_id,
                'subtopic_name' => $subtopic_name,
                'title' => $content_title
            );
            array_push($subtopicsArray, $subtopic);
        }
        // Return JSON
        echo json_encode($subtopicsArray);
    } else {
        echo json_encode(array( 'message' => 'Nothing found!'));
    }
?>