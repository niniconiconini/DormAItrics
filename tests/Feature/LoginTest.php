<!-- ?php

use App\Models\User;

it('allows login with the default dormer account even when the database is empty', function () {
    $this->assertDatabaseCount('users', 0);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'email' => 'resurreccion.nini@gmail.com',
        'password' => 'spum123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'resurreccion.nini@gmail.com',
    ]);
    expect(User::first()->email)->toBe('resurreccion.nini@gmail.com');
});
-->