<?php

try {
      $conn = new PDO('mysql:host=localhost;dbname=chat_room', 'root', '');
   } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
}

?>