<?php
session_start();
include 'config.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit();
}

$total_users = 0;
$total_alerts = 0;

try {
    // Get the total number of users
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $stmt->bind_result($total_users);
    $stmt->fetch();
    $stmt->close();

    // Get the total number of alerts
    $stmt = $conn->prepare("SELECT COUNT(*) FROM alerts");
    $stmt->execute();
    $stmt->bind_result($total_alerts);
    $stmt->fetch();
    $stmt->close();

    // Fetch all alerts
    $stmt = $conn->prepare("SELECT id, title, description, location, created_at FROM alerts ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Handle delete request
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM alerts WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: view_alerts.php"); // Redirect to avoid resubmission
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Close the connection
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alert Kenya user dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="userdash.css">
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="user_dash.php" class="brand">
            <img src="logo.png" alt="Logo" class="logo">
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="alerts.php">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">My Alerts</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Message</span>
                </a>
            </li>
            <li>
                <a href="user_map.php">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Map</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="user.jpg" alt="Profile">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Home</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Alerts</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                
                                <th>Title</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Created At</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <!-- CONTENT -->
    <script src="adm.js"></script>
</body>
</html>
