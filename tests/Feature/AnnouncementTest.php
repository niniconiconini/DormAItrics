<!-- ?php

use App\Models\User;

it('stores an announcement with the authenticated user as the author', function () {
    $user = User::factory()->create([
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $response = $this->actingAs($user)->post('/', [
        'message' => 'Hello everyone',
    ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('announcements', [
        'message' => 'Hello everyone',
        'author' => $user->id,
    ]);
}); -->
