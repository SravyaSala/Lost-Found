<?php
session_start();
 // Make sure this connects to your DB
 $conn = mysqli_connect("localhost", "root", "", "lostandfound");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "John Doe";
    $_SESSION['email'] = "johndoe@campus.com";
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Fetch items from database
$items = [];
$sql = "SELECT * FROM found_items";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Findit: Dashboard</title>
    <link rel="icon" href="images/logoImag.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ... same styles as you already have ... */
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
        .top-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 70px;
            padding: 20px;
            gap: 40px;
        }
        .top-section img {
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .action-buttons button {
            padding: 12px 24px;
            font-size: 16px;
            color: white;
            background-color: #009999;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-buttons button:hover {
            background-color: #007777;
        }
        main {
            margin-top: 20px;
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
        }
        .item-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .item-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .item-card p {
            margin: 0 10px 10px;
            font-size: 14px;
            color: #555;
        }
        .dashboard {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background-color: #009999;
            color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: left 0.3s ease;
            z-index: 2000;
            padding: 20px;
            box-sizing: border-box;
        }
        .dashboard h2 {
            margin: 0 0 20px;
        }
        .dashboard p {
            margin: 0 0 10px;
        }
        .dashboard-options {
            margin-top: 30px;
        }
        .dashboard-options button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background-color: #f4f4f9;
            color: #009999;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .dashboard-options button:hover {
            background-color: #cfdef3;
        }
        .toggle-dashboard {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #009999;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 18px;
            z-index: 3000;
        }
        .toggle-dashboard:hover {
            background-color: #007777;
        }
    </style>
</head>
<body>

<header>
    Findit: Lost and Found Platform
</header>

<div class="top-section">
    <img src="https://img.freepik.com/free-vector/detective-following-footprints-concept-illustration_114360-21835.jpg" alt="Platform Logo">
    <div class="action-buttons">
        <a href="postPage.php"><button>Add Lost Item</button></a>
        <a href="postPage.php"><button>Add Found Item</button></a>
    </div>
</div>

<button class="toggle-dashboard" onclick="toggleDashboard()">☰</button>

<div class="dashboard" id="dashboard">
    <h2>User Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <div class="dashboard-options">
        <a href="myposts.php"><button>My Posts</button></a>
        <a href="searchPage.php"><button>Search for Lost Item</button></a>
        <a href="login2.php"><button>Logout</button></a>
    </div>
</div>

<main>
    <h1>Recently Posted Items</h1>
    <div class="item-gallery">
        <?php foreach ($items as $item): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Item Image">
                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Category: <?php echo htmlspecialchars($item['category']); ?></p>
                <p>Status: <?php echo htmlspecialchars($item['status']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    function toggleDashboard() {
        const dashboard = document.getElementById('dashboard');
        dashboard.style.left = (dashboard.style.left === '0px') ? '-300px' : '0px';
    }
</script>

</body>
</html>
