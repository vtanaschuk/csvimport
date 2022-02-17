<?php
$connection = mysqli_connect(
    'localhost',
    'root',
    '1',
    'csv_db'
);

if (!$connection)
{
    echo "Sorry <br>";
    echo mysqli_connect_error();
    exit();
}
