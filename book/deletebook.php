<?php
require_once "../classes/book.php";
$bookObj = new Book();

// Check if ID exists and is valid
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $bookId = intval($_GET["id"]);

    if ($bookObj->deleteBook($bookId)) {
        // Redirect with success message
        header("Location: viewbook.php?msg=Book deleted successfully");
        exit;
    } else {
        // Redirect with failure message
        header("Location: viewbook.php?msg=Failed to delete book");
        exit;
    }
} else {
    // Redirect with invalid request message
    header("Location: viewbook.php?msg=Invalid book ID");
    exit;
}
?>
