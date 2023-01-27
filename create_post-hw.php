<?php
$password = "punpernickel";

// In PHP, the double equal sign (==) is also used to compare values to check if they are equal. It will return TRUE if the values on both sides of the operator are equal and FALSE if they are not.

if (isset($_POST["submit"])) {
  if ($_POST["password"] === $password) {
    $title = $_POST["title"];
    $body = $_POST["body"];

    $db = new SQLite3('db/weblog.sqlite3');
    $stmt = $db->prepare("INSERT INTO posts (title, body) VALUES (:title, :body)");
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':body', $body);
    $stmt->execute();
    $last_id = $db->lastInsertRowID();

    header("Location: weblog-hw.php#{$last_id}");
    exit;
  } else {
    echo "Incorrect password. Access denied.";
  }
}
?>
<html>

<head>
  <title>Create a Post</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
  <h1>RC's Web Journal</h1>
  <div class="create-post">
    <h2>Create a Post</h2>
    <form method="post">
      <label for="title">Title</label>
      <input name="title"></input>
      <!-- textarea is an HTML element that is used to create a multi-line input field for text input. It is typically used for longer pieces of text such as a blog post or message. -->
      <label for="body">Post Body</label>
      <textarea name="body"></textarea>
      <label for="password">Secret Password</label>
      <input type="password" name="password"></input>
      <input type="submit" name="submit" value="Create Post"></input>
    </form>
  </div>
</body>

</html>