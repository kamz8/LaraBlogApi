<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Services\ResetPasswordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_send_reset_link_email()
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->postJson('/api/password/email', ['email' => $user->email]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Reset email link sent successfully, please check your inbox']);

        Mail::assertQueued(PasswordResetMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_reset_password()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $token = 'valid_token';
        $newPassword = 'new_password';

        $this->app->instance(ResetPasswordService::class, $this->createMock(ResetPasswordService::class));

        $this->mock(ResetPasswordService::class, function ($mock) use ($user, $token, $newPassword) {
            $mock->shouldReceive('validateEmailAndToken')->once()->with($user->email, $token)->andReturn(true);
            $mock->shouldReceive('updatePassword')->once()->with($user->email, $newPassword)->andReturn(true);
            $mock->shouldReceive('deleteToken')->once()->with($user->email)->andReturn(true);
        });

        $response = $this->postJson('/api/password/reset', [
            'email' => $user->email,
            'token' => $token,
            'newPassword' => $newPassword,
            'newPassword_confirmation' => $newPassword,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Password has been successfully reset.']);
    }
}
