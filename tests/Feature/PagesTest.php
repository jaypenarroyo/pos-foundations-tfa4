<?php

namespace Tests\Feature;

use App\Database\Seeds\PosSeeder;
use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

final class PagesTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $basePath  = APPPATH . 'Database';
    protected $seed      = PosSeeder::class;

    public function testPublicPagesLoad(): void
    {
        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('Your first POS application');

        $about = $this->get('/about');
        $about->assertStatus(200);
        $about->assertSee('Authenticated database management');

        $login = $this->get('/login');
        $login->assertStatus(200);
        $login->assertSee('Log in to the POS');
    }

    public function testGuestCannotOpenProtectedPages(): void
    {
        $this->get('/customers')->assertRedirectTo('/login');
        $this->get('/customers/new')->assertRedirectTo('/login');
        $this->get('/users')->assertRedirectTo('/login');
        $this->get('/users/1/edit')->assertRedirectTo('/login');
    }

    public function testSeededPasswordIsHashedAndVerifiable(): void
    {
        $user = (new UserModel())->where('username', 'admin')->first();

        $this->assertNotNull($user);
        $this->assertNotSame('Password123!', $user['password']);
        $this->assertTrue(password_verify('Password123!', $user['password']));
    }

    public function testIncorrectLoginIsRejected(): void
    {
        [$session, $csrf] = $this->csrfSession();
        $result = $this->withSession($session)->post('/login', $csrf + [
            'username' => 'admin',
            'password' => 'wrong-password',
        ]);

        $result->assertRedirect();
        $result->assertSessionMissing('isLoggedIn');
    }

    public function testCorrectLoginStartsAuthenticatedSession(): void
    {
        [$session, $csrf] = $this->csrfSession();
        $result = $this->withSession($session)->post('/login', $csrf + [
            'username' => 'admin',
            'password' => 'Password123!',
        ]);

        $result->assertRedirectTo('/customers');
        $result->assertSessionHas('isLoggedIn', true);
        $result->assertSessionHas('username', 'admin');
    }

    public function testAuthenticatedUserCanOpenProtectedPages(): void
    {
        $session = $this->authenticatedSession();

        $customers = $this->withSession($session)->get('/customers');
        $customers->assertStatus(200);
        $customers->assertSee('Maria Santos');

        $newCustomer = $this->withSession($session)->get('/customers/new');
        $newCustomer->assertStatus(200);
        $newCustomer->assertSee('Create customer');

        $users = $this->withSession($session)->get('/users');
        $users->assertStatus(200);
        $users->assertSee('Andrea Lim');

        $editUser = $this->withSession($session)->get('/users/1/edit');
        $editUser->assertStatus(200);
        $editUser->assertSee('Edit user');
    }

    public function testAuthenticatedUserCanCreateCustomer(): void
    {
        [$session, $csrf] = $this->csrfSession($this->authenticatedSession());
        $result = $this->withSession($session)->post('/customers', $csrf + [
            'full_name' => 'Test Customer',
            'email'     => 'test.customer@example.com',
            'phone'     => '0999-000-0000',
        ]);

        $result->assertRedirectTo('/customers');
        $this->seeInDatabase('customers', ['email' => 'test.customer@example.com']);
    }

    public function testLogoutDestroysAuthenticatedSession(): void
    {
        [$session, $csrf] = $this->csrfSession($this->authenticatedSession());
        $result = $this->withSession($session)->post('/logout', $csrf);

        $result->assertRedirectTo('/login');
        $this->assertFalse(session()->has('isLoggedIn'));
    }

    private function authenticatedSession(): array
    {
        return [
            'user_id'    => 1,
            'username'   => 'admin',
            'full_name'  => 'Andrea Lim',
            'isLoggedIn' => true,
        ];
    }

    private function csrfSession(array $session = []): array
    {
        $tokenName         = config('Security')->tokenName;
        $tokenHash         = bin2hex(random_bytes(16));
        $session[$tokenName] = $tokenHash;

        return [$session, [$tokenName => $tokenHash]];
    }
}
