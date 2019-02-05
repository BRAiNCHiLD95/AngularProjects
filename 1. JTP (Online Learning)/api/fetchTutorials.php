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

    $result = $content->getAllContent();

    $numOfRows = $result->rowCount();

    if ($numOfRows > 0) {
        $tutorialsArray = array(); 
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tutorial = array(
                'content_id' => $content_id,
                'subject_id' => $subject_id,
                'subject_name' => $subject_name,
                'subtopic_name' => $subtopic_name,
                'content_title' => $content_title,
                'created_at' => $created_at
            );
            array_push($tutorialsArray, $tutorial);
        }
        // Return JSON
        echo json_encode($tutorialsArray);
    } else {
        echo json_encode(array( 'message' => http_response_code(404) . 'Nothing found!'));
    }
?>