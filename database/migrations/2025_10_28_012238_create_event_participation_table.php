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
        Schema::create('event_participation', function (Blueprint $table) {
            /*Event participation details*/
            $table->mediumIncrements('ParticipationID');
            $table->string('VolunteerID', 12);
            $table->smallInteger('EventID')->unsigned();
            $table->string('EventRole', 100)->nullable();
            $table->enum('ApprovalStatus', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->enum('AttendanceStatus', ['Attended', 'Absent'])->nullable();
            
            /*Foreign key constraints*/
            $table->foreign('VolunteerID')
                  ->references('UserID')
                  ->on('user_details') 
                  ->onDelete('cascade');
                  
            $table->foreign('EventID')
                  ->references('EventID')
                  ->on('event_details') 
                  ->onDelete('cascade');
                  
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
        Schema::dropIfExists('event_participation');
    }
};
