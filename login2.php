<?php
session_start();

// DB connection
$host = "localhost";
$db = "lostandfound";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();

        // For plain-text passwords
        if ($password == $userData['password']) {
            $_SESSION['email'] = $userData['email'];
            $_SESSION['username'] = $userData['username'];
            header("Location: homePage.php");
            exit();
        } else {
            $loginError = "Incorrect password.";
        }
    } else {
        $loginError = "No account found with that email.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="images/logoImag.jpg" rel="icon">  
    <title>Find It: Lost and Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .header {
            background-color: #00b3b3;
            color: white;
            padding: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-section {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 20px;
        }

        .login-box {
            background-color: white;
            border-radius: 10px;
            border: 2px solid #4a90e2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 60px;
            width: 550px;
            text-align: center;
        }

        .login-box h1 {
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 18px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background-color: #00b3b3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #357ab8;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .footer a {
            color: #4a90e2;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://firebasestorage.googleapis.com/v0/b/ip-info-app.appspot.com/o/app_icon_final.png?alt=media&token=8c4a5fb7-aa7e-4d97-80f0-1a974e3bd48d" alt="Logo">
        <h1>Find It: Lost and Found</h1>
    </div>
    <div class="content">
        <p>Welcome to the Campus Lost and Found Portal. Please login below:</p>
        <div class="login-section">
            <div class="login-box">
                <h1>Student Login</h1>

                <?php if (!empty($loginError)): ?>
                    <div class="error"><?php echo $loginError; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="student-username"><b>CollegeMail:</b></label>
                        <input type="email" id="student-username" name="username" placeholder="Enter your CollegeMail" required>
                    </div>
                    <div class="form-group">
                        <label for="student-password"><b>Password:</b></label>
                        <input type="password" id="student-password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
