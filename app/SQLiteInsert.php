<?php
 
namespace App;
 
/**
 * PHP SQLite Insert Demo
 */
class SQLiteInsert {
 
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;
 
    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
 
    /**
     * Insert a new project into the projects table
     * @param string $projectName
     * @return the id of the new project
     */
    public function insertUser($email, $password) {
        $sql = 'INSERT INTO users(email, password) VALUES(:email, :password)';
        $stmt = $this->pdo->prepare($sql);
        //$stmt->bindValue(':email', $email);
        $stmt->execute([
            ':email' => $email,
            ':password' => md5($password),
        ]);
 
        return $this->pdo->lastInsertId();
    }
 
    /**
     * Insert a new task into the tasks table
     * @param type $taskName
     * @param type $startDate
     * @param type $completedDate
     * @param type $completed
     * @param type $projectId
     * @return int id of the inserted task
     */
    public function insertRequest($title, $uid) {
        $sql = 'INSERT INTO requests(title, uid) '
                . 'VALUES(:title, :uid)';
 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':uid' => $uid,
        ]);
 
        return $this->pdo->lastInsertId();
    }

    public function getUser($uid)
    {
        $sql = "SELECT * FROM users WHERE uid = :uid";

        $stmt = $this->pdo->prepare($sql);
        $stmt = execute([
            ':uid' => $uid,
        ]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($row)
            return json_encode($row);
        else
            return "user doesn't exist";
    }
 
}