<?php
require 'db_conn.php';

$data = [];
$searchResults = [];

if (isset($_POST['submit'])) {
    $search = $_POST['search'];

    // Function to search for tasks
    function searchTasks($conn1, $conn2, $search) {
        $data = [];

        // Search in todo_db1
        $query1 = "SELECT * FROM todo_db.todo_table WHERE htask LIKE '%$search%'";
        $result1 = $conn1->query($query1);

        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Search in todo_db2
        $query2 = "SELECT * FROM todo_db.todo_table WHERE deadline LIKE '%$search%'";
        $result2 = $conn2->query($query2);

        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    // Call the function to search for tasks
    $searchResults = searchTasks($conn1, $conn2, $search);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex flex-column vw-100 vh-100">
        <nav class="navbar navbar-dark bg-primary">
          <div class="container-fluid justify-content-around">
            <div class="d-flex justify-content-between items-center">
              <img style="width:35px;" src="./img/logo.png" alt="applogo">
              <a class="navbar-brand mx-1">Task Managment Application</a>
            </div>     
            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop1" class="btn btn-light px-4 flex gap-1" id="submit" name="submit" type="submit">
              <svg style="width:25px; color:white;" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="30" viewBox="0 0 50 50">
              <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
              </svg>  
              <span class="mx-2 mt-1">Search Tasks</span>
            </button>
          </div>
        </nav>
        <div class="d-flex flex-row w-100 h-100">
        <div class="w-30 h-100 p-3 m-3">
            <div class="h4 pb-2 mb-4 text-secondary border-bottom border-secondary">
              Add Tasks Here :
            </div>
            <form action="app/add.php" method="POST" autocomplete="off">
              <div class="mb-3">
                <label for="htask" class="form-label">Task : </label>
                <input type="text" class="form-control" name="htask" id="htask" placeholder="title">
              </div>
              <div class="mb-3">
                <label for="task" class="form-label">Describe task : </label>
                <textarea class="form-control" type="text" name="task" id="task" rows="3" placeholder="describe your task in detail"></textarea>
              </div>
              <div class="mb-3">
                <label for="deadline" class="form-label">Deadline : </label>
                <input type="text" class="form-control" name="deadline" id="deadline" placeholder="dd/mm/yyyy">
              </div>
              <input id="submit" name="submit" class="btn btn-primary w-100" type="submit" value="Submit">
            </form>
        </div>
        <div class="d-flex w-70  flex-column flex-fill p-3 m-3 border border-secondary">
            <div class="h4 pb-2 mb-4 text-secondary border-bottom border-secondary">
              List of tasks :
            </div>
            <div class="flex-fill gap-1 d-flex flex-row flex-wrap  w-100 h-100">
              <!-- card exaple format  -->
              <!-- <div class="card" style="width: 18rem; height: 20rem;">
                <div class="card-body d-flex flex-column h-100">
                  <h5 class="card-title">Card title</h5>
                  <h6 class="card-subtitle mb-2 text-muted">dd/mm/yyyy</h6>
                  <p class="overflow-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum dolor veritatis delectus. Magnam, itaque. Qui sunt saepe ullam esse, est tenetur officiis animi iusto suscipit magni laboriosam, voluptas nam et repudiandae eum vero omnis quibusdam numquam quaerat architecto ad cupiditate fugiat tempore doloribus? Minima temporibus qui recusandae. Qui, quasi error.</p>
                  <div class="p-2 bg-primary rounded-sm text-light">Deadline : </div>
                </div>
              </div> -->
              <?php
                  require 'db_conn.php';

                  // Function to retrieve and merge data from both databases
                  function retrieveAndMergeData($conn1, $conn2) {
                  $data = [];

                  // Retrieve and merge data from todo_db1
                  $query1 = "SELECT * FROM todo_db.todo_table";
                  $result1 = $conn1->query($query1);

                  if ($result1->num_rows > 0) {
                    while ($row = $result1->fetch_assoc()) {
                       $data[] = $row;
                    }
                  } 

                  // Retrieve and merge data from todo_db2
                  $query2 = "SELECT deadline, currenttime FROM todo_db.todo_table";
                  $result2 = $conn2->query($query2);

                  if ($result2->num_rows > 0) {
                  $i = 0;
                  while ($row = $result2->fetch_assoc()) {
                  // Merge data from todo_db2 with existing data
                    $data[$i]['deadline'] = $row['deadline'];
                    $data[$i]['currenttime'] = date('d/m/Y H:i:s', strtotime($row['currenttime']));
                    $i++;
                    }
                  }

                  return $data;
                }

                // Call the function to retrieve and merge data
                $mergedData = retrieveAndMergeData($conn1, $conn2);

                foreach ($mergedData as $row) {
                   echo '<div class="card" style="width: 18rem; height: 23rem; margin-bottom=: 0px;">';
                   echo '<div class="card-body d-flex flex-column h-100">';
                   echo "<h5 class='card-title'>{$row['htask']}</h5>";
                   echo "<h6 class='card-subtitle mb-2 text-muted'>{$row['currenttime']}</h6>";
                   echo "<p class='overflow-auto'>{$row['task']}</p>";
                   echo "<div class='p-2 bg-secondary rounded-sm text-light bold'>Deadline: {$row['deadline']}</div>";
                   echo "<div class='d-flex w-100 justify-content-around pt-2 items-center'>
                            <form action='app/edit.php' method='post'>
                                <input id='edit' type='hidden' name='indexkey' value={$row['indexkey']}'>
                                <input class='btn btn-primary px-5' type='submit' name='edit' value='edit task'>
                            </form>
                            <form action='app/delete.php' method='post'>
                                <input id='delete' type='hidden' name='indexkey' value={$row['indexkey']}'>
                                <input class='btn btn-danger px-4' type='submit' name='delete' value='delete'>
                            </form>
                        </div>";
                   echo '</div></div>';
                }
              ?>
            </div>
        </div>
      </div>
    </div>
    <!-- Modal1 -->
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
           <h1 class="modal-title fs-5" id="staticBackdropLabel">Search Tasks Here : </h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="w-full">
              <form action="" method="POST" class="d-flex" role="search">
                <input class="form-control me-2" type="text" id="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-dark" id="submit" name="submit" type="submit">Search</button>
              </form>
            </div>
            <div>
              <?php
                if (!empty($searchResults)) {
                foreach ($searchResults as $row) {
                    echo '<div class="card" style="width: 18rem; height: 23rem; margin-bottom: 0px;">';
                    echo '<div class="card-body d-flex flex-column h-100">';
                    echo "<h5 class='card-title'>{$row['htask']}</h5>";
                    echo "<h6 class='card-subtitle mb-2 text-muted'>{$row['currenttime']}</h6>";
                    echo "<p class='overflow-auto'>{$row['task']}</p>";
                    echo "<div class='p-2 bg-secondary rounded-sm text-light bold'>Deadline: {$row['deadline']}</div>";
                    echo '<div class="d-flex w-100 justify-content-around pt-2 items-center">';
                    echo '<form action="app/edit.php" method="post">';
                    echo "<input type='hidden' name='indexkey' value={$row['indexkey']}>";
                    echo '<input class="btn btn-primary px-5" type="submit" name="edit" value="Edit Task">';
                    echo '</form>';
                    echo '<form action="app/delete.php" method="post">';
                    echo "<input type='hidden' name='indexkey' value={$row['indexkey']}>";
                    echo '<input class="btn btn-danger px-4" type="submit" name="delete" value="Delete">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div></div>';
                }
                } else {
                echo "No results found.";
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      function executePHPEditFunction() {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'edit.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              document.getElementById('result').innerHTML = xhr.responseText;
          } 
      };
      xhr.send();
      }
    </script>
</body>
</html>