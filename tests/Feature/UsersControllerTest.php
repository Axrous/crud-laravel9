<?php

namespace Tests\Feature;

use App\Repository\UsersRepository;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{

    protected function setUp():void
    {
        parent::setUp();
        
        $userRepository = $this->app->make(UsersRepository::class);

        $userRepository->deleteAll();
    }
    


    public function testUsersPostSuccess() {
        $this->post('/api/user/data', [
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ])->assertStatus(200)
        ->assertSeeText('Arga')->assertSeeText('Bandung')->assertSeeText('160801');
    }
    
    public function testUsersPostFailed() {
        $this->post('/api/user/data', [
            'name' => 'Arga',
            'birth_date' => 160801,
        ])->assertStatus(500)->assertSeeText('Data tidak boleh ada yang kosong');
    }

    public function testGetAll() {
        $this->post('/api/user/data', [
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ]);
        $this->post('/api/user/data', [
            'name' => 'Satya',
            'birth_date' => 100800,
            'region' => 'Garut'
        ]);

        $this->get('/api/users')->assertStatus(200)
        ->assertSeeText('Arga')
        ->assertSeeText('Satya');
    }

    public function testGetAllEmpty() {
        $this->get('/api/users')->assertStatus(500)->assertSeeText("Tidak ada data User");
    }

    public function testGetUserByIdSuccess() {
        $this->post('/api/user/data', [
            // 'id' => 1
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ]);
        $this->post('/api/user/data', [
            // 'id' => 2
            'name' => 'Satya',
            'birth_date' => 100800,
            'region' => 'Garut'
        ]);

        $this->get('/api/users/1')->assertStatus(200)
        ->assertSeeText('Arga')->assertSeeText('160801')->assertSeeText('Bandung');
        
        $this->get('/api/users/2')->assertStatus(200)
        ->assertSeeText('Satya')->assertSeeText('100800')->assertSeeText('Garut');
    }

    public function testGetUserByIdNotFound() {
        $this->get('api/users/1')->assertStatus(500)->assertSeeText('User tidak ditemukan');
    }

    public function testUpdateUsers() {
        $this->post('/api/user/data', [
            // 'id' => 1
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ]);

        $this->put('/api/users/1', [
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Garut'
        ])->assertSeeText('Garut')->assertStatus(200);
    }

    public function testUpdateUsersFailed() {
        $this->post('/api/user/data', [
            // 'id' => 1
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ]);

        $this->put('/api/users/1', [
            'name' => 'Arga',
            'birth_date' => 160801,
        ])->assertSeeText('Gagal Update Data')->assertStatus(500);
    }

    public function testDeleteUsersSuccess() {
        $this->post('/api/user/data', [
            // 'id' => 1
            'name' => 'Arga',
            'birth_date' => 160801,
            'region' => 'Bandung'
        ]);

        $this->delete('/api/users/delete/1')->assertStatus(200);
    }

}
