<?php
session_start();
 require "db.php";
if(!isset($_SESSION['userid'])){
    header("Location : login.php");
}
else{
    if($_SESSION['userrole']=='admin'){
        if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit'])){
            $category_name = $_POST['category_name'];
            $sql = "INSERT INTO categories(name) VALUES ('$category_name')";
            $result = mysqli_query($conn, $sql);
            if(!$result){
                $messageBox= true;
                $messageType = 'error';
                $messageTitle = 'Error';
                $messageText = 'Failed to add category: ' . mysqli_error($conn);
                
            } else {
                $messageBox = true;
                $messageType= 'success';
                $messageTitle = 'Success';
                $messageText = 'Category added successfully.';
               
            }
        }
       
 
    }
    else{
        header("Location: dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./addcategory.css">
    <link rel="stylesheet" href="./message.css">
    <title>Add Category</title>
</head>
<body>
    <header class="category-header">
        <div class="category-header-left">
            <span class="category-logo">Add Category</span>
            <span class="category-username-sub" id="userNameSub"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <div class="category-user-menu">
            <button class="category-user-icon" id="userIconBtn"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></button>
            <div class="category-user-dropdown" id="userDropdown">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <main class="category-main">
        <form action="addcategory.php" method="POST" class="category-form">
            <input type="text" name="category_name" id="category_name" class="category-input" placeholder="Category Name" required>
            <button type="submit" name="submit" class="category-btn">Add Category</button>
        </form>
    </main>
    <?php include 'message-box.php'; ?>
    <?php include 'footer.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // User dropdown
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