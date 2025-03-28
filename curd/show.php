<?php
include_once "./user.php";

$id = $_GET['id'] ?? null;
$user = null;

if ($id) {
    $user = User::find($id);
} else {
    header("location:./index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            width: 50%;
            margin: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background: #007bff;
            color: white;
            text-align: left;
            padding: 10px;
        }
        .table td {
            padding: 10px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h2 class="mb-4">User Information</h2>
    
    <?php if ($user) { ?>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($user["name"]) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user["email"]) ?></td>
            </tr>
        </table>
    <?php } else { ?>
        <p class="text-danger">User Not Found</p>
    <?php } ?>

    <div class="btn-container">
        <a href="./index.php" class="btn btn-primary">Back to list</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
