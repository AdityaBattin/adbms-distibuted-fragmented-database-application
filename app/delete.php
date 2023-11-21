<?php
require '../db_conn.php';

// Check if the form has been submitted
if (isset($_POST['delete'])) {
    // Access the value of indexkey from the submitted form
    $indexkey = $_POST['indexkey'];

    // Delete the record from both databases using prepared statements
    $query1 = "DELETE FROM todo_db.todo_table WHERE indexkey = ?";
    $query2 = "DELETE FROM todo_db.todo_table WHERE indexkey = ?";

    // Use prepared statements to bind the parameter
    $stmt1 = $conn1->prepare($query1);
    $stmt1->bind_param("i", $indexkey);

    $stmt2 = $conn2->prepare($query2);
    $stmt2->bind_param("i", $indexkey);

    if ($stmt1->execute() && $stmt2->execute()) {
        // Deletion successful, you can redirect to a success page
        header('Location: ../index.php'); // Replace with your success page
        exit;
    } else {
        echo "Error deleting records: " . $stmt1->error . " and " . $stmt2->error;
    }
    header('Location: ../index.php'); // Replace with the actual page you want to redirect to.
    exit;
}
?>

