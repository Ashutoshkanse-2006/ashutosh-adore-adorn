<?php
include "includes/db.php";
include "includes/auth.php";
$uid = $_SESSION['user_id'];

$orders = rows(q("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC", "i", [$uid]));
include "includes/header.php";
?>
<h2>My Orders</h2>
<?php if (isset($_GET['placed'])) echo "<p class=\"notice success\">Order #" . (int)$_GET['placed'] . " placed successfully!</p>"; ?>
<?php if (!$orders) echo "<p class=\"notice\">You have no orders yet.</p>"; ?>

<?php foreach ($orders as $o) {
    $items = rows(q("SELECT * FROM order_items WHERE order_id=?", "i", [$o['id']])); ?>
    <div class="order-card">
        <h3>Order #<?= $o['id'] ?> - <?= e($o['status']) ?></h3>
        <p>Date: <?= $o['created_at'] ?> | Total: ₹<?= number_format($o['total'], 2) ?></p>
        <p>Deliver to: <?= e($o['name']) ?>, <?= e($o['phone']) ?>, <?= e($o['address']) ?></p>
        <table border="1" cellpadding="5">
            <tr><th>Product</th><th>Price</th><th>Qty</th></tr>
            <?php foreach ($items as $i) { ?>
            <tr>
                <td><?= e($i['product_name']) ?></td>
                <td>₹<?= number_format($i['price'], 2) ?></td>
                <td><?= $i['quantity'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>
<?php include "includes/footer.php"; ?>
