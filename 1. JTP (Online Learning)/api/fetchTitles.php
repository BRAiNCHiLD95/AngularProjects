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

    $content->subtopic_id = isset($_GET['sid']) ? $_GET['sid'] : die();
    
    $result = $content->getAllTitles();

    $numOfRows = $result->rowCount();

    if ($numOfRows > 0) {
        $titlesArray = array(); 
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $title = array(
                'id' => $content_id,
                'subtopic_id' =>$subtopic_id,
                'title' => $content_title
            );
            array_push($titlesArray, $title);
        }
        // Return JSON
        echo json_encode($titlesArray);
    } else {
        echo json_encode(array( 'message' => 'Nothing found!'));
    }
?>