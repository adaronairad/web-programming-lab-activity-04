<?php

class Database {
    // Database connection properties
    private $host = "localhost";       // Host (local server)
    private $username = "root";        // Default MySQL username in XAMPP
    private $password = "";            // Default MySQL password (blank in XAMPP)
    private $dbname = "activity_4";    // Database name for this project

    // Property to hold the PDO object
    protected $conn;

    // Method to connect to the database
    public function connect() {
        try {
            // Create a new PDO instance
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                $this->username,
                $this->password
            );

            // Set error mode to exception for better debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn; // return the connection
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }
}

// Example usage:
// $db = new Database();
// var_dump($db->connect()); // Shows PDO object if successful
