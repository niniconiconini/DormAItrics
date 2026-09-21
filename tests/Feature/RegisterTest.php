<!-- ?php

use App\Models\User;

it('registers a user with profile information', function () {
    $response = $this->post(route('register'), [
        'lastname' => 'Dela Cruz',
        'firstname' => 'Maria',
        'middlename' => 'Santos',
        'nickname' => 'Mia',
        'birthdate' => '2000-01-01',
        'user_type' => 'student',
        'address' => '123 Main St',
        'cellphone' => '09123456789',
        'email' => 'maria@example.com',
        'password' => 'secret123',
        'accommodation_type' => '2_in_room',
        'payment_schedule' => '4_equal_payments',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'maria@example.com',
        'lastname' => 'Dela Cruz',
    ]);

    expect(User::first()->lastname)->toBe('Dela Cruz');
}); -->
