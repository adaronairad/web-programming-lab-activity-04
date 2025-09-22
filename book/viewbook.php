<?php
require_once "../classes/book.php";
$bookObj = new Book();

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : "";

$books = $bookObj->viewBooks($search, $genre);
$genres = $bookObj->getGenres();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h1>Book List</h1>
    <button><a href="addbook.php">Add Book</a></button>

    <form method="GET" action="viewbook.php">
        <input type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>">

        <select name="genre">
            <option value="">All Genres</option>
            <?php foreach($genres as $g): ?>
                <option value="<?= htmlspecialchars($g['genre']) ?>" <?= $genre == $g['genre'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($g['genre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Search</button>
    </form>

    <br>

    <table border=1 cellpadding="5" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
        </tr>
        <?php
        if (!empty($books)) {
            $no = 1;
            foreach ($books as $book) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($book["title"]) ?></td>
            <td><?= htmlspecialchars($book["author"]) ?></td>
            <td><?= htmlspecialchars($book["genre"]) ?></td>
            <td><?= htmlspecialchars($book["publication_year"]) ?></td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5'>No books found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
