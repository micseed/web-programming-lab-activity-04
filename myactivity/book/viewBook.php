<?php
require_once "../classes/book.php";
$bookObj = new Book();

$genres = $bookObj->getGenres();
$books = $bookObj->viewBook(); 
$genre = "";
$keyword = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $genre = $_POST['genre'] ?? '';
    $keyword = $_POST['keyword'] ?? '';

    if (!empty($genre)) {
        $books = $bookObj->searchByGenreAndKeyword($genre, $keyword);
    } elseif (!empty($keyword)) {
        $books = $bookObj->searchByKeyword($keyword);
    } else {
        $books = $bookObj->viewBook();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <style>
        * {box-sizing: border-box; margin: 0; padding: 0;}
        body {font-family: Verdana, Geneva, Tahoma, sans-serif; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; background: #f4f4f4;}
        .container {display:flex; flex-direction: column; justify-content: center; align-items: center; background: white; padding: 20px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 1000px;}
        h1 {margin-bottom: 20px;}
        table {width: 100%; border-collapse: collapse;}
        th, td {padding: 10px; text-align: left;}
        th {background: #007BFF; color: white;}
        tr:nth-child(even) {background: #f2f2f2;}
        button, input[type="submit"] {padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; margin: 5px;}
        button:hover, input[type="submit"]:hover {background: #218838;}
        a {color: white; text-decoration: none;}
        table, th, td {border: 1px solid #ddd;}
        form {margin-bottom: 20px;}
        select, input[type="text"] {padding: 8px; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc;}
        .group {display: flex; align-items: center; flex-wrap: wrap; gap: 10px;}
    </style>
</head>
<body>
    <div class="container">
        <h1>View & Search Books</h1>

        <form method="POST" action="">
            <div class="group">
                <label for="genre">Select Genre:</label>
                <select name="genre" id="genre">
                    <option value="">-- All Genres --</option>
                    <?php foreach ($genres as $g): ?>
                        <option value="<?= htmlspecialchars($g) ?>" <?= ($g === $genre) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="keyword">Keyword:</label>
                <input type="text" name="keyword" id="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Enter title or author">

                <input type="submit" value="Search">

                <button><a href="addBook.php">Add New Book</a></button>
            </div>
        </form>

        <table>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Publication Year</th>
            </tr>

            <?php if (!empty($books)): ?>
                <?php $no = 1; ?>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($book["title"]) ?></td>
                        <td><?= htmlspecialchars($book["author"]) ?></td>
                        <td><?= htmlspecialchars($book["genre"]) ?></td>
                        <td><?= htmlspecialchars($book["publication_year"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No books found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
