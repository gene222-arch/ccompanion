<?php

use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Professor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Schedule::class)->constrained();
            $table->foreignIdFor(Subject::class)->constrained();
            $table->foreignIdFor(Professor::class)->constrained();
            $table->string('day');
            $table->time('from');
            $table->time('to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_details');
    }
};
