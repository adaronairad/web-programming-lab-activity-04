<?php
require_once "../classes/book.php";
$bookObj = new Book();

$book = ["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];
$errors = ["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

    // Validation
    if (empty($book["title"])) {
        $errors["title"] = "Title is required";
    }
    if (empty($book["author"])) {
        $errors["author"] = "Author is required";
    }
    if (empty($book["genre"])) {
        $errors["genre"] = "Please select a genre";
    }
    if (empty($book["publication_year"])) {
        $errors["publication_year"] = "Publication year is required";
    } elseif (!is_numeric($book["publication_year"])) {
        $errors["publication_year"] = "Publication year must be a number";
    } elseif ($book["publication_year"] > date("Y")) {
        $errors["publication_year"] = "Publication year cannot be in the future";
    }

    // If no errors
    if (empty(array_filter($errors))) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];

        if ($bookObj->addBook()) {
            header("Location: viewbook.php");
            exit;
        } else {
            echo "Error saving book.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label{ display: block; margin-top: 10px; }
        span{ color: red; }
        p.error{ color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <label>Fields with <span>*</span> are required</label>
    <form action="" method="post">
        <label for="title">Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= $book["title"] ?>">
        <p class="error"><?= $errors["title"] ?></p>

        <label for="author">Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= $book["author"] ?>">
        <p class="error"><?= $errors["author"] ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select--</option>
            <option value="History" <?= ($book["genre"] == "History")? "selected":"" ?>>History</option>
            <option value="Science" <?= ($book["genre"] == "Science")? "selected":"" ?>>Science</option>
            <option value="Fiction" <?= ($book["genre"] == "Fiction")? "selected":"" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="publication_year">Publication Year <span>*</span></label>
        <input type="number" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
        <p class="error"><?= $errors["publication_year"] ?></p>

        <br><br>
        <input type="submit" value="Save Book">
    </form>
</body>
</html>
