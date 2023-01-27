<?php

// Connect to the database
$db = new PDO('sqlite:db/weblog.sqlite3');

// Get the post_id from the query string
$post_id = $_GET['post_id'];

// Fetch the post and comment
$post_stmt = $db->prepare('SELECT posts.*, comments.id as comment_id, comments.author as comment_author, comments.body as comment_body FROM posts JOIN comments ON posts.id = comments.post_id WHERE posts.id = :post_id;');
$post_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
$post_stmt->execute();
$results = $post_stmt->fetchAll();

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Sanitize the user's input
    $body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);
    $author = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    // Insert the new comment into the database
    $stmt = $db->prepare('INSERT INTO comments (post_id, body, author) VALUES (:post_id, :body, :author)');
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
    $stmt->bindValue(':author', $author, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect the user back to the post
    header('Location: weblog-hw.php?id=#' . $post_id);
    exit;
}

?>
<html>
<head>
  <title>Leave a Comment</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
  <h1>RC's Web Journal</h1>
  <div class="leave-comment">
    <h2>
      Leave a Comment on
      <a href="weblog-hw.php#<?php echo $post_id; ?>"><?php echo $results[0]['title']; ?></a>
    </h2>

    <div class="post-body">
      <?php echo $results[0]['body']; ?>
    </div>

    <h3><?php echo count($results); ?> Comments</h3>
    <div class="comment-block">
      <?php foreach ($results as $result): ?>
        <div class="comment">
          <div class="comment-body">
            <?php echo $result['comment_body']; ?>
          </div>
          <div class="comment-author">
            <?php echo $result['comment_author']; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <form method="post">
      <label for="body">Comment</label>
      <textarea name="body"></textarea>
      <label for="name">Your name</label>
      <input name="name"></input>
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"></input>
      <input type="submit" name="submit" value="Leave Comment"></input>
    </form>
  </div>
</body>
</html>