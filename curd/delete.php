<?php
include_once "./user.php";
include_once "./DB.php";

// Kiểm tra nếu có ID được gửi từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id']; // Ép kiểu ID để đảm bảo là số nguyên

    // Kiểm tra xem user có tồn tại không
    $user = User::find($id);
    if (!$user) {
        $_SESSION['message'] = "User not found!";
        header("Location: index.php");
        exit();
    }

    // Xóa user
    User::destroy($id);

    // Kiểm tra nếu bảng trống thì reset Auto Increment
    $sqlCheck = "SELECT COUNT(*) as total FROM users";
    $stmt = DB::execute($sqlCheck);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả đúng cách

    if ($result && $result['total'] == 0) {
        DB::resetAutoIncrement('users');
    }

    $_SESSION['message'] = "User deleted successfully!";
    header("Location: index.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid request!";
    header("Location: index.php");
    exit();
}
?>