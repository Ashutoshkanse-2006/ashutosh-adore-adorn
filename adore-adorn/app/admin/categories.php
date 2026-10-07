<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$categories = rows(q("SELECT * FROM categories ORDER BY name"));
include "../includes/header.php";
?>
<h2>Categories</h2>
<p><a href="add-category.php">+ Add Category</a></p>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Name</th><th>Actions</th></tr>
    <?php foreach ($categories as $c) { ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= e($c['name']) ?></td>
        <td>
            <a href="edit-category.php?id=<?= $c['id'] ?>">Edit</a> |
            <form method="post" action="delete-category.php" style="display:inline" onsubmit="return confirm('Delete this category?')">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= $c['id'] ?>"><button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include "../includes/footer.php"; ?>
