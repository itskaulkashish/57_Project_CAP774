<?php
session_start();

$user_id = $_SESSION['user_id'];

// Connect to MySQL server and select the database
$conn = mysqli_connect("localhost", "root", "", "finance_manager");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch expense records for the specific user
$query = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Update expense entry
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $expense_name = $_POST['expense_name'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $expense_date = $_POST['expense_date'];
    $description = $_POST['description'];
    
    $update_query = "UPDATE expenses SET expense_name='$expense_name', amount='$amount', category='$category', expense_date='$expense_date', description='$description' WHERE id=$id AND user_id=$user_id";
    if (mysqli_query($conn, $update_query)) {
        echo "Expense updated successfully.<br>";
    } else {
        echo "Error updating expense: " . mysqli_error($conn);
    }
}

// Delete expense entry
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    $delete_query = "DELETE FROM expenses WHERE id=$id AND user_id=$user_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "Expense deleted successfully.<br>";
    } else {
        echo "Error deleting expense: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Expenses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
        }

        button[name="update"] {
            background-color: #28a745; /* Green color for Update button */
        }

        button[name="delete"] {
            background-color: #28a745; /* Green color for Delete button */
        }

        button:hover {
            opacity: 0.9;
        }

        /* Additional style for centering content */
        .container {
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>
<body>

<h2>Manage Expenses</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Expense Name</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Expense Date</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <form method="post">
                <td><?php echo $row['id']; ?></td>
                <td><input type="text" name="expense_name" value="<?php echo $row['expense_name']; ?>"></td>
                <td><input type="number" name="amount" value="<?php echo $row['amount']; ?>" step="0.01"></td>
                <td><input type="text" name="category" value="<?php echo $row['category']; ?>"></td>
                <td><input type="date" name="expense_date" value="<?php echo $row['expense_date']; ?>"></td>
                <td><input type="text" name="description" value="<?php echo $row['description']; ?>"></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update">Update</button>
                    <button type="submit" name="delete">Delete</button>
                </td>
            </form>
        </tr>
    <?php } ?>
</table>

</body>
</html>

<?php
mysqli_close($conn);
?>
