<?php
// Include your database connection configuration file
include 'config.php';

// Establish a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Execute the SQL query
$select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die("Query failed: " . mysqli_error($conn));

// Get the number of rows returned
$row_count = mysqli_num_rows($select_rows);
?>

<header class="header">
   <div class="flex">
      <a href="#" class="logo">Satay Pandan</a>
      <nav class="navbar">
         <a href="https://1drv.ms/b/s!AqGNVPSl-BRziEczln2HccdK4GE_?e=bbv91c" target="_blank">Help</a>
         <a href="Dashboard.php">Dashboard</a>
         <a href="admin.php">add products</a>
         <a href="products.php">view products</a>
      </nav>
      <a href="cart.php" class="cart">cart <span><?php echo $row_count; ?></span> </a>
      <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
      <div id="menu-btn" class="fas fa-bars"></div>
      
   </div>
</header>
<style>
   .logout-btn {
    display: inline-block;
    padding: 6px 12px; 
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background-color: #ff6b6b;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-left: 10px; 
}

.logout-btn:hover {
    background-color: #ff8c8c;
}


</style>

<?php

$conn = mysqli_connect('localhost','root','','sataypandan') or die('connection failed');

?>