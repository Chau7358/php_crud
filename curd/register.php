<?php
include_once "./log.php";

$error = ""; // Khởi tạo biến error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $result = Auth::register($name, $email, $password);
    
    if ($result === true) {
        // Đăng ký thành công, chuyển hướng đến trang đăng nhập
        header("Location: login.php");
        exit();
    } else {
        // Đăng ký thất bại, hiển thị lỗi
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="text-center">Đăng Ký</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Họ và tên:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Đăng Ký</button>
        <div class="text-center mt-3">
            <span>Đã có tài khoản?</span>
            <a href="login.php" class="text-decoration-none">Đăng nhập ngay</a>
        </div>
    </form>
    <?php if (!empty($error)) echo "<p class='alert alert-danger mt-3'>$error</p>"; ?>
</body>
</html>