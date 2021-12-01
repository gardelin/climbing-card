<?php
/*
$db_user = 'pkvertik_user';
$db_pass = 'srM8024iYh';
$db_name = 'pkvertik_pkv';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_user, $db_pass) or die(mysqli_error('ne mogu se spojiti na bazu'));
mysqli_select_db($db_name) or die(mysqli_error('ne mogu selektirati bazu'));
*/
function get_podaci () {
$db_user = 'root';
$db_pass = 'root';
$db_name = 'vertikal';
$db_host = 'localhost';
$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
mysqli_set_charset($db,'utf8');
return $db;
}
$db = get_podaci ();
$sql = 'DELETE FROM wp_ekarton_podaci WHERE id_podatak = "'.$_POST['id_podatak'].'"';
mysqli_query($db,$sql);
mysqli_close($db);