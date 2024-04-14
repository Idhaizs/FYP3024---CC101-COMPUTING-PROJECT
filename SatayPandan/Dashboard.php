<?php
@include 'connection.php';

// Include the header file
include 'header.php';

// Get total orders
$total_orders_query = mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM `order`");
$total_orders = mysqli_fetch_assoc($total_orders_query)['total_orders'];

// Get order data for "Total Orders"
$orders_query = mysqli_query($conn, "SELECT id, method, total_products FROM `order`");
$orders = mysqli_fetch_all($orders_query, MYSQLI_ASSOC);

// Get total users (admins)
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM `admin`");
$total_users = mysqli_fetch_assoc($total_users_query)['total_users'];

// Get all admin users
$admins_query = mysqli_query($conn, "SELECT id, username, registration_date FROM `admin`");
$admins = mysqli_fetch_all($admins_query, MYSQLI_ASSOC);

// Get total products
$total_products_query = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM `products`");
$total_products = mysqli_fetch_assoc($total_products_query)['total_products'];

// Get all products
$products_query = mysqli_query($conn, "SELECT id, name, price FROM `products`");
$products = mysqli_fetch_all($products_query, MYSQLI_ASSOC);

// Get total sales
$total_sales_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales FROM `order`");
$total_sales = mysqli_fetch_assoc($total_sales_query)['total_sales'];

// Get order data for "Total Sales"
$sales_data_query = mysqli_query($conn, "SELECT id, method, total_products, total_price FROM `order`");
$sales_data = mysqli_fetch_all($sales_data_query, MYSQLI_ASSOC);

// Get total sales per day
$total_sales_per_day_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales_per_day FROM `order` WHERE DATE(id) = CURDATE()");
$total_sales_per_day = mysqli_fetch_assoc($total_sales_per_day_query)['total_sales_per_day'];

// Get total sales per week
$total_sales_per_week_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales_per_week FROM `order` WHERE WEEK(id) = WEEK(CURDATE())");
$total_sales_per_week = mysqli_fetch_assoc($total_sales_per_week_query)['total_sales_per_week'];

// Get total sales per month
$total_sales_per_month_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales_per_month FROM `order` WHERE MONTH(id) = MONTH(CURDATE())");
$total_sales_per_month = mysqli_fetch_assoc($total_sales_per_month_query)['total_sales_per_month'];

// Get total sales per year
$total_sales_per_year_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales_per_year FROM `order` WHERE YEAR(id) = YEAR(CURDATE())");
$total_sales_per_year = mysqli_fetch_assoc($total_sales_per_year_query)['total_sales_per_year'];

// Get total pending orders
$total_pending_orders_query = mysqli_query($conn, "SELECT COUNT(*) AS total_pending_orders FROM `order` WHERE status = 'pending'");
$total_pending_orders = mysqli_fetch_assoc($total_pending_orders_query)['total_pending_orders'];

// Get pending orders
$pending_orders_query = mysqli_query($conn, "SELECT id, method, total_products, total_price, status FROM `order` WHERE status = 'pending'");
$pending_orders = mysqli_fetch_all($pending_orders_query, MYSQLI_ASSOC);

// Get total completed orders
$total_completed_orders_query = mysqli_query($conn, "SELECT COUNT(*) AS total_completed_orders FROM `order` WHERE status = 'completed'");
$total_completed_orders = mysqli_fetch_assoc($total_completed_orders_query)['total_completed_orders'];

// Get completed orders
$completed_orders_query = mysqli_query($conn, "SELECT id, method, total_products, total_price, status FROM `order` WHERE status = 'completed'");
$completed_orders = mysqli_fetch_all($completed_orders_query, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Other stylesheet links -->
    <link rel="stylesheet" href="Orders.css">
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="stats-container">
            <div class="stat-box">
                <i class="fas fa-shopping-cart"></i>
                <h3>Total Orders</h3>
                <p><?php echo $total_orders; ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ordersModal">
                    View
                </button>
            </div>
            <div class="stat-box">
                <i class="fas fa-users"></i>
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usersModal">
                    View
                </button>
            </div>
            <div class="stat-box">
                <i class="fas fa-box"></i>
                <h3>Total Products</h3>
                <p><?php echo $total_products; ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productsModal">
                    View
                </button>
            </div>
            <div class="stat-box">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Total Sales</h3>
                <p>RM<?php echo number_format($total_sales, 2); ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salesModal">
                    View
                </button>
            </div>
            <div class="stat-box">
                <i class="fas fa-clock"></i>
                <h3>Pending Orders</h3>
                <p><?php echo $total_pending_orders; ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pendingOrdersModal">
                    View
                </button>
            </div>
            <div class="stat-box">
                <i class="fas fa-check-circle"></i>
                <h3>Completed Orders</h3>
                <p><?php echo $total_completed_orders; ?></p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completedOrdersModal">
                    View
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Modal -->
    <div class="modal fade" id="ordersModal" tabindex="-1" aria-labelledby="ordersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ordersModalLabel">Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Payment Method</th>
                                <th>Total Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['method']; ?></td>
                                <td><?php echo $order['total_products']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Modal -->
    <div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersModalLabel">Admin Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?php echo $admin['id']; ?></td>
                                <td><?php echo $admin['username']; ?></td>
                                <td><?php echo $admin['registration_date']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Modal -->
    <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productsModalLabel">Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td>RM<?php echo number_format($product['price'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Modal -->
    <div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salesModalLabel">Sales Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Payment Method</th>
                                <th>Total Products</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales_data as $sale): ?>
                            <tr>
                                <td><?php echo $sale['id']; ?></td>
                                <td><?php echo $sale['method']; ?></td>
                                <td><?php echo $sale['total_products']; ?></td>
                                <td>RM<?php echo number_format($sale['total_price'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
            
    <!-- Pending Orders Modal -->
    <div class="modal fade" id="pendingOrdersModal" tabindex="-1" aria-labelledby="pendingOrdersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pendingOrdersModalLabel">Pending Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Payment Method</th>
                                <th>Total Products</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['method']; ?></td>
                                    <td><?php echo $order['total_products']; ?></td>
                                    <td>RM<?php echo isset($order['total_price']) ? number_format($order['total_price'], 2) : 'N/A'; ?></td>
                                    <td>
                                        <select class="form-select select-status" aria-label="Select Status">
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </td>
                                    <td>
                                    <button type="button" class="btn btn-sm btn-primary save-btn" data-id="<?php echo $order['id']; ?>">Save</button>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Completed Orders Modal -->
    <div class="modal fade" id="completedOrdersModal" tabindex="-1" aria-labelledby="completedOrdersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completedOrdersModalLabel">Completed Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="completedOrdersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Payment Method</th>
                                <th>Total Products</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Completed orders will be appended here dynamically -->
                            <?php foreach ($completed_orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['method']; ?></td>
                                <td><?php echo $order['total_products']; ?></td>
                                <td>RM<?php echo number_format($order['total_price'], 2); ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Dashboard.js"></script>
</body>
</html>
