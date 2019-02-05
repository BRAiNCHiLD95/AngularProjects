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

    $result = $content->getAllSubjects();

    $numOfRows = $result->rowCount();

    if ($numOfRows > 0) {
        $subjectsArray = array(); 
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $subject = array(
                'id' => $subject_id,
                'subject' => $subject_name,
            );
            array_push($subjectsArray, $subject);
        }
        // Return JSON
        echo json_encode($subjectsArray);
    } else {
        echo json_encode(array( 'message' => http_response_code(404) . 'Nothing found!'));
    }
?>