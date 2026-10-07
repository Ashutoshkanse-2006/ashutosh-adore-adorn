<?php
include "includes/db.php";
include "includes/auth.php";
$uid = $_SESSION['user_id'];

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['action'] ?? '') == 'add') {
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['quantity']);
    $product = one("SELECT stock FROM products WHERE id=?", "i", [$pid]);

    if ($product) {
        $row = one("SELECT * FROM cart WHERE user_id=? AND product_id=?", "ii", [$uid, $pid]);
        if ($row) {
            $newQty = min($row['quantity'] + $qty, $product['stock']);
            q("UPDATE cart SET quantity=? WHERE id=?", "ii", [$newQty, $row['id']]);
        } else {
            q("INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)", "iii", [$uid, $pid, min($qty, $product['stock'])]);
        }
    }
    header("Location: cart.php");
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['action'] ?? '') == 'update') {
    $qty = max(1, (int)$_POST['quantity']);
    q("UPDATE cart SET quantity=? WHERE id=? AND user_id=?", "iii", [$qty, (int)$_POST['cart_id'], $uid]);
    header("Location: cart.php");
    exit;
}

// Remove from cart
if (isset($_GET['remove'])) {
    q("DELETE FROM cart WHERE id=? AND user_id=?", "ii", [(int)$_GET['remove'], $uid]);
    header("Location: cart.php");
    exit;
}

$items = rows(q("SELECT cart.id, cart.quantity, p.name, p.price, p.image, p.stock, p.id AS pid
                 FROM cart JOIN products p ON cart.product_id=p.id WHERE cart.user_id=?", "i", [$uid]));
$total = 0;
include "includes/header.php";
?>
<h2>Your Cart</h2>
<?php if (!$items) { echo "<p class=\"notice\">Your cart is empty.</p>"; } else { ?>
<table border="1" cellpadding="5">
    <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
    <?php foreach ($items as $i) {
        $sub = $i['price'] * $i['quantity'];
        $total += $sub; ?>
    <tr>
        <td><a href="product-details.php?id=<?= $i['pid'] ?>"><?= e($i['name']) ?></a></td>
        <td>₹<?= number_format($i['price'], 2) ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="cart_id" value="<?= $i['id'] ?>">
                <input type="number" name="quantity" value="<?= $i['quantity'] ?>" min="1" max="<?= $i['stock'] ?>">
                <button type="submit">Update</button>
            </form>
        </td>
        <td>₹<?= number_format($sub, 2) ?></td>
        <td><a class="link-danger" href="cart.php?remove=<?= $i['id'] ?>" onclick="return confirmAction('Remove this item?')">Remove</a></td>
    </tr>
    <?php } ?>
</table>
<p><strong>Total: ₹<?= number_format($total, 2) ?></strong></p>
<p><a class="btn" href="checkout.php">Proceed to Checkout</a></p>
<?php } ?>
<p><a href="products.php">Continue shopping</a></p>
<?php include "includes/footer.php"; ?>
