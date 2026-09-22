<!-- ?php

use App\Models\User;

it('registers a user with profile information', function () {
    $response = $this->post(route('register'), [
        'lastname' => '',
        'firstname' => '',
        'middlename' => '',
        'nickname' => '',
        'birthdate' => '',
        'user_type' => '',
        'address' => '',
        'cellphone' => '',
        'email' => '',
        'password' => '',
        'accommodation_type' => '',
        'payment_schedule' => '',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => '',
        'lastname' => '',
    ]);

    expect(User::first()->lastname)->toBe('');
}); -->
