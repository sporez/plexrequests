<?php
 
namespace App;
 
/**
 * PHP SQLite Get
 */
class SQLiteGet {
 
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
     * Get users from the users table
     */
    public function getUsers($uid = null) {

        if($uid != null)
        {
            $sql = 'SELECT * FROM users WHERE uid = :uid';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':uid' => $uid,
            ]);
        }
        else
        {
            $sql = 'SELECT * FROM users';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        $users = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $users[$row['uid']] = $row['email'];
        }   
 
        return json_encode($users);
    }

    public function getRequests($rid = null) {

        if($rid != null)
        {
            $sql = 'SELECT * FROM requests WHERE rid = :rid';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':rid' => $rid,
            ]);
        }
        else
        {
            $sql = 'SELECT * FROM requests';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        $requests = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $requests[$row['rid']]['title'] = $row['title'];
            $requests[$row['rid']]['uid'] = $row['uid'];
        }   
 
        return json_encode($requests);
    }
 
    
}