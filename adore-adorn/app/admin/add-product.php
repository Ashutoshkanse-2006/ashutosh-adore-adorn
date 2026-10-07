<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
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
        q("INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?,?,?,?,?,?)",
          "issdis", [$cat, $name, $desc, $price, $stock, $image]);
        header("Location: products.php");
        exit;
    }
}
include "../includes/header.php";
?>
<h2>Add Product</h2>
<?php if ($error) echo "<p>" . e($error) . "</p>"; ?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product name" required><br>
    <select name="category_id">
        <option value="0">-- No category --</option>
        <?php foreach ($categories as $c) { ?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php } ?>
    </select><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="number" name="stock" placeholder="Stock" value="0" required><br>
    <input type="file" name="image" accept="image/*"><br>
    <button type="submit">Add Product</button>
</form>
<?php include "../includes/footer.php"; ?>
