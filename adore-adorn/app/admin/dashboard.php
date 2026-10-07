<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$products = one("SELECT COUNT(*) AS c FROM products")['c'];
$orders = one("SELECT COUNT(*) AS c FROM orders")['c'];
$users = one("SELECT COUNT(*) AS c FROM users")['c'];
$sales = one("SELECT COALESCE(SUM(total),0) AS s FROM orders WHERE status != 'Cancelled'")['s'];
$byStatus = rows(q("SELECT status, COUNT(*) AS c FROM orders GROUP BY status ORDER BY status"));
$recent = rows(q("SELECT o.id, o.total, o.status, o.created_at, u.name FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.id DESC LIMIT 5"));
$lowStock = rows(q("SELECT id, name, stock FROM products WHERE stock <= 5 ORDER BY stock, name LIMIT 10"));
include "../includes/header.php";
?>
<h2>Admin Dashboard</h2>
<p>Welcome, <?= e($_SESSION['admin_name']) ?>.</p>
<ul>
    <li>Products: <?= $products ?></li>
    <li>Orders: <?= $orders ?></li>
    <li>Users: <?= $users ?></li>
    <li>Total sales: ₹<?= number_format($sales, 2) ?></li>
</ul>

<h3>Orders by status</h3>
<?php if (!$byStatus) echo "<p>No orders yet.</p>"; ?>
<ul><?php foreach ($byStatus as $s) { ?><li><a href="orders.php?status=<?= urlencode($s['status']) ?>"><?= e($s['status']) ?></a>: <?= $s['c'] ?></li><?php } ?></ul>

<h3>Recent orders</h3>
<?php if ($recent) { ?>
<table border="1" cellpadding="5">
    <tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th>Placed</th></tr>
    <?php foreach ($recent as $o) { ?>
    <tr><td><?= $o['id'] ?></td><td><?= e($o['name']) ?></td><td>₹<?= number_format($o['total'], 2) ?></td><td><?= e($o['status']) ?></td><td><?= $o['created_at'] ?></td></tr>
    <?php } ?>
</table>
<?php } else echo "<p>No orders yet.</p>"; ?>

<h3>Low stock (5 or fewer)</h3>
<?php if ($lowStock) { ?>
<ul><?php foreach ($lowStock as $p) { ?><li><a href="edit-product.php?id=<?= $p['id'] ?>"><?= e($p['name']) ?></a> - <?= (int)$p['stock'] ?> left</li><?php } ?></ul>
<?php } else echo "<p>All products are well stocked.</p>"; ?>
<?php include "../includes/footer.php"; ?>
