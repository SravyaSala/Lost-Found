<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lostandfound";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts
$sql = "SELECT title, description, category, image_path FROM found_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="images/logoImag.jpg" rel="icon">  
    <title>Findit: My Posts</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f9;
        }
        header {
            background-color: #009999;
            padding: 15px 20px;
            color: white;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            font-size: 20px;
        }
        main {
            margin-top: 70px;
            padding: 20px;
        }
        .item-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .item-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            overflow: hidden;
            text-align: center;
            position: relative;
            padding-bottom: 50px;
        }
        .item-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .item-card h3, .item-card p {
            margin: 10px;
            font-size: 16px;
        }
        .item-card .delete-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
        }
        .item-card .delete-btn:hover {
            background-color: #d62828;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #009999;
            color: white;
            transition: left 0.3s ease;
            z-index: 2000;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px 0;
            background-color: #009999;
            text-align: center;
        }
        .sidebar a:hover {
            background-color: #008080;
        }
        .toggle-sidebar-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #009999;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            z-index: 3000;
        }
        .toggle-sidebar-btn:hover {
            background-color: #008080;
        }
    </style>
</head>
<body>

<header>Findit: Lost and Found Platform</header>
<button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar">
    <h2>Options</h2>
    <a href="homePage.php">All Posts</a>
    <a href="#" onclick="logout()">Log Out</a>
</div>

<main>
    <h1 id="my-posts">My Posts</h1>
    <div class="item-gallery">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Get the correct image path from the database
                $imagePath = htmlspecialchars($row["image_path"]);

                // Ensure the path is valid
                if (!file_exists($imagePath) || empty($row["image_path"])) {
                    $imagePath = "images/default.jpg";  // Placeholder image
                }

                echo "
                <div class='item-card'>
                    <img src='$imagePath' onerror=\"this.src='images/default.jpg';\" alt='Item image'>
                    <h3>" . htmlspecialchars($row["title"]) . "</h3>
                    <p><strong>Category:</strong> " . htmlspecialchars($row["category"]) . "</p>
                    <p>" . htmlspecialchars($row["description"]) . "</p>
                    <form method='post' action='delete_post.php' onsubmit='return confirm(\"Are you sure you want to delete this post?\");'>
                        <input type='hidden' name='image_path' value='" . htmlspecialchars($row["image_path"]) . "'>
                        <button class='delete-btn' type='submit'>Delete</button>
                    </form>
                </div>";
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        $conn->close();
        ?>
    </div>
</main>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.style.left = sidebar.style.left === '0px' ? '-250px' : '0px';
    }

    function logout() {
        window.location.href = 'login2.php';
    }
</script>

</body>
</html>
