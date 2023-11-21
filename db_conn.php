<?php 
// MySQL database server 1 settings
$server1Host = "127.0.0.1";
$server1Port = 3308;
$server1Username = "root";
$server1Password = "rootuser";
$server1Database = "todo_db";

// MySQL database server 2 settings
$server2Host = "127.0.0.1";
$server2Port = 3309;
$server2Username = "root";
$server2Password = "rootuser";
$server2Database = "todo_db";

// Attempt to connect to database server 1
$conn1 = new mysqli($server1Host, $server1Username, $server1Password, $server1Database, $server1Port);

// Attempt to connect to database server 2
$conn2 = new mysqli($server2Host, $server2Username, $server2Password, $server2Database, $server2Port);

// Check if both connections failed
if ($conn1->connect_error && $conn2->connect_error) {
    die("Connection to both database servers failed: " . $conn1->connect_error . " and " . $conn2->connect_error);
}
else{
    // echo '<h4 class="">Databases Connected Succesfully</h4>';
}

