<?php

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'glucosaas';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) 
    {
        die("Connection Error: " . $conn->connect_error);
    }

?>