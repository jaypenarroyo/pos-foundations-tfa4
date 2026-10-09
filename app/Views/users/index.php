<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="page-heading">
    <p class="eyebrow">POS access</p>
    <h1>User Accounts</h1>
    <p class="lead">Staff records retrieved from MySQL through the UserModel.</p>
    <a class="button" href="<?= base_url('users/new') ?>">Add user</a>
</section>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Full name</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($users === []): ?>
                <tr>
                    <td colspan="4">No user records were found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><code><?= esc($user['username']) ?></code></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc(date('M j, Y', strtotime($user['created_at']))) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Delete this user?')">
                                    <?= csrf_field() ?>
                                    <button class="link-button danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
