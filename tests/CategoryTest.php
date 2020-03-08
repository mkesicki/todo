<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Categories;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPost()
    {

        $user = factory('App\Users')->create();

        $this->actingAs($user)->json('POST', '/api/v1/category', 
            [
                "name"=> "test",
                "description"=> "description",
            ]
        );
        $this->assertResponseStatus(201);
    }

    public function testPut()
    {

        $user = factory('App\Users')->create();

        $category = factory('App\Categories')->create();
        $this->actingAs($user)->json('PUT', '/api/v1/category/'.$category->id, 
            [
                "name"=> 'new name',
                "description"=> "description edit",
            ]
        );
        $this->assertResponseStatus(204);
    }

    public function testGet()
    {

        $user = factory('App\Users')->create();

        $category = factory('App\Categories')->create();
        $this->actingAs($user)->get('/api/v1/category/'.$category->id)
            ->seeJson([
                'name' => $category->name,
            ]);
        $this->assertResponseStatus(200);
    }

    public function testDelete()
    {
        $user = factory('App\Users')->create();

        $category = factory('App\Categories')->create();
        $this->actingAs($user)->delete('/api/v1/category/'.$category->id);
        $this->assertResponseStatus(204);
        $this->actingAs($user)->get('/api/v1/category/'.$category->id);
        $this->assertResponseStatus(404);
    }
}
