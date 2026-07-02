<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lostandfound";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, description, category, contact FROM found_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="images/logoImag.jpg" rel="icon">  
    <title>Campus Lost and Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #009999;
            color: black;
            padding: 15px;
            text-align: center;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        .item-list {
            list-style-type: none;
            padding: 0;
        }
        .item {
            padding: 10px;
            background-color: #f9f9f9;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }
        .item h3 {
            margin: 0;
            font-size: 18px;
        }
        .item p {
            margin: 5px 0;
            color: #555;
            display: none;
        }
        .button {
            padding: 10px 20px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .button:hover {
            background-color: #009999;
        }
    </style>
</head>
<body>
    <header>
        <h1>Campus Lost and Found</h1>
        <p>Search for Lost or Found Items</p>
        <a href="homePage.php" class="button">Go to Home</a>
    </header>

    <div class="container">
        <input type="text" id="searchInput" onkeyup="searchItems()" placeholder="Search for items...">
        <ul id="itemList" class="item-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='item' onclick='toggleDetails(this)'>
                            <h3>" . htmlspecialchars($row['title']) . "</h3>
                            <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                            <p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>
                            
                            <p><strong>Contact:</strong> " . htmlspecialchars($row['contact']) . "</p>
                          </li>";
                }
            } else {
                echo "<p>No items posted yet.</p>";
            }
            $conn->close();
            ?>
        </ul>
    </div>

    <script>
        function searchItems() {
            var input, filter, list, items, item, h3, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            list = document.getElementById('itemList');
            items = list.getElementsByClassName('item');

            for (i = 0; i < items.length; i++) {
                item = items[i];
                h3 = item.getElementsByTagName('h3')[0];
                if (h3) {
                    txtValue = h3.textContent || h3.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        item.style.display = "";
                    } else {
                        item.style.display = "none";
                    }
                }
            }
        }

        function toggleDetails(item) {
            var details = item.getElementsByTagName('p');
            for (var i = 0; i < details.length; i++) {
                details[i].style.display = (details[i].style.display === "none" || details[i].style.display === "") ? "block" : "none";
            }
        }
    </script>
</body>
</html>
