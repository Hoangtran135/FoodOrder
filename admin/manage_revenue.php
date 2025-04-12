<?php
include('partials/header.php');

// Truy vấn lấy doanh thu theo tháng
$sql = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(total_amount) AS revenue
        FROM tbl_order
        WHERE status = 'completed'  -- Giả sử chỉ tính doanh thu cho các đơn hàng hoàn thành
        GROUP BY month
        ORDER BY month DESC";  // Sắp xếp theo tháng, mới nhất ở đầu
$res = mysqli_query($conn, $sql);

$data = array(); // Mảng chứa dữ liệu
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = array('month' => $row['month'], 'revenue' => $row['revenue']);
}

// Chuyển dữ liệu thành dạng JSON để hiển thị trên biểu đồ
$dataJson = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Doanh thu</title>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1.chart-title {
            text-align: center;
            margin: 40px 0;
            font-size: 2.5rem;
            font-weight: bold;
            color: #4e73df;
        }

        /* Styling for chart container */
        #chart-container {
            width: 85%;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background: #fff;
        }

        /* Responsive styling for chart */
        canvas {
            width: 100%;
            height: 400px;
        }

        /* Styling the page content and container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Styling for mobile responsiveness */
        @media (max-width: 768px) {
            #chart-container {
                width: 95%;
                padding: 20px;
            }

            h1.chart-title {
                font-size: 2rem;
            }

            canvas {
                height: 350px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="chart-title">Doanh thu hàng tháng</h1>

        <div id="chart-container">
            <canvas id="revenue-chart"></canvas>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });

        function showGraph() {
            // Dữ liệu JSON được tạo sẵn trong PHP
            var data = <?php echo $dataJson; ?>;

            var months = [];
            var revenues = [];

            // Lấy dữ liệu tháng và doanh thu từ response JSON
            for (var i in data) {
                months.push(data[i].month);
                revenues.push(data[i].revenue);
            }

            var options = {
                responsive: true,
                legend: {
                    display: true,
                    labels: {
                        fontSize: 14,
                        fontColor: '#555'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            fontSize: 12
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000000,  // Điều chỉnh bước giá trị y
                            fontSize: 12
                        },
                        grid: {
                            display: true,
                            borderColor: '#f2f2f2'
                        }
                    }
                },
                tooltips: {
                    enabled: true,
                    backgroundColor: '#333',
                    bodyFontSize: 14,
                    titleFontSize: 16,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    displayColors: false,
                    cornerRadius: 4
                }
            };

            var dataChart = {
                labels: months,
                datasets: [
                    {
                        label: 'Doanh thu (VND)',
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        hoverBackgroundColor: '#2e59d9',
                        hoverBorderColor: '#2e59d9',
                        data: revenues
                    }
                ]
            };

            // Vẽ biểu đồ
            var ctx = $("#revenue-chart");
            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: dataChart,
                options: options
            });
        }
    </script>

</body>
</html>
