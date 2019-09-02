<?php

namespace Tests\Feature\Athentication;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class register extends TestCase
{
    /**
     * Register Test Case
     *
     * @return void
     */
    public function testRegister()
    {
        $data = ['email' => 'saeed.fadakar@gmail.com',
            'password' => '123456',
            'name' => 'Saeed Fadakar'];

        $response = $this->post('api/auth/register', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(["message" ,
            "data" => [
                "user_id",
                "token",
                "name"
            ]
        ]);
    }


}
