<?php

namespace Tests\Feature;

use App\Repository\UsersRepository;
use App\Services\UsersService;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

class UsersServiceTest extends TestCase
{   
    protected UsersService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UsersService::class);
        $userRepository = $this->app->make(UsersRepository::class);

        $userRepository->deleteAll();
    }

    public function testSaveSuccess() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];

        $this->userService->addUserData($data);
        $result = $this->userService->showUserDataById(1);

        $this->assertEquals($data['name'], $result[0]['name']);
    }

    public function testSaveFailed() {

        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
        ];

        $this->expectExceptionMessage('Data tidak boleh ada yang kosong');
        $this->userService->addUserData($data);
    }

    public function testUpdateSuccess() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];

        $this->userService->addUserData($data);

        $data1 = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];

        $this->userService->editUserData($data1, 1);

        $result = $this->userService->showUserDataById(1);

        $this->assertEquals($data1['region'], $result[0]['region']);
    }

    public function testUpdateFailed() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];

        $this->userService->addUserData($data);

        $data1 = [
            'name' => 'Arga',
            'region' => 'Garut'
        ];

        $this->expectExceptionMessage('Gagal Update Data');
        $this->userService->editUserData($data1, 1);
    }

    public function testGetAllSuccess() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];
        $data1 = [
            'name' => 'Satya',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];
        $this->userService->addUserData($data);
        $this->userService->addUserData($data1);

        $result = $this->userService->showAllUserData();

        $this->assertNotEmpty($result);
    }

    public function testGettAllEmpty() {

        $this->expectExceptionMessage('Tidak ada data User');;

        $result = $this->userService->showAllUserData();

        $this->assertEmpty($result);
    }

    public function testGetUserByIdSuccess() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];

        $this->userService->addUserData($data);

        $result = $this->userService->showUserDataById(1);

        assertEquals($data['name'], $result[0]['name']);
    }

    public function testGetUserByIdNotFound() {

        $this->expectExceptionMessage('User tidak ditemukan');

        $this->userService->showUserDataById(2);
    }


    public function testDeleteUserByIdSuccess() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];

        $this->userService->addUserData($data);
        $result = $this->userService->showUserDataById(1);
        assertEquals($data['name'], $result[0]['name']);

        $this->userService->deleteUserDataById(1);
        $this->expectExceptionMessage('User tidak ditemukan');;
        $result = $this->userService->showUserDataById(1);
        var_dump($result);

    }

    // public function testDeleteUserByIdFailed() {
    //     $result = $this->userService->deleteUserDataById(1);    
    //     $this->assertNull($result);
    // } 



    


}
