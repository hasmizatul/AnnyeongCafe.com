<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            position: fixed;
            height: 100%;
            width: 240px;
            background: #000000;
            transition: all 0.5s ease;
        }
        .sidebar.active {
            width: 60px;
        }
        .sidebar .logo-details {
            height: 80px;
            display: flex;
            align-items: center;
        }
        .sidebar .logo-details i {
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            min-width: 60px;
            text-align: center;
        }
        .sidebar .logo-details .logo_name {
            color: #fff;
            font-size: 24px;
            font-weight: 500;
        }
        .sidebar .nav-links {
            margin-top: 10px;
        }
        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            height: 50px;
        }
        .sidebar .nav-links li a {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.4s ease;
        }
        .sidebar .nav-links li a.active {
            background: #FF8096;
        }
        .sidebar .nav-links li a:hover {
            background: #FF8096;
        }
        .sidebar .nav-links li i {
            min-width: 60px;
            text-align: center;
            font-size: 18px;
            color: #fff;
        }
        .sidebar .nav-links li a .links_name {
            color: #fff;
            font-size: 15px;
            font-weight: 400;
            white-space: nowrap;
        }
        .sidebar .nav-links .log_out {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .home-section {
            position: relative;
            background: #f5f5f5;
            min-height: 100vh;
            width: calc(100% - 240px);
            left: 240px;
            transition: all 0.5s ease;
        }
        .sidebar.active ~ .home-section {
            width: calc(100% - 60px);
            left: 60px;
        }
        .home-section nav {
            display: flex;
            justify-content: space-between;
            height: 80px;
            background: #fff;
            display: flex;
            align-items: center;
            position: fixed;
            width: calc(100% - 240px);
            left: 240px;
            z-index: 100;
            padding: 0 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }
        .sidebar.active ~ .home-section nav {
            left: 60px;
            width: calc(100% - 60px);
        }
        .home-section nav .sidebar-button {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 500;
        }
        nav .sidebar-button i {
            font-size: 35px;
            margin-right: 10px;
        }
        .home-section nav .search-box {
            position: relative;
            height: 50px;
            max-width: 550px;
            width: 100%;
            margin: 0 20px;
        }
        nav .search-box input {
            height: 100%;
            width: 100%;
            outline: none;
            background: #F5F6FA;
            border: 2px solid #EFEEF1;
            border-radius: 6px;
            font-size: 18px;
            padding: 0 15px;
        }
        nav .search-box .bx-search {
            position: absolute;
            height: 40px;
            width: 40px;
            background: #2697FF;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 4px;
            line-height: 40px;
            text-align: center;
            color: #fff;
            font-size: 22px;
            transition: all 0.4 ease;
        }
        .home-section nav .profile-details {
            display: flex;
            align-items: center;
            background: #F5F6FA;
            border: 2px solid #EFEEF1;
            border-radius: 6px;
            height: 50px;
            min-width: 190px;
            padding: 0 15px 0 2px;
        }
        nav .profile-details img {
            height: 40px;
            width: 40px;
            border-radius: 6px;
            object-fit: cover;
        }
        nav .profile-details .admin_name {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin: 0 10px;
            white-space: nowrap;
        }
        nav .profile-details i {
            font-size: 25px;
            color: #333;
        }
        .home-section .home-content {
            position: relative;
            padding-top: 104px;
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
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus'></i>
            <span class="logo_name">Admin</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="admin profile.php" class="active">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
           
            <li>
			<a href="admin_menu_management.php">
			<i class='bx bx-coin-stack'></i>
			<span class="links_name">Menu Update</span>
		</a>
	</li>

			<li>
                <a href="admin page.php">
                    <i class='bx bx-box'></i>
                    <span class="links_name">Admin Page</span>
                </a>
            </li>
           
            <li>
                <a href="ProfileView.php">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Setting</span>
                </a>
            </li>
            <li class="log_out">
    <a href="#" onclick="confirmLogout()">
        <i class='bx bx-log-out'></i>
        <span class="links_name">Log out</span>
    </a>
</li>
        </ul>
    </div>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu'></i>
                <span class="dashboard">Admin Dashboard</span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>
            <div class="profile-details">
                <img src="admin.jpg" alt="">
                <span class="admin_name">Admin Name</span>
                <i class='bx bx-chevron-down'></i>
            </div>
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Order</div>
                        <div class="number">50</div>
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
                        <div class="number">RM 1500</div>
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
                        <div class="number">RM 2500</div>
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
                        <ul class="details">
                            <li class="topic">Date</li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                            <li><a href="#">22 July 2024</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Customer</li>
                          
                            <li><a href="#">Daud Salam</a></li>
                            <li><a href="#">Hasmizatul</a></li>
                            <li><a href="#">Nur Aleeya</a></li>
                            <li><a href="#">Hanis Adibah</a></li>
                            <li><a href="#">Huda Ja'afar</a></li>
                            <li><a href="#">Khairul Aming</a></li>
                            <li><a href="#">Danish Zaki</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Sales</li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
							<li><a href="#">Delivered</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Total</li>
                            <li><a href="#">RM 25</a></li>
                            <li><a href="#">RM 14</a></li>
						    <li><a href="#">RM 28</a></li>
                            <li><a href="#">RM 8.50</a></li>
                            <li><a href="#">RM 17</a></li>
                            <li><a href="#">RM 16.90</a></li>
                            <li><a href="#">RM 25</a></li>
                        </ul>
                    </div>
                    <div class="button">
                        <a href="#">See All</a>
                    </div>
                </div>
                <div class="top-sales box">
                    <div class="title">Hot Selling</div>
                    <ul class="top-sales-details">
                        <li>
                            <a href="#">
                                <img src="jajang.jpg" alt="">
                                <span class="product">JAJANGMYEON</span>
                            </a>
                            <span class="price">RM 18.90</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="tteokbokki.jpg" alt="">
                                <span class="product">TEOKBOKKI</span>
                            </a>
                            <span class="price">RM 16.90</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="ice chcoco.jpg" alt="">
                                <span class="product">ICED CHOCOLATE</span>
                            </a>
                            <span class="price">RM 7</span>
                        </li>
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