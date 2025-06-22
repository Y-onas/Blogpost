<?php
session_start();
$user_id = $_SESSION['userid'];
require "db.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SESSION['userrole'] == 'author') {
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $tittle = mysqli_real_escape_string($conn, $_POST['Tittle']);
                $content = mysqli_real_escape_string($conn, $_POST['Content']);
                $category_name = mysqli_real_escape_string($conn, $_POST['category']);

                $name = $_FILES['image']['name'];
                $temp_location = $_FILES['image']['tmp_name'];
                $our_location = "images/";

                if (!empty($name)) {
                    move_uploaded_file($temp_location, $our_location . $name);
                }

                $sql1 = "SELECT id FROM categories WHERE name='$category_name'";
                $result1 = mysqli_query($conn, $sql1);

                if (!$result1) {
                    echo "Error: " . mysqli_error($conn);
                    exit();
                } else {
                    if (mysqli_num_rows($result1) > 0) {
                        $row1 = mysqli_fetch_assoc($result1);
                        $category_id = $row1['id'];
                    }

                    $sql2 = "INSERT INTO posts (tittle, content, category_id, author_id, image) 
                             VALUES ('$tittle', '$content', '$category_id', '$user_id', '$name')";
                    $result2 = mysqli_query($conn, $sql2);

                    if (!$result2) {
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    } else {
                        $_SESSION['messageBox'] = true;
                        $_SESSION['messageType'] = 'success';
                        $_SESSION['messageTitle'] = 'Post Added';
                        $_SESSION['messageText'] = 'Your post has been added successfully.';
                        header("Location: dashboard.php");
                        exit();

                    }
                }
            }
        }
    } else {
        header("Location: dashboard.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./addPost.css">
    <link rel="stylesheet" href="./message.css">
    <title>Document</title>
</head>
<body>
    <header class="medium-header">
        <div class="medium-header-left">
            <span class="medium-logo">Add Post</span>
            <span class="medium-username-sub" id="userNameSub"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <div class="medium-user-menu">
            <button class="user-icon" id="userIconBtn"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></button>
            <div class="user-dropdown" id="userDropdown">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    <main class="medium-main">
        <form action="insertPost.php" method="POST" enctype="multipart/form-data" class="medium-form">
            <textarea name="Tittle" id="Tittle" class="medium-title" placeholder="Title" rows="1" required></textarea>
            <textarea name="Content" id="Content" class="medium-content" placeholder="Tell your story..." required></textarea>
            <div class="medium-form-row">
                <select name="category" id="Category" class="medium-category" required>
                    <?php while($row = mysqli_fetch_assoc($result)){?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
                <label for="Image" class="medium-image-btn" id="imageLabel">Choose Image <span id="imageName"></span></label>
                <input type="file" name="image" id="Image" accept="image/*" class="medium-image-input" required>
            </div>
            <button type="submit" name="submit" class="medium-publish">Add Post</button>
        </form>
    </main>
    <?php include 'message-box.php'; ?>
    <?php include 'footer.php'; ?>
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

        // Auto-expand textarea for content
        const contentArea = document.getElementById('Content');
        if(contentArea) {
            contentArea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            contentArea.style.height = 'auto';
            contentArea.style.height = (contentArea.scrollHeight) + 'px';
        }
        // Auto-expand textarea for title
        const titleArea = document.getElementById('Tittle');
        if(titleArea) {
            titleArea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            titleArea.style.height = 'auto';
            titleArea.style.height = (titleArea.scrollHeight) + 'px';
        }

        // Show selected image file name
        const imageInput = document.getElementById('Image');
        const imageLabel = document.getElementById('imageLabel');
        const imageName = document.getElementById('imageName');
        if(imageInput && imageLabel && imageName) {
            imageInput.addEventListener('change', function() {
                if(this.files && this.files[0]) {
                    imageName.textContent = this.files[0].name;
                } else {
                    imageName.textContent = '';
                }
            });
        }
    });
    </script>
</body>
</html> 