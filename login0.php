<?php
session_start(); // Start the session at the very top of the file before any HTML output

// Include the database connection file
require_once 'dbconn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $user_type = $_POST['user_type'];

    if ($user_type === 'customer') {
        // Redirect to menu.php for customers
        $cust_email = $_POST['email'];
        $cust_password = $_POST['staff_password'];

        $sql = "SELECT * FROM customer WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_cust_email);

            // Set parameters
            $param_cust_email = $cust_email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $result = $stmt->get_result();

                // Check if staff_id exists, if yes then verify password
                if ($result->num_rows == 1) {
                    // Fetch result row as an associative array
                    $row = $result->fetch_assoc();
                    
                    // Check if 'staff_password' field exists in the row
                    if (array_key_exists('password', $row)) {
                        $stored_password = $row['password'];
                        if ($cust_password === $stored_password) {
                            // Password is correct, set session variables and redirect to admin profile page
                            $_SESSION['cust_id'] = $row['cust_id'];
                            $_SESSION['cust_name'] = $row['name'];
                            $_SESSION['cust_email'] = $row['email'];
                            $_SESSION['cust_phone'] = $row['phonenum'];
                            $_SESSION['cust_address'] = $row['address'];

                            header("location: menu.php");
                            exit();
                        } else {
                            // Display an error message if password is not valid
                            $_SESSION["error_message"] = "The password you entered was not valid.";
                        }
                    } else {
                        // Display an error message if 'staff_password' field is missing
                        $_SESSION["error_message"] = "Password field is missing.";
                    }
                } else {
                    // Display an error message if staff_id doesn't exist
                    $_SESSION["error_message"] = "No account found with that staff ID.";
                }
            } else {
                $_SESSION["error_message"] = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }

        exit();

    } elseif ($user_type === 'staff') {
        // Get staff ID and password
        $staff_id = $_POST['staff_id'];
        $staff_password = $_POST['staff_password'];

        // Prepare a select statement
        $sql = "SELECT * FROM staff WHERE staff_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_staff_id);

            // Set parameters
            $param_staff_id = $staff_id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $result = $stmt->get_result();

                // Check if staff_id exists, if yes then verify password
                if ($result->num_rows == 1) {
                    // Fetch result row as an associative array
                    $row = $result->fetch_assoc();
                    
                    // Check if 'staff_password' field exists in the row
                    if (array_key_exists('staff_password', $row)) {
                        $stored_password = $row['staff_password'];
                        if ($staff_password === $stored_password) {
                            // Password is correct, set session variables and redirect to admin profile page
                            $_SESSION['staff_id'] = $row['staff_id'];
                            $_SESSION['staffname'] = $row['staffname'];
                            $_SESSION['job_role'] = $row['job_role'];
                            header("location: adminprofile.php");
                            exit();
                        } else {
                            // Display an error message if password is not valid
                            $_SESSION["error_message"] = "The password you entered was not valid.";
                        }
                    } else {
                        // Display an error message if 'staff_password' field is missing
                        $_SESSION["error_message"] = "Password field is missing.";
                    }
                } else {
                    // Display an error message if staff_id doesn't exist
                    $_SESSION["error_message"] = "No account found with that staff ID.";
                }
            } else {
                $_SESSION["error_message"] = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }

    } else {
        $_SESSION["error_message"] = "Invalid user type selected.";
    }

    // Close connection
    $conn->close();

    // Redirect back to login page if any error occurred
    header("location: login.php");
    exit();
}
?>


