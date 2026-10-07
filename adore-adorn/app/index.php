<?php
include "includes/db.php";
$products = rows(q("SELECT * FROM products ORDER BY id DESC LIMIT 8"));
include "includes/header.php";
?>
<section class="hero">
    <h1>Adore &amp; Adorn</h1>
    <p>Jewellery, clothing and accessories.</p>
    <a class="btn btn-light" href="products.php">Shop Now</a>
</section>

<h2 class="section-title">Latest Products</h2>
<div class="product-grid">
<?php foreach ($products as $p) { ?>
    <div class="product-card">
        <a class="thumb" href="product-details.php?id=<?= $p['id'] ?>">
            <?php if ($p['image']) { ?><img src="<?= e(imgUrl($p['image'])) ?>" alt="<?= e($p['name']) ?>"><?php } else { ?><div class="no-img">No image</div><?php } ?>
        </a>
        <div class="card-body">
            <h3><a href="product-details.php?id=<?= $p['id'] ?>"><?= e($p['name']) ?></a></h3>
            <p class="price">₹<?= number_format($p['price'], 2) ?></p>
        </div>
    </div>
<?php } ?>
</div>
<?php if (!$products) echo "<p class=\"notice\">No products yet.</p>"; ?>
<p class="view-all"><a class="btn" href="products.php">View all products</a></p>
<?php include "includes/footer.php"; ?>
