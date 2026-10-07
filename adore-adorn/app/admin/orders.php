<?php
include "../includes/db.php";
include "../includes/admin-auth.php";

// Update order status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allowed = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
    if (in_array($_POST['status'], $allowed)) {
        q("UPDATE orders SET status=? WHERE id=?", "si", [$_POST['status'], (int)$_POST['order_id']]);
    }
    header("Location: orders.php");
    exit;
}

$filter = $_GET['status'] ?? '';
if ($filter !== '' && in_array($filter, ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'])) {
    $orders = rows(q("SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id=u.id WHERE o.status=? ORDER BY o.id DESC", "s", [$filter]));
} else {
    $filter = '';
    $orders = rows(q("SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.id DESC"));
}
include "../includes/header.php";
?>
<h2>All Orders</h2>
<p>Filter: <a href="orders.php">All</a><?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $s) { ?> | <a href="orders.php?status=<?= $s ?>"><?= $filter === $s ? "<strong>$s</strong>" : $s ?></a><?php } ?></p>
<?php if (!$orders) echo "<p>No orders yet.</p>"; ?>
<?php foreach ($orders as $o) {
    $items = rows(q("SELECT * FROM order_items WHERE order_id=?", "i", [$o['id']])); ?>
    <div>
        <h3>Order #<?= $o['id'] ?> - ₹<?= number_format($o['total'], 2) ?> - <?= $o['created_at'] ?></h3>
        <p>Customer: <?= e($o['name']) ?> (<?= e($o['email']) ?>), <?= e($o['phone']) ?><br>
           Address: <?= e($o['address']) ?></p>
        <ul>
            <?php foreach ($items as $i) { ?>
                <li><?= e($i['product_name']) ?> x <?= $i['quantity'] ?> (₹<?= number_format($i['price'], 2) ?>)</li>
            <?php } ?>
        </ul>
        <form method="post">
            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
            <select name="status">
                <?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $s) { ?>
                    <option <?= $o['status'] == $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php } ?>
            </select>
            <button type="submit">Update Status</button>
        </form>
        <hr>
    </div>
<?php } ?>
<?php include "../includes/footer.php"; ?>
