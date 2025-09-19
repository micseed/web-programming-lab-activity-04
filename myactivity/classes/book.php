<?php
    require_once "database.php";

    class Book{
        public $id = "";
        public $title = "";
        public $author = "";
        public $genre = "";
        public $publication_year = "";

        protected $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function addBook(){
            $check = "SELECT * FROM book WHERE title = :title";
            $query = $this->db->connect()->prepare($check);
            $query->bindParam(":title", $this->title);
            $query->execute();
            if($query->rowCount() > 0){
                return false;
            }

            $sql = "INSERT INTO book (title, author, genre, publication_year) VALUE (:title, :author, :genre, :publication_year)";
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(":title", $this->title);
            $query->bindParam(":author", $this->author);
            $query->bindParam(":genre", $this->genre);
            $query->bindParam(":publication_year", $this->publication_year);

            return $query->execute();
        }

        public function viewBook(){
            $sql = "SELECT * FROM book ORDER BY title ASC";
            $query = $this->db->connect()->prepare($sql);

            if ($query->execute()) {
                return $query->fetchAll();
            } else {
                return null;
            }
        }

        public function getGenres() {
            $sql = "SELECT DISTINCT genre FROM book ORDER BY genre ASC";
            $query = $this->db->connect()->prepare($sql);

            if ($query->execute()) {
                return $query->fetchAll(PDO::FETCH_COLUMN);
            } else {
                return [];
            }
        }

        public function searchByGenreAndKeyword($genre, $keyword) {
            $sql = "SELECT * FROM book WHERE genre = :genre AND (title LIKE :keyword OR author LIKE :keyword) ORDER BY title ASC";
            $query = $this->db->connect()->prepare($sql);
            $likeKeyword = '%' . $keyword . '%';
            $query->bindParam(":genre", $genre);
            $query->bindParam(":keyword", $likeKeyword);

            if ($query->execute()) {
                return $query->fetchAll();
            } else {
                return null;
            }
        }

        public function searchByKeyword($keyword) {
            $sql = "SELECT * FROM book 
                WHERE title LIKE :keyword OR author LIKE :keyword 
                ORDER BY title ASC";
            $query = $this->db->connect()->prepare($sql);
            $likeKeyword = '%' . $keyword . '%';
            $query->bindParam(":keyword", $likeKeyword);

            if ($query->execute()) {
                return $query->fetchAll();
            } else {
                return [];
            }
        }

    }