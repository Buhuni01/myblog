<?php
require_once 'connection.php';
include_once 'connection.php';
$mysqli = getDBConnection();
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { $_SESSION['flash_error']='Please sign in.'; header('Location: signIn.php'); exit; }

include 'header.php';

// handle POST (if present)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');
  if ($title === '' || $content === '') {
    $_SESSION['flash_error'] = 'Title and content required.';
    header('Location: create_post.php'); exit;
  }
  $stmt = $mysqli->prepare("INSERT INTO blogPost (user_user_id,title,content) VALUES (?, ?, ?)");
  $stmt->bind_param('iss', $_SESSION['user']['id'], $title, $content);
  if ($stmt->execute()) {
    $_SESSION['flash_success'] = 'Post created.';
    header('Location: index.php'); exit;
  } else {
    $_SESSION['flash_error'] = 'Unable to create post.';
    header('Location: create_post.php'); exit;
  }
}
?> 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MyBlog - Create Post</title>
   <img src="img/myblog-logo.svg" alt="Site Logo" class="img-fluid" style="height: 50px;">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
  <div class="card p-4 view-post-card">

    <h3>Create New Blog</h3>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Content (Markdown)</label>
        
        <textarea id="mdContent" name="content" rows="10" class="form-control"></textarea>

      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-gold">Publish</button>
      </div>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script src="script.js"></script>

</body>
</html>
