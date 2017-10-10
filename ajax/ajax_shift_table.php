<?php

session_start();
require_once '../includes/dbconfig.php';

try {
  if (isset($_SESSION['user_session']) && isset($_POST['days']) && isset($_POST['offset']) && isset($_POST['category'])) {

    if (!is_numeric($_POST['days'])) { throw new Exception('Arg 1 not an integer'); }
    if (!is_numeric($_POST['offset'])) { throw new Exception('Arg 2 not an integer'); }

    echo json_encode($crud->getShiftTableObject(intval($_POST['days']), intval($_POST['offset']), $_POST['category']));

  } else {
    throw new Exception('Wrong arguments.');
  }
} catch (PDOException $e) {
  echo $e;
}

?>
