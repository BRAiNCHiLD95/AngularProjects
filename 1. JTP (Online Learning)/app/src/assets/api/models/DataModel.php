<?php
  class DataModel {
    private $conn;
    private $table = "contents";

    // content properties

    public $content_id;
    public $subject_id;
    public $subject;
    public $subtopic;
    public $title;
    public $body;
    public $createdAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch Content

    public function getAllContent() {
      $query = 'SELECT 
                  s.subject_name as subject_name,
                  sub.subtopic_name as subtopic_name,
                  c.content_id as content_id,
                  c.content_title as content_title,
                  c.content_body as content_body,
                  c.created_at as created_at
                FROM
                  '. $this->table .' c
                INNER JOIN
                  subjects s ON s.subject_id = c.subject_id
                INNER JOIN
                  subtopics sub on sub.subtopic_id = c.subtopic_id
                ORDER BY
                  c.created_at DESC';
          
      $statement = $this->conn->prepare($query);
      $statement->execute();

      return $statement;
    }

    // Fetch All Subjects
    public function getAllSubjects() {
      $query = 'SELECT * FROM `subjects`';
      $statement = $this->conn->prepare($query);
      $statement->execute();

      return $statement;
    }

    // Fetch All Subjects
    public function getAllSubtopics() {
      $query = 'SELECT 
                  s.subtopic_id as subtopic_id,
                  s.subject_id as subject_id,
                  s.subtopic_name as subtopic_name,
                  c.content_title as content_title,
                  c.content_id as content_id
                FROM subtopics s
                INNER JOIN '. $this->table .' c
                ON c.subtopic_id = s.subtopic_id
                WHERE s.subject_id = ?';
      $statement = $this->conn->prepare($query);
      $statement->bindParam(1, $this->subject_id);
      
      $statement->execute();
      
      return $statement;
    }
    
    public function getSingleContent() {
      $query = 'SELECT 
                  s.subject_name as subject_name,
                  sub.subtopic_name as subtopic_name,
                  c.content_id as content_id,
                  c.content_title as content_title,
                  c.content_body as content_body,
                  c.created_at as created_at
                FROM
                  '. $this->table .' c
                INNER JOIN
                  subjects s ON s.subject_id = c.subject_id
                INNER JOIN
                  subtopics sub on sub.subtopic_id = c.subtopic_id
                WHERE
                  c.content_id = ?
                LIMIT 0,1';
          
      $statement = $this->conn->prepare($query);
      $statement->bindParam(1, $this->id);
      $statement->execute();

      $row = $statement->fetch(PDO::FETCH_ASSOC);
      $this->content_id = $row['content_id'];
      $this->subject = $row['subject_name'];
      $this->subtopic = $row['subtopic_name'];
      $this->title = $row['content_title'];
      $this->body = $row['content_body'];
      $this->createdAt = $row['created_at'];
    }
  }
?>