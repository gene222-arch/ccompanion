<?php 
namespace App\Services;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\User;
use App\Notifications\MailStudentNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    public function create(
        string $firstName,
        string $lastName,
        string $email,
        int $courseID,
        int $departmentID,
        string $guardian,
        string $contactNumber,
        string $birthedAt
    ): bool|string 
    {
        try {
            DB::transaction(function () 
                use (
                    $firstName,
                    $lastName,
                    $email,
                    $courseID,
                    $departmentID,
                    $guardian,
                    $contactNumber,
                    $birthedAt,
                )
            {
                $password = Str::random(10);

                $userData = [
                    'name' => "{$firstName} {$lastName}",
                    'email' => $email,
                    'password' => Hash::make($password)
                ];

                $user = User::create($userData);
                $user->assignRole('Student');
                
                $user->student()->create([
                    'student_id' => $this->studentID(),
                    'course_id' => $courseID,
                    'department_id' => $departmentID,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'guardian' => $guardian,
                    'contact_number' => $contactNumber,
                    'birthed_at' => $birthedAt
                ]);

                $user->notify(
                    new MailStudentNotification($password)
                );
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    public function update(
        Student $student,
        string $firstName,
        string $lastName,
        string $email,
        int $courseID,
        int $departmentID,
        string $guardian,
        string $contactNumber,
        string $birthedAt
    ): bool|string 
    {
        try {
            DB::transaction(function () 
                use (
                    $student,
                    $firstName,
                    $lastName,
                    $email,
                    $courseID,
                    $departmentID,
                    $guardian,
                    $contactNumber,
                    $birthedAt,
                )
            {
                $student->user()->update([
                    'name' => "{$firstName} {$lastName}",
                    'email' => $email,
                ]);
                
                $student->update([
                    'course_id' => $courseID,
                    'department_id' => $departmentID,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'guardian' => $guardian,
                    'contact_number' => $contactNumber,
                    'birthed_at' => $birthedAt
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    public function studentID(): string
    {
        $id = Student::all()->count() ? Student::all()->last()->value('id') + 1 : 1;
        $length = Str::length($id);

        $prependZeros = match($length) {
            1 => '000',
            2 => '00',
            3 => '0',
            4 => ''
        };

        $id = $prependZeros . $id;

        return Carbon::now()->format('Y') . " - {$id}";
    }
}