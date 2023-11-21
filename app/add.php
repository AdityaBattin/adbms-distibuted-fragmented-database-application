<?php
require '../db_conn.php';

if (isset($_POST['submit'])) {
    $htask = $_POST['htask'];
    $task = $_POST['task'];
    $deadline = $_POST['deadline'];

    // Insert data into the first database (server 1)
    $sql1 = "INSERT INTO todo_db.todo_table (htask, task) VALUES ('$htask', '$task')";

    if ($conn1->query($sql1) === TRUE) {
        echo "Data inserted into server 1 successfully";
    } else {
        echo "Error inserting data into server 1: " . $conn1->error;
    }

    // Insert data into the second database (server 2)
    $sql2 = "INSERT INTO todo_db.todo_table (deadline, currenttime) VALUES ('$deadline', NOW())";

    if ($conn2->query($sql2) === TRUE) {
        echo "Data inserted into server 2 successfully";
    } else {
        echo "Error inserting data into server 2: " . $conn2->error;
    }
    // Redirect to the index.php page
    header('Location: ../index.php');
} else {
    echo "Form not submitted.";
}




