<?php
include_once "./user.php";
$users = User::all();
$limit = 5;
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if (!empty($search)) {
    $totalUsers = User::countSearchResults($search);
    $users = User::searchPaginate($search, $limit, $page);
} else {
    $totalUsers = User::countUsers();
    $users = User::paginate($limit, $page);
}
$totalPages = ceil($totalUsers / $limit);
if (isset($_POST['truncate'])) {
    User::truncate();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        .btn-action {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">User Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>User List</h2>
        <a href="./create.php" class="btn btn-success">Add User</a>
    </div>

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <!-- Search Form -->
    <form method="GET" action="" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by name" 
               value="<?= htmlspecialchars($search) ?>" style="max-width: 250px;">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>

    <!-- User Table -->
    <?php if (count($users) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td class="text-center">
                                <a href="./show.php?id=<?= $user['id'] ?>" class="btn btn-info btn-sm btn-action">View</a>
                                <a href="./edit.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm btn-action">Edit</a>
                                <form action="./delete.php" method="post" class="d-inline" id="formDelete-<?= $user['id'] ?>">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="<?= $user['id'] ?>">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-secondary text-center">No users found.</div>
    <?php } ?>

    <!-- Pagination -->
    <?php if ($totalPages > 1) { ?>
        <nav>
            <ul class="pagination justify-content-center mt-3">
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>

    <!-- Logout Button -->
    <div class="d-flex justify-content-center mt-3">
        <a href="./login.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>
    </div>

</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmLogout() {
        return confirm("Are you sure you want to logout?");
    }

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('formDelete-' + this.dataset.id).submit();
            }
        });
    });
</script>

</body>
</html>
