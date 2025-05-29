<?php

namespace App\Http\Controllers\Client;

use App\Actions\Password\GeneratePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\DependentRequest;
use App\Http\Resources\UserResource;
use App\Models\Dependent;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class DepenentController extends Controller
{
    public function store(DependentRequest $request)
    {
        
        try {
            $userInputs = $request->validated();
            DB::transaction(function() use($userInputs) {
                $userInputs['type'] = "student";
                $password = GeneratePassword::run();
                $userInputs['password'] = bcrypt($password);
                $saveUser = User::firstOrNew(['email' => $userInputs['email']], $userInputs);
                $saveUser->save();
                if(!$saveUser) {
                    return response()->json(['error' => 'Ocorreu um erro ao tentar cadastrar o usuário'], 500);    
                }
                
                $saveDependent = Dependent::firstOrCreate(['user_id' => $saveUser->id], ["responsible_id" => auth()->id()]);

                return new UserResource($saveDependent);
            });

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $users = User::whereIn('id', function ($query) use ($user) {
            $query->select('user_id')
            ->from('dependents')
            ->where('responsible_id', $user->id);
        })->paginate();

        return UserResource::collection($users);
    }
}
