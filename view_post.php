<?php
require_once 'connection.php';
include_once 'connection.php';
include 'header.php';
$mysqli = getDBConnection();


$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { $_SESSION['flash_error']='Invalid post.'; header('Location:index.php'); exit; }

$stmt = $mysqli->prepare("SELECT b.blog_id,b.title,b.content,b.created_at,b.user_user_id,u.username FROM blogPost b JOIN user u ON b.user_user_id = u.user_id WHERE b.blog_id = ?");
$stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result();
if ($res->num_rows === 0) { $_SESSION['flash_error']='Post not found.'; header('Location:index.php'); exit; }
$post = $res->fetch_assoc(); $stmt->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MyBlog - <?= htmlspecialchars($post['title']) ?></title>
   <img src="img/myblog-logo.svg" alt="Site Logo" class="img-fluid" style="height: 50px;">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
  <article class="card p-4 view-post-card blog-area">

    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p class="text-muted small">By <?= htmlspecialchars($post['username']) ?> • <?= $post['created_at'] ?></p>

    <div id="rendered" class="mt-4 mb-3 border p-3 rounded bg-white"></div>

    <div class="mt-3">
      <?php if (!empty($_SESSION['user']) && $_SESSION['user']['id'] === (int)$post['user_user_id']): ?>
        <a href="edit_post.php?id=<?= $post['blog_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete_post.php?id=<?= $post['blog_id'] ?>" class="btn btn-danger btn-sm" id="deleteBtn">Delete</a>
      <?php endif; ?>
      <a href="index.php" class="btn btn-outline-primary btn-sm">Back</a>
    </div>
  </article>
</main>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const raw = <?php echo json_encode($post['content']); ?>;
  document.getElementById('rendered').innerHTML = marked.parse(raw);

  const deleteBtn = document.getElementById('deleteBtn');
  if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e){
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title:'Delete post?',
        text:'This action cannot be undone.',
        icon:'warning',
        showCancelButton:true, 
        confirmButtonColor:'#d33',
        confirmButtonText:'Delete'
      }).then(result=>{
        if (result.isConfirmed) window.location = href;
      });
    });
  }
});
</script>
</body>
</html>







