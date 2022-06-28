<?php

namespace Tests\Feature;

use App\Repository\UsersRepository;
use Tests\TestCase;

class UsersRepositoryTest extends TestCase
{

    protected UsersRepository $usersRepository;


        protected function setUp():void
    {
        parent::setUp();
        $this->usersRepository = $this->app->make(UsersRepository::class);
        $this->usersRepository->deleteAll();
    }
    

    public function testSaveSuccess() {

        $data = [
            'name' => 'arga',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];
        $this->usersRepository->save($data);
        $result1 = $this->usersRepository->getById(1);

        $data2 = [
            'name' => 'Satya',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];
        $this->usersRepository->save($data2);
        
        $result2 = $this->usersRepository->getById(2);

        $this->assertEquals($data['name'], $result1[0]['name']);
        // $this->assertNotEquals($data['name'], $result2[0]['name']);
        // dump($result);

    }

    public function testGetAll() {
        $data = [
            'name' => 'Arga',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];

        $data1 = [
            'name' => 'Satya',
            'birth_date' => '160801',
            'region' => 'Bandung'
        ];
        $data2 = [
            'name' => 'Mulyono',
            'birth_date' => '160801',
            'region' => 'Madura'
        ];
        

        $this->usersRepository->save($data);
        $this->usersRepository->save($data1);
        $this->usersRepository->save($data2);

        $result = $this->usersRepository->getAll();
        dump($result);
        $this->assertNotEmpty($result);
    }

    public function testDeleteByid() {

        $data = [
            'name' => 'arga',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];
        $this->usersRepository->save($data);
        $result1 = $this->usersRepository->getById(1);
        $this->assertEquals($data['name'], $result1[0]['name']);

        $result = $this->usersRepository->deleteByID(1);

        $this->assertNull($result);

    }

    public function testUpdateSuccess() {
        $data = [
            'name' => 'arga',
            'birth_date' => '160801',
            'region' => 'Garut'
        ];
        $this->usersRepository->save($data);

        $data1 = [
            'name' => 'Arga',
            'region' => 'Bandung',
            'birth_date' => '160801'
        ];

        $this->usersRepository->update($data1, 1);

        $result = $this->usersRepository->getById(1);
        $this->assertEquals($data1['region'], $result[0]['region']);
    }

    
}
