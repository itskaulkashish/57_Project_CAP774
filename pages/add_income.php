<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $income_title = $_POST['income_title'];
    $amount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];
    $income_type = $_POST['income_type'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO incomes (user_id, title, amount, date, type, description) 
    VALUES ('$user_id', '$income_title', '$amount', '$income_date', '$income_type', '$description')";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Income</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url('finance-sign.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            color: #34495e;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 2rem;
            font-size: 2.2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
            font-size: 0.9rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 1rem;
            background-color: #2c3e50;
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            margin-top: 1rem;
        }

        .btn:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
        }

        .btn:active {
            transform: translateY(0);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: none;
        }

        .success-message {
            background-color: #2ecc71;
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .input-error {
            border-color: #e74c3c;
        }

        .form-animate {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .floating-label {
            position: relative;
        }

        .floating-label label {
            position: absolute;
            left: 1rem;
            top: 0.8rem;
            background-color: white;
            padding: 0 0.3rem;
            transition: all 0.3s ease;
        }

        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            top: -0.5rem;
            font-size: 0.8rem;
            color: #3498db;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="successMessage" class="success-message">Income added successfully!</div>
    <h1><i class="fas fa-money-bill-wave"></i> Manage Income</h1>
    <form method="POST" id="incomeForm" class="form-animate">
        <div class="form-group floating-label">
            <div class="input-group">
                <input type="text" id="income_title" name="income_title" placeholder=" " required>
                <label for="income_title">Income Title</label>
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="error-message" id="titleError">Please enter a valid title</div>
        </div>

        <div class="form-group floating-label">
            <div class="input-group">
                <input type="number" id="income_amount" name="income_amount" placeholder=" " required>
                <label for="income_amount">Income Amount</label>
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
            <div class="error-message" id="amountError">Please enter a valid amount</div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input type="date" id="income_date" name="income_date" required>
                <i class="fas fa-calendar"></i>
            </div>
            <div class="error-message" id="dateError">Please select a date</div>
        </div>

        <div class="form-group">
            <select id="income_type" name="income_type" required>
                <option value="">Select Income Type</option>
                <option value="Freelance">Freelance</option>
                <option value="Shopify">Shopify</option>
                <option value="Youtube Adsense">Youtube Adsense</option>
                <option value="Developer Salary">Developer Salary</option>
            </select>
            <div class="error-message" id="typeError">Please select an income type</div>
        </div>

        <div class="form-group">
            <textarea id="description" name="description" placeholder="Add Description" rows="3"></textarea>
            <div class="error-message" id="descriptionError">Description is too long (max 500 characters)</div>
        </div>

        <button type="submit" class="btn" id="submitBtn">
            <i class="fas fa-plus-circle"></i> Add Income
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('incomeForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');

    // Form validation
    function validateForm(e) {
        let isValid = true;
        const title = document.getElementById('income_title');
        const amount = document.getElementById('income_amount');
        const date = document.getElementById('income_date');
        const type = document.getElementById('income_type');
        const description = document.getElementById('description');

        // Reset previous errors
        document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');
        document.querySelectorAll('input, select, textarea').forEach(input => input.classList.remove('input-error'));

        // Title validation
        if (title.value.trim().length < 3) {
            document.getElementById('titleError').style.display = 'block';
            title.classList.add('input-error');
            isValid = false;
        }

        // Amount validation
        if (amount.value <= 0) {
            document.getElementById('amountError').style.display = 'block';
            amount.classList.add('input-error');
            isValid = false;
        }

        // Date validation
        if (!date.value) {
            document.getElementById('dateError').style.display = 'block';
            date.classList.add('input-error');
            isValid = false;
        }

        // Type validation
        if (!type.value) {
            document.getElementById('typeError').style.display = 'block';
            type.classList.add('input-error');
            isValid = false;
        }

        // Description length validation
        if (description.value.length > 500) {
            document.getElementById('descriptionError').style.display = 'block';
            description.classList.add('input-error');
            isValid = false;
        }

        return isValid;
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return;
        }

        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('input-error')) {
                validateForm();
            }
        });
    });

    // Animation for inputs
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('input-focused');
            }
        });
    });
});
</script>
</body>
</html>