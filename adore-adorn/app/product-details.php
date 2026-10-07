<?php
include "includes/db.php";
$id = (int)($_GET['id'] ?? 0);
$p = one("SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=?", "i", [$id]);
if (!$p) {
    header("Location: products.php");
    exit;
}
include "includes/header.php";
?>
<div class="product-detail">
    <div class="detail-image">
        <?php if ($p['image']) { ?><img src="<?= e(imgUrl($p['image'])) ?>" alt="<?= e($p['name']) ?>"><?php } else { ?><div class="no-img">No image</div><?php } ?>
    </div>
    <div class="detail-info">
        <h2><?= e($p['name']) ?></h2>
        <p class="meta">Category: <?= e($p['category'] ?? 'None') ?></p>
        <p><?= nl2br(e($p['description'])) ?></p>
        <p class="price">Price: ₹<?= number_format($p['price'], 2) ?></p>
        <p class="meta">Stock: <?= $p['stock'] ?></p>

        <?php if ($p['stock'] > 0) { ?>
            <form method="post" action="cart.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?= $p['stock'] ?>">
                <button type="submit">Add to Cart</button>
            </form>
        <?php } else { echo "<p class=\"notice\">Out of stock</p>"; } ?>
    </div>
</div>
<p><a href="products.php">&larr; Back to products</a></p>
<?php include "includes/footer.php"; ?>
