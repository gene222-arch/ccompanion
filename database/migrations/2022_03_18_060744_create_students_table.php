<?php

use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->foreignIdFor(User::class)->unique()->constrained();
            $table->foreignIdFor(Course::class)->constrained();
            $table->foreignIdFor(Department::class)->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('guardian');
            $table->string('contact_number')->unique();
            $table->timestamp('birthed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
