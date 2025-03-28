<?php
include_once './DB.php';
include_once './user.php';

class Auth
{
    public static function register($name, $email, $password) { 
        if (empty($name) || empty($email) || empty($password)) {
            return "Vui lòng nhập đầy đủ thông tin!";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email không hợp lệ!";
        }
    
        // Kiểm tra nếu email đã tồn tại
        if (User::findByEmail($email)) {
            return "Email đã tồn tại!";
        }
    
        // Mã hóa mật khẩu sử dụng password_hash()
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];
    
        if (User::create($userData)) {
            return true; // Trả về true thay vì redirect ngay
        } else {
            return "Lỗi khi tạo tài khoản!";
        }
    }

    public static function login($email, $password) {
        if (empty($email) || empty($password)) {
            return "Vui lòng nhập email và mật khẩu!";
        }
    
        // Kiểm tra email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email không hợp lệ!";
        }
    
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $user = User::findByEmail($email);
        
        if (!$user) {
            return "Email không tồn tại!";
        }
        
        // Debug: Hiển thị thông tin password đã hash và kết quả xác thực
        echo "<pre>";
        echo "Input password: " . $password . "\n";
        echo "Stored hash: " . $user['password'] . "\n";
        echo "password_verify result: " . (password_verify($password, $user['password']) ? 'true' : 'false') . "\n";
        echo "</pre>";
        
        // Kiểm tra password
        if (!password_verify($password, $user['password'])) {
            return "Sai mật khẩu!";
        }
        
        // Đăng nhập thành công, lưu thông tin vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
    
        return true;
    }
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }
    
    public static function logout()
    {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}