<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$users = rows(q("SELECT u.*, (SELECT COUNT(*) FROM orders o WHERE o.user_id=u.id) AS order_count FROM users u ORDER BY u.id DESC"));
include "../includes/header.php";
?>
<h2>Users (<?= count($users) ?>)</h2>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Orders</th><th>Registered</th><th>Actions</th></tr>
    <?php foreach ($users as $u) { ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= e($u['name']) ?></td>
        <td><?= e($u['email']) ?></td>
        <td><?= e($u['phone']) ?></td>
        <td><?= e($u['address']) ?></td>
        <td><?= (int)$u['order_count'] ?></td>
        <td><?= $u['created_at'] ?></td>
        <td><form method="post" action="delete-user.php" onsubmit="return confirm('Delete this user and all their orders?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $u['id'] ?>"><button type="submit">Delete</button></form></td>
    </tr>
    <?php } ?>
</table>
<?php include "../includes/footer.php"; ?>
