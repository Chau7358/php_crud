<?php
session_start();
class DB
{
    private static $connection;
    private const DB_TYPE = "mysql";
    private const DB_HOST = "127.0.0.1"; //"127.0.0.1"
    private const DB_NAME = "crud";  
    private const USER_NAME = "root"; 
    private const USER_PASSWORD = "";  

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    self::DB_TYPE . ":host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8",
                    self::USER_NAME,
                    self::USER_PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die(" Kết nối thất bại: " . $e->getMessage()); 
            }
        }
        return self::$connection;
    }
 
    public static function execute($sql, $params = []) {
        $stmt = self::getConnection()->prepare($sql);
    
        $stmt->execute($params);
        return $stmt;
    }
    public static function resetAutoIncrement($table) {
        $sqlReset = "TRUNCATE TABLE $table";
        self::getConnection()->exec($sqlReset);
    }
}