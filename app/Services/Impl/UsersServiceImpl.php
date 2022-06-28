<?php

namespace App\Services\Impl;

use App\Repository\UsersRepository;
use App\Services\UsersService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UsersServiceImpl implements UsersService {

    protected UsersRepository $usersRepository;


    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    

    public function addUserData($data)
    {

        $validation = Validator::make($data,[
            'name' => 'required',
            'birth_date' => 'required',
            'region' => 'required'
        ], 
        [
            'required' => 'Data tidak boleh ada yang kosong',
        ]);

        if($validation->fails()) {
            throw new InvalidArgumentException($validation->errors()->first());
        }

        $result = $this->usersRepository->save($data);

        return $result;
    }

    public function editUserData($data, $id) {

        DB::beginTransaction();

        try {
            $result = $this->usersRepository->update($data, $id);
        } catch(Exception $exception) {
            DB::rollBack();
            throw new Exception('Gagal Update Data');
        }
        
        DB::commit();

        return $result;
    }

    public function showAllUserData()
    {
        $result = $this->usersRepository->getAll();

        if($result->isEmpty()) {
            throw new Exception('Tidak ada data User');
        }

        return $result;
    }

    public function showUserDataById($id)
    {
        $result = $this->usersRepository->getById($id);

        if($result->isEmpty()) {
            throw new Exception('User tidak ditemukan');
        }

        return $result;

    }

    public function deleteUserDataById($id)
    {
        DB::beginTransaction();

        try{
            $result = $this->usersRepository->deleteByID($id);

        } catch(Exception $exception) {
            DB::rollBack();
            if($result == null) {
            throw new Exception('Gagal Menghapus user');
            }
        }
        DB::commit();
        
        return $result;
    }
}