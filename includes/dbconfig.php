<?php

function checkIfNumAndInt($num) {
  if (is_numeric($num)) {
    $num = get_numeric($num);
    if (is_int($num)) {
      return true;
    }
  }
  return false;
}

function get_numeric($val) {
  if (is_numeric($val)) {
    return $val + 0;
  }
  return 0;
}

$DB_host = 'localhost';
$DB_user = 'id1876647_neenjawtestuser';
$DB_pass = 'testedninja4neenjaw';
$DB_name = 'id1876647_neenjawtest';

$DB_tbl_users = 'logindemo01_tbl_users';

try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 echo $e->getMessage();
}

if (isset($_SESSION['user_session'])) {
    include_once 'classes/class.crud.php';

    $crud = new crud($DB_con);
}
?>
