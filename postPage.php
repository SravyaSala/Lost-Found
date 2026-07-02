<?php
$host = "localhost";
$dbname = "lostandfound";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];
    $founder_name = $_POST["founder_name"];
    $title = $_POST["title"];
    $status = $_POST["status"];
    $contact = $_POST["contact"];
    $description = $_POST["description"];

    // Handle file upload
    $target_dir = "uploads/";
    $image_path = "";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES["item_image"]) && $_FILES["item_image"]["error"] == 0) {
        $filename = basename($_FILES["item_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $message = "Failed to upload image.";
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO found_items (category, founder_name, title, status, contact, description, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $category, $founder_name, $title, $status, $contact, $description, $image_path);

    if ($stmt->execute()) {
        $message = "Item successfully posted!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Found Item</title>
    <link href="images/logoImag.jpg" rel="icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color:#009999;
            color: black;
            padding: 15px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: black;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            width: 100%;
            background-color: #009999;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #007777;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Post Found or Lost Item</h1>
    </header>

    <div class="container">
        <h2>Please fill all the required fields</h2>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="category">Category</label>
            <select name="category" id="category" required>
                <option value="">Please Select Here</option>
                <option value="Books">Books</option>
                <option value="Electronics">Electronics</option>
                <option value="Clothing">Clothing</option>
                <option value="Accessories">Accessories</option>
                <option value="Other">Other</option>
            </select>

            <label for="founder_name">Name</label>
            <input type="text" name="founder_name" id="founder_name" placeholder="Enter founder's name" required>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter item title" required>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="">Select Status</option>
                <option value="Found">Found</option>
                <option value="Lost">Lost</option>
            </select>

            <label for="contact">Contact #</label>
            <input type="text" name="contact" id="contact" placeholder="Enter contact number" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" placeholder="Enter item description" required></textarea>

            <label for="item_image">Item Image</label>
            <input type="file" name="item_image" id="item_image" accept="image/*" required>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="footer">
        © Copyright NiceAdmin. All Rights Reserved
        <br>
        Template Designed by BootstrapMade
    </div>
</body>
</html>
