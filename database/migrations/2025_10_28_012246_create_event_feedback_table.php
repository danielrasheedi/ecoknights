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
        Schema::create('event_feedback', function (Blueprint $table) {
            /*Event feedback details*/
            $table->mediumIncrements('FeedbackID');
            $table->string('UserID', 12);
            $table->smallInteger('EventID')->unsigned();
            $table->enum('EventRating', ['1', '2', '3', '4', '5']);
            $table->text('EventComment');  
            /*Foreign key constraints*/
            $table->foreign('UserID')
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
        Schema::dropIfExists('event_feedback');
    }
};
