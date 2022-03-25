<?php

use App\Models\Student;
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
        Schema::create('educational_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained();
            $table->unsignedSmallInteger('year_level');
            $table->char('semester', 10);
            $table->unsignedSmallInteger('upcoming_year_level');
            $table->char('upcoming_semester', 10);
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
        Schema::dropIfExists('educational_levels');
    }
};
