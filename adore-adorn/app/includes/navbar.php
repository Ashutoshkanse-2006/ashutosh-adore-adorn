<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>
<?php if ($inAdmin) { ?>
<nav>
    <?php if (isset($_SESSION['admin_id'])) { ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="orders.php">Orders</a>
        <a href="users.php">Users</a>
        <a href="change-password.php">Password</a>
        <a href="../index.php" target="_blank">View Store</a>
        <a href="logout.php">Logout (<?= e($_SESSION['admin_name']) ?>)</a>
    <?php } ?>
</nav>
<hr>
<?php } else { ?>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="index.php">Adore &amp; Adorn</a>
        <nav>
            <a href="index.php" class="<?= $page == 'index.php' ? 'active' : '' ?>">Home</a>
            <a href="products.php" class="<?= ($page == 'products.php' || $page == 'product-details.php') ? 'active' : '' ?>">Products</a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="cart.php" class="<?= ($page == 'cart.php' || $page == 'checkout.php') ? 'active' : '' ?>">Cart</a>
                <a href="orders.php" class="<?= $page == 'orders.php' ? 'active' : '' ?>">My Orders</a>
                <a href="profile.php" class="<?= $page == 'profile.php' ? 'active' : '' ?>">Profile (<?= e($_SESSION['user_name']) ?>)</a>
                <a href="logout.php">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="<?= $page == 'login.php' ? 'active' : '' ?>">Login</a>
                <a href="register.php" class="<?= $page == 'register.php' ? 'active' : '' ?>">Register</a>
            <?php } ?>
            <a href="admin/login.php">Admin</a>
        </nav>
    </div>
</header>
<main class="container">
<?php } ?>
