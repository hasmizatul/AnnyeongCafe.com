<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['staff_id'])) {
    header("location: login.php");
    exit();
}

// Database connection
require_once 'dbconn.php'; // Ensure this file contains your database connection details

$sql_count = "SELECT COUNT(*) AS order_count, SUM(total_amount) AS total_amount_sum FROM `order`";

$result_count = $conn->query($sql_count);
$order_stats = $result_count->fetch_assoc() ?: ['order_count' => 0, 'total_amount_sum' => 0];

$sql = "SELECT o.order_id, c.name, o.order_date, o.total_amount, o.payment_method, o.delivery_method, o.status
        FROM `order` o
        INNER JOIN customer c ON o.cust_id = c.cust_id";

$result = $conn->query($sql);


$sql_menu = "SELECT * FROM `menu_category`";
$result_menu = mysqli_query($conn, $sql_menu);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <style>
        .header {
            background-color: #1F2B21;
            padding: 20px;
            text-align: center;
        }
        .header nav a {
            color: #ffffff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .home-section {
            position: relative;
            background: #f5f5f5;
            min-height: 100vh;
            width: 100%;
            left:0px !important;
            justify-content:center;
            display:flex;
            transition: all 0.5s ease;
        }
        .home-section .home-content {
            position: relative;
            width: 80%;
            padding-top: 50px;
        }
        .home-content .overview-boxes {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
            margin-bottom: 26px;
        }
        .overview-boxes .box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 290px;
			height: 100px;
            background: #fff;
            padding: 15px 14px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        .overview-boxes .box-topic {
            font-size: 20px;
            font-weight: 500;
        }
        .home-content .box .number {
            display: inline-block;
            font-size: 35px;
            margin-top: -6px;
            font-weight: 500;
        }
        .home-content .box .indicator {
            display: flex;
            align-items: center;
        }
        .home-content .box .indicator i {
            height: 20px;
            width: 20px;
            background: #8FDACB;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            color: #fff;
            font-size: 20px;
            margin-right: 5px;
        }
        .box .indicator i.down {
            background: #e87d88;
        }
        .home-content .box .indicator .text {
            font-size: 12px;
        }
        .home-content .box .cart {
            display: inline-block;
            font-size: 32px;
            height: 50px;
            width: 50px;
            background: #cce5ff;
            line-height: 50px;
            text-align: center;
            color: #66b0ff;
            border-radius: 12px;
            margin: -15px 0 0 6px;
        }
        .home-content .box .cart.two {
            color: #2BD47D;
            background: #C0F2D8;
        }
        .home-content .box .cart.three {
            color: #ffc233;
            background: #ffe8b3;
        }
        .home-content .box .cart.four {
            color: #e05260;
            background: #f7d4d7;
        }
        .home-content .total-order {
            font-size: 20px;
            font-weight: 500;
        }
        .home-content .sales-boxes {
            display: flex;
            justify-content: space-between;
        }
        .home-content .sales-boxes .recent-sales {
            width: 65%;
            background: #fff;
            padding: 20px 30px;
            margin: 0 20px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        .home-content .sales-boxes .sales-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sales-boxes .box .title {
            font-size: 24px;
            font-weight: 500;
        }
        .sales-boxes .sales-details li.topic {
            font-size: 20px;
            font-weight: 500;
        }
        .sales-boxes .sales-details li {
            list-style: none;
            margin: 8px 0;
        }
		        .sales-boxes .sales-details li a {
            font-size: 18px;
            color: #333;
            font-size: 400;
            text-decoration: none;
        }
        .sales-boxes .sales-details li a:hover {
            color: #669AFF;
        }
        .home-content .sales-boxes .top-sales {
            width: 35%;
            background: #fff;
            padding: 20px 30px;
            margin: 0 20px 0 0;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        .sales-boxes .top-sales li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 10px 0;
        }
        .sales-boxes .top-sales li a img {
            height: 40px;
            width: 40px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 10px;
            background: #333;
        }
        .sales-boxes .top-sales li a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .sales-boxes .top-sales li .product, .price {
            font-size: 17px;
            color: #333;
            font-weight: 400;
        }
        .sales-boxes .top-sales li .price {
            font-size: 16px;
            color: #0A2558;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #000000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #E2E2E2;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="header">
        <nav>
            <a href="adminprofile.php">HOME</a>
            <!-- <a href="admin_menu_management.php">MENU</a> -->
            <a href="customerorders.php">ORDER</a>
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>

    <section class="home-section">
        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Order</div>
                        <div class="number">
                            <?= htmlspecialchars($order_stats["order_count"]) ?>
                        </div>
                        <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class='bx bx-cart-alt cart'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Sales</div>
                        <div class="number">
                            RM <?= htmlspecialchars($order_stats["total_amount_sum"]) ?>
                        </div>
                        <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class='bx bxs-cart-add cart two'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Profit</div>
                        <div class="number">
                            RM <?= htmlspecialchars($order_stats["total_amount_sum"]) ?>
                        </div>
                        <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class='bx bx-cart cart three'></i>
                </div>
                
            </div>

            <div class="sales-boxes">
                <div class="recent-sales box">
                    <div class="title">Recent Sales</div>
                    <div class="sales-details">
                        <?php
                            if ($result->num_rows > 0) {
                                echo "<table>";
                                echo "<tr>";
                                echo    "<th>Order Date</th>";
                                echo    "<th>Customer Name</th>";
                                echo    "<th>Status</th>";
                                echo    "<th>Total Amount</th>";
                                echo "</tr>";
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo    "<td>" . htmlspecialchars($row["order_date"]) . "</td>";
                                    echo    "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                    echo    "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                    echo    "<td>RM " . htmlspecialchars($row["total_amount"]) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "No orders found.";
                            }
                            $conn->close();
                        ?>
                    </div>
                    <div class="button">
                        <a href="customerorders.php">See All</a>
                    </div>
                </div>
                <div class="top-sales box">
                    <div class="title">Hot Selling</div>
                    <ul class="top-sales-details">
                        <?php 
                            if(mysqli_num_rows($result_menu) > 0){
                                while($data = mysqli_fetch_array($result_menu)){
                        ?>
                            <li>
                                <a href="#">
                                    <img src="<?= $data['menu_image'] ?>" alt="">
                                    <span class="product"><?= $data['menu_name'] ?></span>
                                </a>
                                <span class="price">RM <?= $data['menu_price'] ?></span>
                            </li>
                        <?php
                            }
                        } else {
                            echo '<li><a href="#"><span class="product">No Menu Recorded</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
	<script>
    // Existing sidebar toggle script
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    }

    // Function to confirm logout and redirect to register.html
    function confirmLogout() {
        let confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            // Redirect to register.html
            window.location.href = "logout.php";
        } else {
            // Optionally handle if the user cancels logout
            alert("Logout canceled!");
        }
    }
</script>
</body>
</html>