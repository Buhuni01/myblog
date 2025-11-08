<?php
require_once 'connection.php';
include_once 'connection.php';
$mysqli = getDBConnection();
session_start();
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) { $_SESSION['flash_error']='Please sign in.'; header('Location: signIn.php'); exit; }

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { $_SESSION['flash_error']='Invalid post.'; header('Location:index.php'); exit; }

$stmt = $mysqli->prepare("SELECT blog_id,title,content,user_user_id FROM blogPost WHERE blog_id = ?");
$stmt->bind_param('i',$id); $stmt->execute(); $res=$stmt->get_result();
if ($res->num_rows === 0) { $_SESSION['flash_error']='Post not found.'; header('Location:index.php'); exit; }
$post = $res->fetch_assoc(); $stmt->close();

if ($post['user_user_id'] !== $_SESSION['user']['id']) { $_SESSION['flash_error']='Not authorized.'; header('Location:index.php'); exit; }

include 'header.php';

// handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');
  if ($title === '' || $content === '') { $_SESSION['flash_error']='All fields required.'; header("Location: edit_post.php?id=$id"); exit; }
  $stmt = $mysqli->prepare("UPDATE blogPost SET title=?, content=? WHERE blog_id=?");
  $stmt->bind_param('ssi', $title, $content, $id);
  if ($stmt->execute()) { $_SESSION['flash_success']='Post updated.'; header('Location: view_post.php?id='.$id); exit; }
  else { $_SESSION['flash_error']='Update failed.'; header("Location: edit_post.php?id=$id"); exit; }
}
?> 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MyBlog - Edit Post</title>
   <img src="img/myblog-logo.svg" alt="Site Logo" class="img-fluid" style="height: 50px;">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
  <div class="card p-4">
    <h3>Edit Post</h3>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea id="mdContent" name="content" rows="10" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-gold">Update</button>
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
