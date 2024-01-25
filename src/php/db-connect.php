<?php
  try {
    $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');
  } catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
  }
?>