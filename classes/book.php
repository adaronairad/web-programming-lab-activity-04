<?php
require_once "database.php";

class Book {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";

    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add new book
    public function addBook() {
        $sql = "INSERT INTO book (title, author, genre, publication_year) 
                VALUES (:title, :author, :genre, :publication_year)";
        $stmt = $this->db->connect()->prepare($sql);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":publication_year", $this->publication_year);

        return $stmt->execute();
    }

    // View with optional search + filter
    public function viewBooks($search = "", $genre = "") {
        $sql = "SELECT * FROM book WHERE 1";

        if (!empty($search)) {
            $sql .= " AND title LIKE :search";
        }

        if (!empty($genre)) {
            $sql .= " AND genre = :genre";
        }

        $stmt = $this->db->connect()->prepare($sql);

        if (!empty($search)) {
            $stmt->bindValue(":search", "%$search%");
        }
        if (!empty($genre)) {
            $stmt->bindValue(":genre", $genre);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Distinct genres for dropdown
    public function getGenres() {
        $sql = "SELECT DISTINCT genre FROM book";
        $stmt = $this->db->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
