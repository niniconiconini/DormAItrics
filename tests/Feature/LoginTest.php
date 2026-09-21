<!-- ?php

use App\Models\User;

it('allows login with the default dormer account even when the database is empty', function () {
    $this->assertDatabaseCount('users', 0);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'email' => 'email@email.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'email@email.com',
    ]);
    expect(User::first()->email)->toBe('email@email.com');
});
-->