<?php
$password = "punpernickel";

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
      <label for="body">Post Body</label>
      <textarea name="body"></textarea>
      <label for="password">Secret Password</label>
      <input type="password" name="password"></input>
      <input type="submit" name="submit" value="Create Post"></input>
    </form>
  </div>
</body>
</html>
