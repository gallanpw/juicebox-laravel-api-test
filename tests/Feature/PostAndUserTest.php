<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use App\Models\Post;

class PostAndUserTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setelah tiap test
    use WithFaker; // Menggunakan data random untuk testing

    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /** @test */
    #[Test]
    public function a_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@email.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertStatus(201) // Cek apakah berhasil
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email'],
                     'token',
                 ]);
    }

    /** @test */
    #[Test]
    public function it_can_get_user_by_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->getJson("/api/users/{$user->id}", [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'email' => $user->email,
                 ]);
    }

    /** @test */
    #[Test]
    public function it_can_create_a_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->postJson('/api/posts', [
            'title' => 'New Post',
            'content' => 'This is a test post.',
        ], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'title' => 'New Post',
                     'content' => 'This is a test post.',
                 ]);
    }

    /** @test */
    #[Test]
    public function it_can_get_post_by_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $post = Post::factory()->create(['user_id' => $user->id]);

        // $response = $this->getJson("/api/posts/{$post->id}");
        $response = $this->getJson("/api/posts/{$post->id}", [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $post->id,
                     'title' => $post->title,
                 ]);
    }

    #[Test]
    public function it_can_get_all_posts()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        // Buat beberapa post
        Post::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/posts', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'title', 'content', 'user_id'],
                    ],
                ]);
    }

    #[Test]
    public function it_can_update_a_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->patchJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'title' => 'Updated Title',
                    'content' => 'Updated Content',
                ]);
    }

    #[Test]
    public function it_can_soft_delete_a_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}", [], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Post deleted']);

        // Pastikan post masih ada di database tapi soft deleted
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    #[Test]
    public function it_can_logout_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        // Pastikan user bisa logout
        $response = $this->postJson('/api/logout', [], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Logged out successfully']);

        // Cek apakah token sudah dihapus
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test_token',
        ]);

        // Cek apakah token sudah tidak bisa digunakan
        $this->actingAs($user);
        $protectedResponse = $this->getJson('/api/posts');
        $protectedResponse->assertStatus(200);
    }

}
