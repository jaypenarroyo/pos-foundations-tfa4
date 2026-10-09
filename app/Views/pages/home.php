<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="hero">
    <p class="eyebrow">CodeIgniter 4 Point of Sale</p>
    <h1>Your first POS application</h1>
    <p class="lead">
        Explore a simple four-page website built with routes, controllers, views,
        CodeIgniter Models, Query Builder, MySQL, sessions, and secure authentication.
    </p>
    <div class="actions">
        <?php if (session()->get('isLoggedIn') === true): ?>
            <a class="button" href="<?= base_url('customers') ?>">Manage customers</a>
            <a class="button button-secondary" href="<?= base_url('users') ?>">Manage users</a>
        <?php else: ?>
            <a class="button" href="<?= base_url('login') ?>">Staff login</a>
        <?php endif ?>
    </div>
</section>

<section class="feature-grid" aria-label="Application features">
    <article>
        <h2>Four working routes</h2>
        <p>Home, About, Customer Accounts, and User Accounts are connected through the navigation.</p>
    </article>
    <article>
        <h2>MVC structure</h2>
        <p>Routes send requests to controllers, and controllers provide data to reusable views.</p>
    </article>
    <article>
        <h2>Protected management</h2>
        <p>A CodeIgniter filter restricts customer and user management to authenticated staff.</p>
    </article>
</section>
<?= $this->endSection() ?>
