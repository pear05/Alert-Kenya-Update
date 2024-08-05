<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            overflow: hidden;
        }
        .box-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        .box-info li {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33.333% - 20px);
            margin: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .box-info li:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .box-info li i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #007BFF;
        }
        .box-info li .text h3 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }
        .box-info li .text p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #777;
        }
        @media (max-width: 768px) {
            .box-info li {
                flex: 1 1 calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .box-info li {
                flex: 1 1 100%;
            }
        }
        .btn-container {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<?php
// Assuming $total_alerts and $total_users are fetched from the database
$total_alerts = 120; // Example static value
$total_users = 50;   // Example static value
$resolved_alerts = 90; // Example static value
$pending_alerts = $total_alerts - $resolved_alerts;
$total_admins = 5; // Example static value
$active_users = 45; // Example static value
?>

<div class="container">
    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($total_alerts); ?></h3>
                <p>Total Alerts</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($total_users); ?></h3>
                <p>Total Users</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-check-circle' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($resolved_alerts); ?></h3>
                <p>Resolved Alerts</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-error' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($pending_alerts); ?></h3>
                <p>Pending Alerts</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-user-circle' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($total_admins); ?></h3>
                <p>Total Admins</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-user-check' ></i>
            <span class="text">
                <h3><?php echo htmlspecialchars($active_users); ?></h3>
                <p>Active Users</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-hourglass' ></i>
            <span class="text">
                <h3>24h</h3>
                <p>Average Response Time</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-hourglass' ></i>
            <span class="text">
                <h3>26.4 Mins</h3>
                <p>Average Spent Time</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-hourglass' ></i>
            <span class="text">
                <h3>32.5 Min</h3>
                <p>Average Browse Time</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-bar-chart-alt-2' ></i>
            <span class="text">
                <h3>85%</h3>
                <p>Success Rate</p>
            </span>
        </li>
    </ul>

    <div class="btn-container">
        <a href="adm_dash.php" class="btn">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
