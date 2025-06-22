<?php
session_start();

if(!isset($_SESSION['userid'])){
  header("Location: login.php");
  exit();
}

require_once "db.php";
$userid = $_SESSION['userid'];
$userrole = $_SESSION['userrole'];

if ($userrole === 'admin') {
    $sql = "SELECT * FROM posts ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM posts WHERE author_id='$userid' ORDER BY id DESC";
}
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./dashboard.css">
  <title>Dashboard</title>
</head>
<body>
  <header class="medium-header">
    <div class="medium-header-left">
      <span class="medium-logo">Blog Dashboard</span>
      <span class="medium-username-sub" id="userNameSub"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
    <div class="medium-user-menu">
      <button class="user-icon" id="userIconBtn"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></button>
      <div class="user-dropdown" id="userDropdown">
        <a href="displaypost.php">Back to Posts</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </header>
  <main class="dashboard-main">
    <div class="dashboard-main-header">
      <h2>All Posts</h2>
      <div style="display: flex; gap: 12px; align-items: center;">
        <?php if ($userrole === 'admin') { ?>
          <a href="addcategory.php" class="dashboard-category-btn">+ Add Category</a>
        <?php } else { ?>
          <a href="insertPost.php" class="dashboard-newpost-btn">+ New Post</a>
        <?php } ?>
      </div>
    </div>
    <div class="dashboard-posts-grid">
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="dashboard-post-card">
          <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" class="dashboard-post-image">
          <div class="dashboard-post-info">
            <div class="dashboard-post-title"><?php echo htmlspecialchars($row['tittle']); ?></div>
            <div class="dashboard-post-date"><?php echo date('F j, Y', strtotime($row['created_at'] ?? 'now')); ?></div>
            <?php if ($userrole === 'admin') { ?>
              <a href="deletepost.php?post_id=<?php echo $row['id']; ?>" class="dashboard-delete-btn">Delete</a>
            <?php } elseif ($userrole === 'author' && $row['author_id'] == $userid) { ?>
              <a href="updatepost.php?post_id=<?php echo $row['id']; ?>" class="dashboard-view-btn">Update</a>
              <a href="deletepost.php?post_id=<?php echo $row['id']; ?>" class="dashboard-delete-btn">Delete</a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
  <?php include "footer.php"; ?>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const userIconBtn = document.getElementById('userIconBtn');
      const userDropdown = document.getElementById('userDropdown');
      if(userIconBtn) {
          userIconBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              userDropdown.classList.toggle('show');
          });
      }
      document.addEventListener('click', function() {
          userDropdown.classList.remove('show');
      });
  });
  </script>
</body>
</html>