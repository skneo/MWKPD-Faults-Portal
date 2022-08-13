<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = $data;
    // $data = htmlspecialchars($data);
    return $data;
}
$machine = $_GET['machine'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fault_desc'])) {
    $datetime = validateInput($_POST['datetime']);
    $main_part = validateInput($_POST['main_part']);
    $fault_desc = validateInput($_POST['fault_desc']);
    $rectification = validateInput($_POST['rectification']);
    $components = validateInput($_POST['components']);
    $entry_done_by = $_SESSION['user_name'];
    include_once 'db_con.php';
    $sql = "INSERT INTO `faults` VALUES (NULL,'$datetime','$machine','$main_part','$fault_desc','$rectification','$components','$entry_done_by');"; //NULL for auto inrement
    $result = mysqli_query($con, $sql);
    echo mysqli_error($con);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "Fault added";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, Fault not added";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_fault_id'])) {
    $id = $_GET['delete_fault_id'];
    include_once 'db_con.php';
    $sql = "DELETE FROM `faults` WHERE `id`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "Fault id $id deleted";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, Fault id $id deleted";
    }
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>Fault history</title>
</head>

<body>
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container my-3">
        <!-- margin-inline: 1%; -->
        <?php
        echo "<h4>Fault history of $machine </h4>";
        echo "<center> <a href='new_fault_entry.php?machine=$machine' class='btn btn-primary'>New Fault Entry</a>";
        ?>
        <div class="my-3 ">
            <h4>Past faults</h4>
            <table id="table_id" class="table-light table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Fault Id</th>
                        <th style="min-width:80px">Date</th>
                        <th style="min-width:150px">Main part affected</th>
                        <th style="min-width:350px">Fault Description</th>
                        <th>Action</th>
                        <th>Fault entry done by</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'db_con.php';
                    $sql = "SELECT * FROM `faults` WHERE `machine`='$machine' ";
                    $result = mysqli_query($con, $sql);
                    $rowNos = mysqli_num_rows($result);
                    for ($x = 0; $x < $rowNos; $x++) {
                        $sn = $x + 1;
                        $row = mysqli_fetch_assoc($result);
                        $id = $row['id'];
                        $main_part = $row['main_part'];
                        $occured_on = $row['occured_on'];
                        $fault_desc = $row['fault_desc'];
                        // $rectification = $row['rectification'];
                        $entry_done_by = $row['entry_done_by'];
                        echo "<tr>
                                <td>$sn</td>
                                <td>$id</td>
                                <td>$occured_on </td>
                                <td>$main_part</td>
                                <td>$fault_desc </td>
                                <td><a href='fault.php?fault_id=$id' class='btn btn-primary'>View</a>";
                        if ($_SESSION['user_name'] == '18571')
                            echo "<a href='edit_fault.php?edit_fault_id=$id' class='btn btn-info mx-2'>Edit</a>
                                <a href='fault_history.php?machine=$machine&delete_fault_id=$id' class='btn btn-danger' onclick=\"return confirm('Sure to delete fault id \'$id\'?')\">Delete</a>";
                        echo "</td>
                                <td>$entry_done_by </td>
                        </tr>";
                    }
                    ?>

                </tbody>
            </table>
            <!-- for data table -->
            <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"> </script>
            <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
            <script>
                $(document).ready(function() {
                    $('#table_id').DataTable({
                        "scrollX": true
                    });
                });
            </script>
            </center>
        </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>