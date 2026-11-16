<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            /*Personal details*/
            $table->string('UserID', 12)->primary();
            $table->string('UserFullName', 80)->nullable();
            $table->date('UserDateOfBirth')->nullable();
            $table->enum('UserGender', ['Male', 'Female'])->nullable();
            $table->string('UserEmail', 255)->nullable()->unique();
            $table->string('UserPassword', 60); 
            $table->string('UserPhoneNumber', 20)->nullable();
            $table->string('UserAddress', 300)->nullable();
            $table->string('UserOccupation', 100)->nullable();
            $table->enum('UserTransport', [
                'I have my own vehicle', 
                'I can arrange my own transport', 
                'I rely on public transport', 
                'I do not have reliable transportation'
            ])->nullable();
            /*Personal requirements*/
            $table->enum('UserShirtSize', ['XS', 'S', 'M', 'L', 'XL', 'XXL'])->nullable();
            $table->string('UserDietaryRequirements', 200)->nullable();
            $table->string('UserMedicalConditions', 300)->nullable();
            /*Personal skills and experiences*/
            $table->text('UserSkillsAndExperiences')->nullable();
	        $table->enum('UserRole', ['Volunteer', 'Event Coordinator', 'Administrator'])->nullable();
            /*Timestamps of the record(s)*/
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};