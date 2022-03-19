<?php 
namespace App\Services;

use App\Models\Professor;
use Illuminate\Support\Facades\DB;

class ProfessorService
{
    public function create(
        int $departmentID,
        string $prefix,
        string $employmentType,
        string $firstName,
        string $lastName,
        string $birthedAt,
        array $subjectIDs,
    ): bool|string {
        try {
            DB::transaction(function () use (
                $departmentID,
                $prefix,
                $employmentType,
                $firstName,
                $lastName,
                $birthedAt,
                $subjectIDs,
            )
            {
                $professorData = [
                    'department_id' => $departmentID,
                    'prefix' => $prefix,
                    'employment_type' => $employmentType,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'birthed_at' => $birthedAt
                ];

                $professor = Professor::create($professorData);
                $professor->subjects()->attach($subjectIDs);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    public function update(
        Professor $professor,
        int $departmentID,
        string $prefix,
        string $employmentType,
        string $firstName,
        string $lastName,
        string $birthedAt,
        array $subjectIDs,
    ): bool|string {
        try {
            DB::transaction(function () use (
                $professor,
                $departmentID,
                $prefix,
                $employmentType,
                $firstName,
                $lastName,
                $birthedAt,
                $subjectIDs,
            )
            {
                $professorData = [
                    'department_id' => $departmentID,
                    'prefix' => $prefix,
                    'employment_type' => $employmentType,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'birthed_at' => $birthedAt
                ];

                $professor->update($professorData);
                $professor->subjects()->sync($subjectIDs);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}