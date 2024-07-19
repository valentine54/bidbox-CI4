<!-- app/Views/layouts/main.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Untitled' ?></title>
    <!-- Include your CSS stylesheets or CDN links here -->
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <!-- Your navigation bar or header -->
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Main content section -->
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer section -->
    <footer>
        <p>&copy; <?= date('Y') ?> Your Company</p>
    </footer>

    <!-- Include your JavaScript files or CDN links here -->
    <script src="path/to/your/script.js"></script>
</body>
</html>
