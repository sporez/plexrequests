<?php
namespace App;
 
/**
 * SQLite Create Table Demo
 */
class SQLiteCreateTable {
 
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;
 
    /**
     * connect to the SQLite database
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
 
    /**
     * create tables 
     */
    public function createTables() {
        $commands = ['CREATE TABLE IF NOT EXISTS users (
                        uid   INTEGER PRIMARY KEY,
                        email TEXT NOT NULL,
                        password TEXT NOT NULL
                      )',
            'CREATE TABLE IF NOT EXISTS requests (
                    rid INTEGER PRIMARY KEY,
                    title  VARCHAR (255) NOT NULL,
                    uid  INTEGER NOT NULL,
                    FOREIGN KEY (uid)
                    REFERENCES users(uid) ON UPDATE CASCADE
                                                    ON DELETE CASCADE)'];
        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }
 
    /**
     * get the table list in the database
     */
    public function getTableList() {
 
        $stmt = $this->pdo->query("SELECT name
                                   FROM sqlite_master
                                   WHERE type = 'table'
                                   ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }
 
        return $tables;
    }
 
} //end SQLiteCreateTable class