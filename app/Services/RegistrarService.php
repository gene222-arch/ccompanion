<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegistrarService 
{
    public function create(
        string $firstName, 
        string $lastName, 
        string $birthedAt, 
        int $departmentID,
        string $email,
        string $password
    ): bool|string
    {
        try {
            DB::transaction(function () use (
                $firstName,
                $lastName,
                $birthedAt,
                $departmentID,
                $email,
                $password,
            ) 
            {
                $registrarRole = Role::findByName('Registrar');
                $userData = [
                    'name' => "{$firstName} {$lastName}",
                    'email' => $email,
                    'password' => Hash::make($password)
                ];

                $user = User::create($userData);
                $user->assignRole($registrarRole);

                $user->registrar()
                    ->create([
                        'department_id' => $departmentID,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'birthed_at' => $birthedAt
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}