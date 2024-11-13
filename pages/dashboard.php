<?php
include '../includes/auth.php'; // Ensures user is signed in
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Fetch total income
$income_result = mysqli_query($conn, "SELECT SUM(amount) AS total_income FROM incomes WHERE user_id = '$user_id'");
$income = mysqli_fetch_assoc($income_result)['total_income'];

// Fetch total expenses
$expense_result = mysqli_query($conn, "SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = '$user_id'");
$expenses = mysqli_fetch_assoc($expense_result)['total_expenses'];

// Calculate balance
$balance = $income - $expenses;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        .sidebar h3, .sidebar a {
            color: #f8f9fa;
            text-align: center;
            text-decoration: none;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            margin: 10px 0;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
            border-radius: 4px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .card {
            margin-top: 20px;
        }
        .chart-container {
            width: 100%;
            max-width: 300px; /* Fixed width to keep chart small */
            margin: 0 auto;
        }
        .toggle-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.5rem;
            color: #343a40;
            cursor: pointer;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="toggle-btn" onclick="toggleSidebar()">&#9776;</div>

    <div class="sidebar" id="sidebar">
        <h3>Welcome</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transactions.php">View Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_income.php">Add Income</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_income.php">Manage Income</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_expense.php">Add Expense</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_expense.php">Manage Expense</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signout.php">Sign Out</a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="main-content">
        <h2>Financial Summary</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Income</h5>
                <p class="card-text"><?php echo "Rs. " . number_format($income, 2); ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Expenses</h5>
                <p class="card-text"><?php echo "Rs. " . number_format($expenses, 2); ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Balance</h5>
                <p class="card-text"><?php echo "Rs. " . number_format($balance, 2); ?></p>
            </div>
        </div>

        <div class="card chart-container mt-3">
            <div class="card-body">
                <h5 class="card-title">Income vs Expenses</h5>
                <canvas id="incomeExpenseChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("main-content");
            if (sidebar.style.width === "0px") {
                sidebar.style.width = "250px";
                mainContent.style.marginLeft = "250px";
            } else {
                sidebar.style.width = "0";
                mainContent.style.marginLeft = "0";
            }
        }

        // Chart setup for income vs expenses
        const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    label: 'Income vs Expenses',
                    data: [<?php echo $income; ?>, <?php echo $expenses; ?>],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderColor: ['#28a745', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rs. ' + context.raw.toLocaleString();
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
