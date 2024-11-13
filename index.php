<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('finance-bg.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            color: #34495e;
        }

        .overlay {
            background: rgba(255, 255, 255, 0.9);
            padding-top: 8rem;
            padding-bottom: 4rem;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-links {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #27ae60;
        }

        .container {
            border-radius: 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        p {
            color: #34495e;
            font-size: 1.2rem;
            line-height: 1.6;
            max-width: 800px;
            margin: 1rem auto;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: scale(1.05);
        }

        .feature-card h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .auth-options {
            margin-top: 3rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            margin: 0 1rem;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #27ae60;
        }

        #about {
            background-color: #f7f7f7;
            padding: 4rem 2rem;
            margin-top: 4rem;
        }

        #about h2 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        footer {
            background-color: #2c3e50;
            padding: 1rem 2rem;
            text-align: center;
            margin-top: 3rem;
        }
        footer p{
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About Us</a>
            <a href="#signin">Sign In</a>
        </div>
    </nav>

    <div class="container overlay" id="home">
        <h1>Welcome to Personal Finance Manager</h1>
        <p>Take control of your financial future with our comprehensive personal finance management solution. Track expenses, monitor income, and make informed financial decisions with ease.</p>

        <div class="features">
            <div class="feature-card">
                <h3>Expense Tracking</h3>
                <p>Easily log and categorize your daily expenses to understand your spending patterns.</p>
            </div>
            <div class="feature-card">
                <h3>Budget Planning</h3>
                <p>Create and manage budgets to help you reach your financial goals.</p>
            </div>
            <div class="feature-card">
                <h3>Reports & Analytics</h3>
                <p>Gain insights through detailed financial reports and visual analytics.</p>
            </div>
        </div>

        <div class="auth-options" id="signin">
            <a href="pages/signup.php" class="btn">Sign Up</a>
            <a href="pages/signin.php" class="btn">Sign In</a>
        </div>
    </div>

    <!-- About Us Section -->
    <section id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>We are dedicated to helping individuals and families take control of their finances. With years of experience in personal finance and technology, we have created this platform to make financial management easy, intuitive, and effective. Join our growing community and start building a secure financial future today.</p>
            <p>Our mission is to empower users to make informed decisions about their money and to provide tools that simplify financial planning and management.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Personal Finance Manager | All Rights Reserved</p>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
