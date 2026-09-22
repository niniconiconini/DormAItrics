<!-- ?php

use App\Models\User;

it('creates a default dormer account when the database is empty and allows login', function () {
    $this->assertDatabaseCount('users', 0);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'email' => '',
        'password' => '',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => '',
    ]);
    expect(User::first()->email)->toBe('');
});

it('allows a user to log in with valid credentials', function () {
    $user = User::factory()->create([
        'email' => '',
        'password' => '',
    ]);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'email' => '',
        'password' => '',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
}); -->
