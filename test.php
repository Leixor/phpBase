<?php
    require('connect.php');

    $user_id = $_POST["number"];

    // create the connection
    $connection = new connection("localhost", "root", "", "testphp");

    //
    $sql = "SELECT first_name FROM user WHERE user_id = :user_id";
    $connection->addPQuery("n1", $sql);

    $result = $connection->pQuery("n1", array('user_id' => $user_id));

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        echo $row['first_name'];
    }
?>
