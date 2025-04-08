<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('students', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('students', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('students', 'remember_token')) {
                $table->rememberToken();
            }
            
            // Modify existing columns if needed
            if (Schema::hasColumn('students', 'class')) {
                $table->string('class')->change();
            } else {
                $table->string('class');
            }
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['password', 'phone', 'bio', 'remember_token']);
            $table->dropColumn('class');
        });
    }
};
