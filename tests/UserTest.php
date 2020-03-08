<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Users;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $this->json('POST', '/api/v1/register', 
            [
                "email"=> "john@example.com",
                "password"=> "123445678",
                "gender"=> "male",
                "phone"=> "123456789",
                "firstname"=> "John",
                "lastname"=> "doe",
                "birthdate"=> "1983-06-05"
            ]
        );
        $this->assertResponseStatus(201);
    }

    public function testUserRegistrationExist()
    {

        $user = factory('App\Users')->create();
        $this->json('POST', '/api/v1/register', 
            [
                "email"=> $user->email,
                "password"=> "123445678",
                "gender"=> "male",
                "phone"=> "123456789",
                "firstname"=> "John",
                "lastname"=> "doe",
                "birthdate"=> "1983-06-05"
            ]
        );
        $this->assertResponseStatus(400);
    }

    public function testUserLogin()
    {
        $user = factory('App\Users')->create();
        $this->get('/api/v1/login?email='.$user->email.'&password=123445678'); 
        $this->assertResponseStatus(200);
    }
}
