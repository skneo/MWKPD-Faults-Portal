<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;

if (isset($_POST['url'])) {
    $url = $_POST['url'];
    $tag = $_POST['tag'];
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('Y-m-d H:i:s');

    $all_links = file_get_contents("all_links.json");
    $all_links = json_decode($all_links, true);
    if ($all_links == NULL)
        $all_links = array();

    $link = array();
    array_push($link, $url, $tag, $curr_date);
    $all_links[$curr_date] = $link;
    file_put_contents("all_links.json", json_encode($all_links));

    $showAlert = true;
    $alertClass = "alert-success";
    $alertMsg = "Link saved";
}

if (isset($_GET['delete'])) {
    $url_index = $_GET['delete'];

    $all_links = file_get_contents("all_links.json");
    $all_links = json_decode($all_links, true);

    unset($all_links[$url_index]);
    file_put_contents("all_links.json", json_encode($all_links));

    $showAlert = true;
    $alertClass = "alert-success";
    $alertMsg = "Link deleted";
    // }
}
?>

<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <link rel="shortcut icon" type="image/x-icon" href="sharelogo.png">
    <title>Share Link</title>
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
        <form action="share_link.php" method="POST">
            <div>
                <label for="url" class="form-label float-start">Link/URL</label>
                <input type="text" class="form-control " name="url" id="url">
            </div>
            <div>
                <label for="tag" class="form-label float-start">Remark</label>
                <input type="text" class="form-control " name="tag" id="tag">
            </div>
            <input type="submit" value='Save' class="btn btn-primary mt-2">
        </form>
    </div>
    <hr>
    <div class="mt-3 mx-3 mb-0 text-center">
        <h4><a href="share_link.php"> All Links </a></h4>
    </div>
    <div style="margin-top: 0px;" class="container table-responsive">
        <table id="view_cust" class="table-light table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Remark</th>
                    <th>Date Added</th>
                    <th style="min-width: 200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $all_links = file_get_contents("all_links.json");
                $all_links = json_decode($all_links, true);
                if ($all_links != NULL)
                    $rowNos = count($all_links);
                else $rowNos = 0;
                $link_keys = array_keys($all_links);
                for ($x = 0; $x < $rowNos; $x++) {
                    $link_key = $link_keys[$x];
                    $row = $all_links[$link_key];
                    $url = $row[0];
                    $tag = $row[1];
                    $dateAdded = $row[2];
                    echo "<tr>
                            <td><a href='$url' target='_blank'>$url</a> </td>
                            <td>$tag</td>
                            <td>$dateAdded</td>
                            <td>
                                <a href=\"scan_qr_code.php?qr_url=$url\" target='_blank' class='btn btn-info'>QR Code</a>";
                    if($_SESSION['user_name']=='18571'){              
                          echo "<a href='share_link.php?delete=$dateAdded' class='btn btn-danger' onclick=\"return confirm('Sure to delete \'$tag\'?')\">Delete</a>";
                    }
                    echo    "</td>
                       </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>