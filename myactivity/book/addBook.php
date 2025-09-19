<?php 
    require_once "../classes/book.php";
    $bookObj = new Book();

    $book = ["title"=>"","author"=>"","genre"=>"","publication_year"=>""];
    $errors = ["title"=>"","author"=>"","genre"=>"","publication_year"=>""];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $book["title"] = trim(htmlspecialchars($_POST["title"]));
        $book["author"] = trim(htmlspecialchars($_POST["author"]));
        $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
        $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

        if(empty($book["title"])){
            $errors["title"] = "Title is required.";
        }
        
        if(empty($book["author"])){
            $errors["author"] = "Author is required.";
        }

        if(empty($book["genre"])){
            $errors["genre"] = "Please select a genre.";
        }

        if(empty($book["publication_year"])){
            $errors["publication_year"] = "Publication year is required.";
        } elseif(!is_numeric($book["publication_year"])){
            $errors["publication_year"] = "Publication year must be numeric.";
        } elseif ($book["publication_year"] > date("Y")){
            $errors["publication_year"] = "Publication year cannot be in the future.";
        }

        if(empty(array_filter($errors))){
            $bookObj->title = $book["title"];
            $bookObj->author = $book["author"];
            $bookObj->genre = $book["genre"];
            $bookObj->publication_year = $book["publication_year"];

            if($bookObj->addBook()){
                header("location: viewBook.php");
            } else {
                 $errors["title"] = "This book title already exists.";
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
        * {box-sizing: border-box; margin: 0; padding: 0;}
        label {display: block}
        span, .error {color: red; margin: 0;}
        body {font-family: Verdana, Geneva, Tahoma, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4; }
        .container {display:flex; flex-direction: column; justify-content: center; align-items: center;  background: white; padding: 20px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px;}
        label, input, select {margin-bottom: 10px; width: 100%; }
        input, select {padding: 8px; border: 1px solid #ccc; border-radius: 5px;}
        input[type="submit"] {background: #28a745; color: white; border: none; cursor: pointer; transition: background 0.3s ease;}
        input[type="submit"]:hover {background: #218838;}
        h1 {margin-bottom: 20px;}
        form {width: 100%;}   
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Book</h1>
        <form action="" method="post">
            <label for="">Field with <span>*</span> is required</label>
            <br>
            <label for="title">Book Title <span>*</span></label>
            <input type="text" name="title" id="title" value="<?= $book["title"] ?>">
            <p class="error"><?= $errors["title"] ?></p>
            <br>

            <label for="author">Book Author<span>*</span></label>
            <input type="text" name="author" id="author" value="<?= $book["author"] ?>">
            <p class="error"><?= $errors["author"] ?></p>
            <br>

            <label for="genre">Book Genre<span>*</span></label>
            <select name="genre" id="genre">
                <option value="">---Select Genre---</option>
                <option value="History" <?= ($book["genre"] == "History") ? "selected": "" ?>>History</option>
                <option value="Science" <?= ($book["genre"] == "Science") ? "selected": "" ?>>Science</option>
                <option value="Fiction" <?= ($book["genre"] == "Fiction") ? "selected": "" ?>>Fiction</option>
            </select>
            <p class="error"><?= $errors["genre"] ?></p>
            <br>

            <label for="publication_year">Publication Year<span>*</span></label>
            <input type="text" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
            <p class="error"><?= $errors["publication_year"] ?></p>
            <br>
            <input type="submit" value="Save Book">
        </form>
    </div>
</body>
</html>