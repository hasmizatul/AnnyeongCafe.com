<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['staff_id'])) {
    header("location: login.php");
    exit();
}

// Database connection
require_once 'dbconn.php'; // Ensure this file contains your database connection details

// Fetch customer orders
// $sql = "SELECT * FROM `order`";
$sql = "SELECT o.order_id, c.name, o.order_date, o.total_amount, o.payment_method, o.delivery_method, o.status, GROUP_CONCAT(od.menu_name SEPARATOR ', ') AS order_details, 
               GROUP_CONCAT(od.quantity SEPARATOR ', ') AS quantities, 
               GROUP_CONCAT(od.price SEPARATOR ', ') AS prices
        FROM `order` o
        INNER JOIN customer c ON o.cust_id = c.cust_id
        LEFT JOIN order_details od ON o.order_id = od.order_id
        GROUP BY o.order_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1F2B21;
            color: #ffffff;
        }
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
        }
        .content-container {
            padding: 20px;
            display:flex;
            justify-content:center;
        }
        .order-content{
            width:80%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ffffff;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333333;
        }

        .button{
            padding:10px 20px 10px 20px;
            cursor:pointer;
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #1F2B21;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #ffffff;
            width: 50%;
            max-width: 600px;
            border-radius: 5px;
            color: #ffffff;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content label {
            display: block;
            margin-bottom: 10px;
        }

        .modal-content select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal-content button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-content button:hover {
            background-color: #45a049;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="header">
        <nav>
            <a href="adminprofile.php">HOME</a>
            <!-- <a href="admin_menu_management.php">MENU</a> -->
            <a href="sales_record.php">SALES</a>
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>
    <div class="content-container">
        <div class="order-content">
            <h1>Customer Orders</h1>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>";
                echo    "<th>Order ID</th>";
                echo    "<th>Customer Name</th>";
                echo    "<th>Order Details</th>";
                echo    "<th>Order Items</th>";
                echo    "<th>Total Amount</th>";
                echo    "<th>Status</th>";
                echo    "<th>Action</th>";
                echo "</tr>";
                $num = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo    "<td>" . $num . "</td>";
                    echo    "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo    "<td>";
                    echo        "Order Date : " . htmlspecialchars($row["order_date"]) . "<br>";
                    echo        "Payment Method : " . htmlspecialchars($row["payment_method"]) . "<br>";
                    echo        "Transportation Method : " . htmlspecialchars($row["delivery_method"]) . "<br>";
                    echo    "</td>";
                    echo    "<td>";
            
                    // Explode quantities and prices into arrays
                    $quantities = explode(', ', $row['quantities']);
                    $prices = explode(', ', $row['prices']);
                    $orderDetails = explode(', ', $row['order_details']);
            
                    // Display each item with price and quantity
                    foreach ($orderDetails as $key => $item) {
                        echo htmlspecialchars($item) . " (RM " . htmlspecialchars($prices[$key]) . ") x " . htmlspecialchars($quantities[$key]) . "<br>";
                    }
                    
                    echo    "</td>";
                    echo    "<td>RM " . htmlspecialchars($row["total_amount"]) . "</td>";
                    echo    "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo    "<td>";
                    echo        "<button type='button' data-order-id='" . htmlspecialchars($row["order_id"]) . "' class='button update-button'>Update Status</button>";
                    echo    "</td>";
                    echo "</tr>";
                    $num++;
                }
                echo "</table>";
            } else {
                echo "No orders found.";
            }
            $conn->close();
            ?>
        </div>
    </div>


    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Order</h2>
            <form id="updateForm" action="update_order_status.php" method="POST">
                <input type="hidden" id="order_id" name="order_id">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="">Select Status</option>
                    <option value="Delivered">Delivered</option>
                    <option value="In Kitchen">In Kitchen</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancel">Cancel</option>
                </select>
                <br><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('updateModal');
            const updateButtons = document.querySelectorAll('.update-button');
            const orderIdInput = document.getElementById('order_id');
            const statusSelect = document.getElementById('status');

            updateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    orderIdInput.value = orderId;
                    modal.style.display = 'block';
                });
            });

            // Close the modal when the close button (x) is clicked
            const closeBtn = document.querySelector('.close');
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Close the modal when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            // Optional: You can also handle form submission here if needed
            // document.getElementById('updateForm').addEventListener('submit', function(event) {
            //     event.preventDefault();
            //     // Handle form submission via AJAX or directly
            // });
        });
    </script>




</body>
</html>
