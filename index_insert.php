<?php
 
require 'vendor/autoload.php';
 
use App\SQLiteConnection;
use App\SQLiteInsert;
 
$pdo = (new SQLiteConnection())->connect();
$sqlite = new SQLiteInsert($pdo);
 
// insert a new user
$userID = $sqlite->insertUser('neil@ndelillo.com', 'booger');
// insert some movie requests for the user
$sqlite->insertRequest('Cabin in the Woods', $userID);
$sqlite->insertRequest('The Mule', $userID);
$sqlite->insertRequest('Aquaman', $userID);
 
// insert a second user
$userID = $sqlite->insertUser('roger@bennet.com', 'imdead');
// insert the requests for the second user
$sqlite->insertRequest('Roger\'s Story', $userID);
$sqlite->insertRequest('Bubba, the Movie', $userID);