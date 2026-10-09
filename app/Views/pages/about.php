<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="page-heading">
    <p class="eyebrow">About the project</p>
    <h1>Built to demonstrate CodeIgniter foundations</h1>
    <p class="lead">
        POS Foundations is a beginner-friendly application that demonstrates URL routing,
        controllers, views, models, Query Builder, sessions, password hashing, and route filters.
    </p>
</section>

<section class="content-section">
    <h2>Authenticated database management</h2>
    <p>
        Customer and staff records are stored in MySQL. Login credentials are verified against
        password hashes, and an authentication filter protects all account-management routes.
    </p>
</section>
<?= $this->endSection() ?>
