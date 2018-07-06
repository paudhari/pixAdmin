<?php

//database connection details
$connect = mysqli_connect('localhost', 'root', 'root');

if (!$connect) {
    die('Could not connect to MySQL: ' . mysql_error());
}


//your database name
$cid = mysqli_select_db($connect, 'ezo');


// path where your CSV file is located
define('CSV_PATH', '/var/www/html/ezoweboadmin/public/csv_upload/');

// Name of your CSV file
$csvFile = CSV_PATH . "afzal.csv";

$file_handle = fopen($csvFile, 'r');
while (!feof($file_handle)) {
    $line_of_text[] = fgetcsv($file_handle, 1024);
}
$line_of_text = array_values(array_filter($line_of_text));
foreach ($line_of_text as $key => $val) {

    $sql = "INSERT INTO `logistics_services` ( `logistics_id`, `is_applicable`, `cod`, `tat`, `price`, `pincode`) 
VALUES 
( '" . $val[0] . "', '" . $val[1] . "', '" . $val[2] . "','" . $val[3] . "','0','" . $val[4] . "')";

//echo '<pre>'; print_r($sql);die;

    $objReturn = mysqli_query($connect, $sql);
}

fclose($file_handle);
?>


