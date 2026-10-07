<?php
include "includes/db.php";
include "includes/auth.php";
$uid = $_SESSION['user_id'];

$items = rows(q("SELECT cart.quantity, p.id AS pid, p.name, p.price, p.stock
                 FROM cart JOIN products p ON cart.product_id=p.id WHERE cart.user_id=?", "i", [$uid]));
if (!$items) {
    header("Location: cart.php");
    exit;
}

$total = 0;
foreach ($items as $i) $total += $i['price'] * $i['quantity'];

$user = one("SELECT * FROM users WHERE id=?", "i", [$uid]);
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name == "" || $phone == "" || $address == "") {
        $error = "Please fill name, phone and address.";
    } else {
        // make sure there is enough stock
        foreach ($items as $i) {
            if ($i['quantity'] > $i['stock']) {
                $error = "Not enough stock for " . $i['name'] . " (available: " . $i['stock'] . ").";
                break;
            }
        }
    }

    if ($error == "") {
        pgc_begin_transaction($conn);
        try {
            q("INSERT INTO orders (user_id, total, name, phone, address) VALUES (?,?,?,?,?)", "idsss", [$uid, $total, $name, $phone, $address]);
            $orderId = pgc_insert_id($conn);

            foreach ($items as $i) {
                q("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?,?,?,?,?)",
                  "iisdi", [$orderId, $i['pid'], $i['name'], $i['price'], $i['quantity']]);
                q("UPDATE products SET stock = stock - ? WHERE id=?", "ii", [$i['quantity'], $i['pid']]);
            }
            q("DELETE FROM cart WHERE user_id=?", "i", [$uid]);
            pgc_commit($conn);
            header("Location: orders.php?placed=" . $orderId);
            exit;
        } catch (Exception $ex) {
            pgc_rollback($conn);
            $error = "Could not place order. Please try again.";
        }
    }
}
include "includes/header.php";
?>
<h2>Checkout</h2>
<?php if ($error) echo "<p class=\"notice\">" . e($error) . "</p>"; ?>

<table border="1" cellpadding="5">
    <tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr>
    <?php foreach ($items as $i) { ?>
    <tr>
        <td><?= e($i['name']) ?></td>
        <td><?= $i['quantity'] ?></td>
        <td>₹<?= number_format($i['price'] * $i['quantity'], 2) ?></td>
    </tr>
    <?php } ?>
</table>
<p><strong>Total: ₹<?= number_format($total, 2) ?></strong> (Cash on Delivery)</p>

<form method="post">
    <input type="text" name="name" placeholder="Full name" value="<?= e($_POST['name'] ?? $user['name']) ?>" required><br>
    <input type="text" name="phone" placeholder="Phone" value="<?= e($_POST['phone'] ?? $user['phone']) ?>" required><br>
    <textarea name="address" placeholder="Delivery address" required><?= e($_POST['address'] ?? $user['address']) ?></textarea><br>
    <button type="submit">Place Order</button>
</form>
<p><a href="cart.php">&larr; Back to cart</a></p>
<?php include "includes/footer.php"; ?>
