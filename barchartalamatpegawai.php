<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Distribution Dashboard</title>
    
    <!-- Essential CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
</head>

<body>
    <!-- Wrapper for the entire layout -->
    <div id="wrapper">
        <!-- Sidebar Section -->
        <?php include "sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content Area -->
            <div class="container-fluid">
                <!-- Card for Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Persebaran Kota Tempat Tinggal Pegawai/h6>
                    </div>
                    <div class="card-body">
                        <!-- Chart Container -->
                        <div id="employeeChart" style="min-height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    try {
        // Database connection
        $conn = new PDO("mysql:host=localhost;dbname=dwuas", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Improved query with error handling
        $sql = "
            SELECT 
                COALESCE(da.city, 'Unknown') AS city,
                COUNT(DISTINCT fe.employeeid) AS total_employees,
                ROUND((COUNT(DISTINCT fe.employeeid) * 100.0) / (
                    SELECT COUNT(DISTINCT employeeid) 
                    FROM fact_employee
                ), 2) AS percentage
            FROM 
                fact_employee fe
            LEFT JOIN 
                dimaddress da ON fe.addressid = da.addressid
            GROUP BY 
                da.city
            HAVING 
                total_employees > 0
            ORDER BY 
                total_employees DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = array(
                'name' => $row['city'],
                'y' => floatval($row['percentage'])
            );
        }

        $jsonData = json_encode($data);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $jsonData = json_encode([]);
    }
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Highcharts.chart('employeeChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Persebaran Kota Tempat Tinggal Pegawai'
            },
            subtitle: {
                text: 'Source: Database UASDWO'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Employees',
                colorByPoint: true,
                data: <?php echo $jsonData; ?>
            }]
        });
    });
    </script>
</body>
</html>