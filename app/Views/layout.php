<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A CodeIgniter POS application with sessions and authentication">
    <title><?= esc($title) ?> | POS Foundations</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="<?= base_url('/') ?>">POS Foundations</a>
            <nav aria-label="Main navigation">
                <a href="<?= base_url('/') ?>">Home</a>
                <a href="<?= base_url('about') ?>">About</a>
                <?php if (session()->get('isLoggedIn') === true): ?>
                    <a href="<?= base_url('customers') ?>">Customers</a>
                    <a href="<?= base_url('users') ?>">Users</a>
                    <span class="signed-in-user"><?= esc((string) session()->get('full_name')) ?></span>
                    <form class="nav-form" action="<?= base_url('logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button class="nav-button" type="submit">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>">Login</a>
                <?php endif ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if ($success = session()->getFlashdata('success')): ?>
            <div class="notice notice-success" role="status"><?= esc($success) ?></div>
        <?php endif ?>

        <?php if ($error = session()->getFlashdata('error')): ?>
            <div class="notice notice-error" role="alert"><?= esc($error) ?></div>
        <?php endif ?>

        <?php if ($errors = session()->getFlashdata('errors')): ?>
            <div class="notice notice-error" role="alert">
                <strong>Please correct the following:</strong>
                <ul>
                    <?php foreach ($errors as $message): ?>
                        <li><?= esc($message) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> POS Foundations</p>
    </footer>
</body>
</html>
