<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php $isEdit = $user !== null; ?>
<section class="form-card">
    <p class="eyebrow">User management</p>
    <h1><?= $isEdit ? 'Edit user' : 'Create user' ?></h1>

    <form class="data-form" action="<?= $isEdit ? base_url('users/' . $user['id']) : base_url('users') ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= esc(old('username', $user['username'] ?? '')) ?>" maxlength="50" required>

        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" type="text" value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>" maxlength="100" required>

        <label for="password">Password<?= $isEdit ? ' (leave blank to keep the current password)' : '' ?></label>
        <input id="password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" <?= $isEdit ? '' : 'required' ?>>

        <div class="form-actions">
            <button class="button" type="submit"><?= $isEdit ? 'Save changes' : 'Create user' ?></button>
            <a class="button button-secondary" href="<?= base_url('users') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
