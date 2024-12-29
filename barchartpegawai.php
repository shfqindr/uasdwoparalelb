<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Andventure Works</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/styleGraph.css">

</head>

<body style="margin-top:60px;">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "sidebar.php";?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
			<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
	<center>
    <p class="highcharts-description">
        Berikut merupakan grafik untuk menampilkan Pegawai dengan penjualan terbanyak, dimana dapat kita lihat bahwa
		pegawai Linda C Mitchell mendapatkan total penjualan paling banyak, diikuti oleh Jae B Pak pada posisi ke 2 dan Jilian Carson pada posisi ke 3 
    </p>
	</center>
</figure>

<?php
$conn = mysqli_connect("localhost", "root", "", "uasdwo");
$sql = "SELECT 
                e.employeename AS nama,
                ROUND(SUM(fs.salesamount), 2) AS total_sales
            FROM factsales fs
            INNER JOIN employee e ON fs.employeeid = e.employeeid
            GROUP BY fs.employeeid, e.employeename
            HAVING total_sales > 0
            ORDER BY total_sales DESC
            LIMIT 10";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$data = [];
while ($temp = mysqli_fetch_array($query)) {
    $nama = $temp['nama'];
    $total_sales = $temp['total_sales'];
    $data[] = "['".addslashes($nama)."', ".$total_sales."]";  // Make sure strings are escaped properly
}

// Join the data array into a comma-separated list for JavaScript
$data_str = implode(',', $data);
?>

<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pegawai dengan Penjualan Terbanyak'
    },
    subtitle: {
        text: 'Source: Database UASDWO'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Penjualan'
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Total sales',
        data: [
            <?php echo $data_str; ?>
        ]
    }]
});
</script>


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dashboard UAS DWO SHAFIQ</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
</body>

</html>