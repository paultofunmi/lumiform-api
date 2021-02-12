<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;

class AuthAPIControllerTest extends TestCase
{
    private string $LOGIN_URL = '/api/auth/login';
    private string $REGISTER_URL = '/api/auth/register';

    public function testRegisterUser_WithEmptyPayload_Assert422(): void
    {

        $this->json('POST', $this->REGISTER_URL, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRegisterUser_WithValidPayload_Asset200(): void
    {

        $payload = [
            "name" => "test",
            "email" => "test@account.com",
            "password" => "password123",
            "password_confirmation" => "password123"
        ];

        $response = $this->json('POST', $this->REGISTER_URL, $payload);

        $response->assertStatus(200);

        $responseAsArray = json_decode($response->content(), true);
        $this->assertArrayHasKey('user', $responseAsArray);
        $this->assertArrayHasKey('access_token', $responseAsArray);
    }

    public function testRegisterUser_WithoutPasswordConfirmation_Asset422()
    {

        $payload = [
            "name" => "test",
            "email" => "test@account.com",
            "password" => "password123"
        ];

        $this->json('POST', $this->REGISTER_URL, $payload, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password confirmation does not match."],
                ]
            ]);
    }

    public function testRegisterUser_WithoutPasswordField_Asset422()
    {

        $payload = [
            "name" => "test",
            "email" => "test@account.com"
        ];

        $this->json('POST', $this->REGISTER_URL, $payload, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testLoginUser_WithoutEmailAndPassword_Assert422(){

        $this->json('POST', $this->LOGIN_URL, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testLoginUser_WithEmailAndPassword_Assert200(){

        $email = "paul.tofunmi@lumiform.com";
        $password = "spaceship";


        $user = factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);


        $payload = ['email' => $email, 'password' => $password];

        $this->json('POST', $this->LOGIN_URL, $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "user" => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                "access_token"
            ]);

        $this->assertAuthenticated();
    }
}
