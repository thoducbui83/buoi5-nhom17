<?php
session_start();
require_once "users.php"; // Gọi danh sách tài khoản giả lập

// Kiểm tra nếu có cookie, đăng nhập tự động
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];

    // Kiểm tra thông tin đăng nhập
    if (isset($users[$username]) && $users[$username] == $password) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    }
}

// Xử lý đăng nhập từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Kiểm tra tài khoản hợp lệ
    if (isset($users[$username]) && $users[$username] == $password) {
        $_SESSION['username'] = $username;

        // Nếu chọn "Ghi nhớ đăng nhập", lưu cookies
        if ($remember) {
            setcookie("username", $username, time() + (86400 * 30), "/"); // 30 ngày
            setcookie("password", $password, time() + (86400 * 30), "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://phongvu.vn/cong-nghe/wp-content/uploads/2024/09/130-hinh-nen-may-tinh-4k-78-1-1024x640.jpg');/* Đường dẫn ảnh 4K */
            background-size: cover;  /* Đảm bảo ảnh phủ toàn bộ màn hình */
            background-position: center; /* Căn giữa ảnh */
            background-repeat: no-repeat; /* Không lặp lại ảnh */
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);s
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <label>
                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            </label>
            <input type="submit" value="Đăng Nhập">
        </form>
    </div>
</body>
</html>
