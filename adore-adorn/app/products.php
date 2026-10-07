<?php
include "includes/db.php";

$cat = (int)($_GET['category'] ?? 0);
$search = trim($_GET['search'] ?? '');

$sql = "SELECT * FROM products WHERE 1=1";
$types = "";
$params = [];
if ($cat > 0) {
    $sql .= " AND category_id=?";
    $types .= "i";
    $params[] = $cat;
}
if ($search != "") {
    $sql .= " AND name LIKE ?";
    $types .= "s";
    $params[] = "%$search%";
}
$sql .= " ORDER BY id DESC";

$products = rows(q($sql, $types, $params));
$categories = rows(q("SELECT * FROM categories ORDER BY name"));
include "includes/header.php";
?>
<h2>Products</h2>

<form method="get" class="filter-bar">
    <input type="text" name="search" placeholder="Search" value="<?= e($search) ?>">
    <select name="category">
        <option value="0">All categories</option>
        <?php foreach ($categories as $c) { ?>
            <option value="<?= $c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
        <?php } ?>
    </select>
    <button type="submit">Filter</button>
</form>

<div class="product-grid">
<?php foreach ($products as $p) { ?>
    <div class="product-card">
        <a class="thumb" href="product-details.php?id=<?= $p['id'] ?>">
            <?php if ($p['image']) { ?><img src="<?= e(imgUrl($p['image'])) ?>" alt="<?= e($p['name']) ?>"><?php } else { ?><div class="no-img">No image</div><?php } ?>
        </a>
        <div class="card-body">
            <h3><a href="product-details.php?id=<?= $p['id'] ?>"><?= e($p['name']) ?></a></h3>
            <p class="price">₹<?= number_format($p['price'], 2) ?></p>
            <?php if ($p['stock'] > 0) { ?>
                <form method="post" action="cart.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit">Add to Cart</button>
                </form>
            <?php } else { echo "<p class=\"out-of-stock\">Out of stock</p>"; } ?>
        </div>
    </div>
<?php } ?>
</div>
<?php if (!$products) echo "<p class=\"notice\">No products found.</p>"; ?>
<?php include "includes/footer.php"; ?>
