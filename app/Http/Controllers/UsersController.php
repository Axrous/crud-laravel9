<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Services\UsersService;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    protected UsersService $usersService;


    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postUsers(Request $request)
    {
        $data = $request->only([
            'name',
            'birth_date',
            'region'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->usersService->addUserData($data);
        } catch(Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getAllUsers() {

        $result = [
            'status' => 200
        ];
        try {
            $result['data'] = $this->usersService->showAllUserData();
        } catch(Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getUserById(Request $request, string $id) {

        $result = [
            'status' => 200
        ];

        try{
            $result['data'] = $this->usersService->showUserDataById($id);
        } catch(Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function editUser(Request $request, string $id) {
        $data = $request->only([
            'name',
            'birth_date',
            'region'
        ]);

        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->usersService->editUserData($data, $id);
        } catch(Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function deleteUser($id) {

        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->usersService->deleteUserDataById($id);
        } catch(Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
