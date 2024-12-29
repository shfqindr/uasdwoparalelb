<?php
require('koneksi.php');

$sql1 = "SELECT fs.SalesID, fs.SalesAmount, t.Tahun
         FROM factsales fs
         JOIN time t ON fs.timeid = t.timeid
         WHERE t.Tahun BETWEEN 2011 AND 2014
         GROUP BY fs.SalesID, fs.SalesAmount, t.Tahun;";

$result1 = mysqli_query($conn, $sql1);

$Hasil = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($Hasil, array(
        "SalesID" => $row['SalesID'],
        "SalesAmount" => $row['SalesAmount'],
        "Tahun" => $row['Tahun']
    ));
}

$data1 = json_encode($Hasil);
?>