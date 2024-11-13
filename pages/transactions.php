<?php
include '../includes/auth.php';
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Fetch all incomes
$incomes = mysqli_query($conn, "SELECT * FROM incomes WHERE user_id = '$user_id' ORDER BY date DESC");

// Fetch all expenses
$expenses = mysqli_query($conn, "SELECT * FROM expenses WHERE user_id = '$user_id' ORDER BY expense_date DESC");

// Fetch monthly totals for income and expenses
$monthly_income = mysqli_query($conn, "SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS total FROM incomes WHERE user_id = '$user_id' GROUP BY month ORDER BY month");
$monthly_expenses = mysqli_query($conn, "SELECT DATE_FORMAT(expense_date, '%Y-%m') AS month, SUM(amount) AS total FROM expenses WHERE user_id = '$user_id' GROUP BY month ORDER BY month");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Transactions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        h1 { text-align: center; margin-top: 20px; }
        .container { max-width: 900px; margin: auto; padding: 20px; }
        table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .chart-container { display: flex; justify-content: space-between; }
        .chart-container > div { width: 48%; }
        .income, .expense { font-size: 1.2em; margin-bottom: 5px; color: #2c3e50; }
        .income i, .expense i { margin-right: 5px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <h1>All Transactions</h1>

    <div class="income">
        <i class="fas fa-coins"></i> Incomes
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($income = mysqli_fetch_assoc($incomes)) { ?>
                <tr>
                    <td><?php echo $income['date']; ?></td>
                    <td><?php echo $income['description']; ?></td>
                    <td><?php echo number_format($income['amount'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="expense">
        <i class="fas fa-money-bill-wave"></i> Expenses
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($expense = mysqli_fetch_assoc($expenses)) { ?>
                <tr>
                    <td><?php echo $expense['expense_date']; ?></td>
                    <td><?php echo $expense['description']; ?></td>
                    <td><?php echo number_format($expense['amount'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="chart-container">
        <div>
            <canvas id="incomeChart"></canvas>
        </div>
        <div>
            <canvas id="expenseChart"></canvas>
        </div>
    </div>
</div>

<script>
// Prepare data for income chart
const incomeData = {
    labels: [
        <?php while ($row = mysqli_fetch_assoc($monthly_income)) { echo '"' . $row['month'] . '",'; } ?>
    ],
    datasets: [{
        label: 'Monthly Income',
        backgroundColor: '#4CAF50',
        borderColor: '#4CAF50',
        data: [
            <?php mysqli_data_seek($monthly_income, 0); while ($row = mysqli_fetch_assoc($monthly_income)) { echo $row['total'] . ','; } ?>
        ]
    }]
};

// Prepare data for expense chart
const expenseData = {
    labels: [
        <?php while ($row = mysqli_fetch_assoc($monthly_expenses)) { echo '"' . $row['month'] . '",'; } ?>
    ],
    datasets: [{
        label: 'Monthly Expenses',
        backgroundColor: '#F44336',
        borderColor: '#F44336',
        data: [
            <?php mysqli_data_seek($monthly_expenses, 0); while ($row = mysqli_fetch_assoc($monthly_expenses)) { echo $row['total'] . ','; } ?>
        ]
    }]
};

// Income chart
const incomeCtx = document.getElementById('incomeChart').getContext('2d');
const incomeChart = new Chart(incomeCtx, {
    type: 'line',
    data: incomeData,
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Month' } },
            y: { title: { display: true, text: 'Amount' } }
        }
    }
});

// Expense chart
const expenseCtx = document.getElementById('expenseChart').getContext('2d');
const expenseChart = new Chart(expenseCtx, {
    type: 'line',
    data: expenseData,
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Month' } },
            y: { title: { display: true, text: 'Amount' } }
        }
    }
});
</script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
