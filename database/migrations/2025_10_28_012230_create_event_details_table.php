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
        Schema::create('event_details', function (Blueprint $table) {
            /*Event details*/
            $table->smallIncrements('EventID');
            $table->string('EventName', 200);
            $table->text('EventDescription');
            $table->date('EventStartDate')->nullable();
            $table->date('EventEndDate')->nullable();
            $table->string('EventLocation', 200)->nullable();
            $table->enum('EventStatus', ['Upcoming', 'Ongoing', 'Completed', 'Cancelled'])->default('Upcoming');
            $table->string('CoordinatorID', 12)->nullable();
            $table->integer('MaxVolunteers')->nullable();
            /*Foreign key constraint*/
            $table->foreign('CoordinatorID')
                  ->references('UserID')
                  ->on('user_details')
                  ->onDelete('set null');
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
        Schema::dropIfExists('event_details');
    }
};
