<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$id = (int)($_GET['id'] ?? 0);
$p = one("SELECT * FROM products WHERE id=?", "i", [$id]);
if (!$p) {
    header("Location: products.php");
    exit;
}
$error = "";
$categories = rows(q("SELECT * FROM categories ORDER BY name"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $cat = (int)$_POST['category_id'] ?: null;
    $image = uploadImage($_FILES['image'] ?? null);

    if ($name == "" || $price <= 0) {
        $error = "Name and a valid price are required.";
    } elseif ($image === false) {
        $error = "Image must be jpg, png, gif or webp.";
    } else {
        if ($image != '') {
            // new image uploaded: delete old file and save new name
            if ($p['image']) deleteImage($p['image']);
        } else {
            $image = $p['image'];
        }
        q("UPDATE products SET category_id=?, name=?, description=?, price=?, stock=?, image=? WHERE id=?",
          "issdisi", [$cat, $name, $desc, $price, $stock, $image, $id]);
        header("Location: products.php");
        exit;
    }
}
include "../includes/header.php";
?>
<h2>Edit Product</h2>
<?php if ($error) echo "<p>" . e($error) . "</p>"; ?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= e($p['name']) ?>" required><br>
    <select name="category_id">
        <option value="0">-- No category --</option>
        <?php foreach ($categories as $c) { ?>
            <option value="<?= $c['id'] ?>" <?= $p['category_id'] == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
        <?php } ?>
    </select><br>
    <textarea name="description"><?= e($p['description']) ?></textarea><br>
    <input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" required><br>
    <input type="number" name="stock" value="<?= $p['stock'] ?>" required><br>
    <?php if ($p['image']) { ?><img src="<?= e(imgUrl($p['image'])) ?>" width="100"><br><?php } ?>
    <input type="file" name="image" accept="image/*"> (leave empty to keep current image)<br>
    <button type="submit">Save</button>
</form>
<?php include "../includes/footer.php"; ?>
