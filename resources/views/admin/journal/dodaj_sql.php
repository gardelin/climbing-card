<?php
/*
$db_user = 'pkvertik_user';
$db_pass = 'srM8024iYh';
$db_name = 'pkvertik_pkv';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_user, $db_pass) or die(mysqli_error('ne mogu se spojiti na bazu'));
mysqli_select_db($db_name) or die(mysqli_error('ne mogu selektirati bazu'));
mysqli_set_charset('utf8',$db);
*/
function get_podaci()
{
  $db_user = 'root';
  $db_pass = 'root';
  $db_name = 'vertikal';
  $db_host = 'localhost';
  $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
  mysqli_set_charset($db, 'utf8');
  return $db;
}
$db = get_podaci();
$ocjena = $_POST['ocjena'];
$sql = 'INSERT INTO wp_ekarton_podaci (smjer, penjaliste, nacin, ocjena, komentar, datum, userName, datum_upisa) VALUES("' . $_POST['smjer'] . '","' . $_POST['penjaliste'] . '","' . $_POST['nacin'] . '","' . $ocjena . '","' . $_POST['komentar'] . '","' . $_POST['datum'] . '" ,"' . $_POST['userName'] . '", NOW())';
mysqli_query($db, $sql);
mysqli_close($db);

/*
$myFile = '/home/pkvertik/public_html/wp-content/plugins/novikarton/administracija/test.txt';
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = 'INSERT INTO wp_ekarton_podaci (smjer, penjaliste, nacin, ocjena, komentar, datum, userName, datum_upisa) VALUES("'.$_POST['smjer'].'","'.$_POST['penjaliste'].'","'.$_POST['nacin'].'","'.$_POST['ocjena'].'","'.$_POST['komentar'].'","'.$_POST['datum'].'" ,"'.$_POST['userName'].'","'.$_POST['datum_upisa'].'")';
fwrite($fh, $stringData);
fclose($fh);
*/