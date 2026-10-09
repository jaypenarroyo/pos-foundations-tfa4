<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php $isEdit = $customer !== null; ?>
<section class="form-card">
    <p class="eyebrow">Customer management</p>
    <h1><?= $isEdit ? 'Edit customer' : 'Create customer' ?></h1>

    <form class="data-form" action="<?= $isEdit ? base_url('customers/' . $customer['id']) : base_url('customers') ?>" method="post">
        <?= csrf_field() ?>

        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" type="text" value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>" maxlength="100" required>

        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="<?= esc(old('email', $customer['email'] ?? '')) ?>" maxlength="100" required>

        <label for="phone">Phone number</label>
        <input id="phone" name="phone" type="text" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>" maxlength="20">

        <div class="form-actions">
            <button class="button" type="submit"><?= $isEdit ? 'Save changes' : 'Create customer' ?></button>
            <a class="button button-secondary" href="<?= base_url('customers') ?>">Cancel</a>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
