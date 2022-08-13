<?php
//local database
// $servername = 'localhost';
// $username = 'root';
// $password = '';
// $db_name = 'mwkpdfaults';
// production database
$servername = 'techtips.co.in';
$username = 'techtip2_subuser';
$password = 'satish@mwkpd';
$db_name = 'techtip2_mwkpdfaults';
$con = mysqli_connect($servername, $username, $password, $db_name);
if (!$con) {
    die('connection to this database failed due to ' . mysqli_connect_error());
}
