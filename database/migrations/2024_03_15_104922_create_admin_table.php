<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin; // Adjust this to match your actual model path

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->timestamps();
        });

        // Insert the initial admin entry
        Admin::create([
            'username' => 'admin',
            'password' => '$2y$10$wDXVSEQU2NJcUOJ.pBIUWOykekOY5kABCEIuYeqhs5Hp5y6UG.nrO', // Hashed password
            // You can add other fields if needed
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
};
