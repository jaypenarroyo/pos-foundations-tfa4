<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="auth-card">
    <p class="eyebrow">Staff access</p>
    <h1>Log in to the POS</h1>
    <p class="lead">Enter a staff username and password to manage customer and user accounts.</p>

    <form class="data-form" action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= esc(old('username')) ?>" maxlength="50" autocomplete="username" required autofocus>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" maxlength="255" autocomplete="current-password" required>

        <button class="button" type="submit">Log in</button>
    </form>
</section>
<?= $this->endSection() ?>
