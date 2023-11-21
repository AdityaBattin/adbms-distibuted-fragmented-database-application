<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="flex flex-column justify-content-center align-items-center vw-100 vh-100 m-10">
            <div class="h3 p-2 m-4 text-secondary border-bottom border-secondary">
              Edit the Task Here :
            </div>
            <?php
                require '../db_conn.php';

                // Function to retrieve data from todo_db1
                function retrieveDataFromDB1($conn1, $indexkey) {
                    $data = [];
                    $indexkey = (int) $indexkey; // Ensure it's an integer
                    $query1 = "SELECT * FROM todo_db.todo_table WHERE indexkey = $indexkey";
                    $result1 = $conn1->query($query1);

                    if ($result1->num_rows > 0) {
                        $data = $result1->fetch_assoc();
                    }

                    return $data;
                }

                // Function to retrieve data from todo_db2
                function retrieveDataFromDB2($conn2, $indexkey) {
                    $data = [];
                    $indexkey = (int) $indexkey; // Ensure it's an integer
                    $query2 = "SELECT * FROM todo_db.todo_table WHERE indexkey = $indexkey";
                    $result2 = $conn2->query($query2);

                    if ($result2->num_rows > 0) {
                         $data = $result2->fetch_assoc();
                    }

                    return $data;
                }

                // Handle the edit request (displaying the form to edit a record)
                if (isset($_POST['edit'])) {
                    // Access the value of indexkey from the submitted form
                    $indexkey = (int) $_POST['indexkey']; // Ensure it's an integer

                    // Call the functions to retrieve data from both databases
                    $dataFromDB1 = retrieveDataFromDB1($conn1, $indexkey);
                    $dataFromDB2 = retrieveDataFromDB2($conn2, $indexkey);

                    if (!empty($dataFromDB1) && !empty($dataFromDB2)) {
                        // Display a form to edit the record with data from both databases
                        echo '<form action="edit.php" method="post" class="container mt-5">';
                        echo '<input type="hidden" name="indexkey" value="' . $indexkey . '">';

                        // Bootstrap form group for newHtask
                        echo '<div class="mb-3">';
                        echo '<label for="newHtask" class="form-label">Edit Task heading :</label>';
                        echo '<input type="text" class="form-control" name="newHtask" value="' . $dataFromDB1['htask'] . '">';
                        echo '</div>';

                        // Bootstrap form group for newTask
                        echo '<div class="mb-3">';
                        echo '<label for="newTask" class="form-label">Edit Task Description :</label>';
                        echo '<textarea class="form-control" name="newTask" rows="20">' . $dataFromDB1['task'] . '</textarea>';
                        echo '</div>';

                        // Bootstrap form group for newDeadline
                        echo '<div class="mb-3">';
                        echo '<label for="newDeadline" class="form-label">Edit Task Deadline :</label>';
                        echo '<input type="text" class="form-control" name="newDeadline" value="' . $dataFromDB2['deadline'] . '">';
                        echo '</div>';

                        // Bootstrap submit button
                        echo '<button type="submit" class="btn btn-primary" name="update">Update</button>';
    
                        echo '</form>';
                        }
                }

                // Handle the update request
                if (isset($_POST['update'])) {
                    // Access the values from the submitted form
                    $indexkey = (int) $_POST['indexkey']; // Ensure it's an integer
                    $newHtask = $conn1->real_escape_string($_POST['newHtask']);
                    $newTask = $conn1->real_escape_string($_POST['newTask']);
                    $newDeadline = $conn2->real_escape_string($_POST['newDeadline']);

                    // Perform the update operation for both databases
                    $query1 = "UPDATE todo_db.todo_table SET htask = '$newHtask', task = '$newTask' WHERE indexkey = $indexkey";
                    $query2 = "UPDATE todo_db.todo_table SET deadline = '$newDeadline' WHERE indexkey = $indexkey";

                    if ($conn1->query($query1) === TRUE && $conn2->query($query2) === TRUE) {
                        // Update successful, you can redirect to a success page
                        header('Location: ../index.php'); // Replace with your success page
                         exit;
                    } else {
                        echo "Error updating records: " . $conn1->error . " and " . $conn2->error;
                    }
                }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>