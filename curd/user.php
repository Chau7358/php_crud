<?php 
include_once './DB.php'; 
include_once './helper.php';
class User {
    public static function all() {
        $sql = "SELECT * FROM users";
        $users = DB::execute($sql);
        return $users; // Return về $users hoặc thế này DB::execute($sql) (thì bỏ $users đi)
    }
    public static function create($data) {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        return DB::execute($sql, $data);
    }
    public static function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = DB::execute($sql, ['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy 1 dòng dữ liệu dưới dạng mảng
        
        return $user ?: null; // Nếu không có user, trả về null
    }
    public static function update($dataUpdate)
    {
        $sql = "UPDATE users set name=:name, email=:email ,password=:password where id=:id";
        DB::execute($sql, $dataUpdate);
    }
    public static function destroy($id)
    {
       $sql = "DELETE FROM users where id=:id"; // Sửa lỗi cú pháp: id=: id => id=:id
       $dataDelete =['id'=> $id];
       DB::execute($sql,$dataDelete);
    }
    static public function truncate()
    {
        $sql = "TRUNCATE TABLE users";
        DB::execute($sql);
    }
    public static function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = DB::execute($sql, ['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về một mảng dữ liệu hoặc null nếu không tìm thấy
    }
    
    
    public static function search($name)
    {
        $sql = "SELECT * FROM users WHERE name LIKE :name";
        return DB::execute($sql, ['name' => "%" . $name . "%"]);
    }
    public static function paginate($limit, $page)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM users LIMIT :limit OFFSET :offset";
        $stmt = DB::execute($sql, ['limit' => $limit, 'offset' => $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Ensure the result is an array
    }

    public static function countUsers()
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = DB::execute($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả từ PDOStatement
        return $result['total'] ?? 0;
    }
    public static function searchPaginate($search, $limit, $page)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM users WHERE name LIKE :search LIMIT :limit OFFSET :offset";
        $stmt = DB::execute($sql, [
            'search' => "%$search%",
            'limit' => $limit,
            'offset' => $offset
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Ensure the result is an array
    }

    public static function countSearchResults($search)
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE name LIKE :search";
        $stmt = DB::execute($sql, ['search' => "%$search%"]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả từ PDOStatement
        return $result['total'] ?? 0;
    }
}
?>