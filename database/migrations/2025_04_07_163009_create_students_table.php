<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('roll_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();
            
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });

        // Add a trigger to auto-generate roll number on insert if not provided
        DB::unprepared('
            CREATE TRIGGER tr_students_roll_number
            BEFORE INSERT ON students
            FOR EACH ROW
            BEGIN
                IF NEW.roll_number IS NULL THEN
                    SET NEW.roll_number = CONCAT("R", LPAD((SELECT IFNULL(MAX(SUBSTRING(roll_number, 2)), 0) + 1 FROM students), 4, "0"));
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_students_roll_number');
        Schema::dropIfExists('students');
    }
};