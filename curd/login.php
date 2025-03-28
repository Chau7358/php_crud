<?php
include_once "./log.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = trim($_POST['password']);

    // Thực hiện đăng nhập
    $result = Auth::login($email, $password);

    // Kiểm tra kết quả đăng nhập
    if ($result === true) {
        header("Location: index.php"); // Đăng nhập thành công, chuyển hướng đến trang chính
        exit();
    } else {
        $error = $result; // Nếu có lỗi thì hiển thị
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="text-center">Đăng Nhập</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        <div class="text-center mt-3">
            <span>Chưa có tài khoản?</span>
            <a href="register.php" class="text-decoration-none">Đăng ký ngay</a>
        </div>
    </form>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>
