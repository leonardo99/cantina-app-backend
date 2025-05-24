<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $userInputs = $request->validated();
        $userInputs['password'] = bcrypt($userInputs['password']);
        try {
            $saveUser = User::firstOrNew(['email' => $userInputs['email']], $userInputs);
            $saveUser->save();
            if(!$saveUser) {
                return response()->json(['error' => 'Ocorreu um erro ao tentar cadastrar o usuário'], 500);    
            }

            return new UserResource($saveUser);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
