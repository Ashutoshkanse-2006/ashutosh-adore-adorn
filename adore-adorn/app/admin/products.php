<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$products = rows(q("SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC"));
include "../includes/header.php";
?>
<h2>Products</h2>
<?php $low = array_filter($products, fn($p) => (int)$p['stock'] <= 5); if ($low) echo '<p style="color:#b42318"><strong>' . count($low) . ' product(s) low on stock (5 or fewer).</strong></p>'; ?>
<p><a href="add-product.php">+ Add Product</a></p>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
    <?php foreach ($products as $p) { ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?php if ($p['image']) { ?><img src="<?= e(imgUrl($p['image'])) ?>" width="60"><?php } ?></td>
        <td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td>
        <td>₹<?= number_format($p['price'], 2) ?></td>
        <td<?= (int)$p['stock'] <= 5 ? ' style="color:#b42318;font-weight:bold"' : '' ?>><?= $p['stock'] ?></td>
        <td>
            <a href="edit-product.php?id=<?= $p['id'] ?>">Edit</a> |
            <form method="post" action="delete-product.php" style="display:inline" onsubmit="return confirm('Delete this product?')">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= $p['id'] ?>"><button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include "../includes/footer.php"; ?>
