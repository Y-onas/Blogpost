<?php 
session_start();
require "db.php";
echo '<link rel="stylesheet" type="text/css" href="./display.css">';
echo '<link rel="stylesheet" type="text/css" href="./addPost.css">';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <header class="medium-header">
        <div class="medium-header-left">
            <span class="medium-logo">BlogPost</span>
            <span class="medium-username-sub" id="userNameSub"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <div class="medium-user-menu">
            <button class="user-icon" id="userIconBtn"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></button>
            <div class="user-dropdown" id="userDropdown">
                <?php if ($_SESSION['userrole'] !== 'subscriber') { ?>
                    <a href="dashboard.php">Dashboard</a>
                <?php } ?>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <?php
    $sql="SELECT * FROM posts";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        echo "<div class='post-container'>";
        echo "<a class='post-title' href='viewpost.php?post_id={$row['id']}'>" . htmlspecialchars($row['tittle']) . "</a>";
        echo "<div class='post-content'>" . nl2br(htmlspecialchars($row['content'])) . "</div>";
        echo "<img class='post-image' src='images/" . htmlspecialchars($row['image']) . "' alt='Post Image'>";
        echo "<span class='show-comments-btn' style='margin-top:10px;'><a href='viewpost.php?post_id={$row['id']}' style='text-decoration:none;color:inherit;display:flex;align-items:center;gap:6px;'><span class='comment-icon'>&#128172;</span> Comments</a></span>";
        echo "</div>";
    }
    ?>
</body>
</html>

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

<script>
function toggleComments(id) {
  var el = document.getElementById(id);
  if (el.style.display === 'none') {
    el.style.display = 'block';
  } else {
    el.style.display = 'none';
  }
}
</script>