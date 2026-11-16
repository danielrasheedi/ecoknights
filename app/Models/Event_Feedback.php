<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Feedback extends Model
{
    use HasFactory;
    
    // Table name
    protected $table = 'event_feedback';
    // Primary key
    protected $primaryKey = 'FeedbackID';
    // Enable auto-incrementing
    public $incrementing = true;
    // Enable timestamps since the migration include them
    public $timestamps = true;
    // Override timestamp column names
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    
    // Mass assignable attributes
    protected $fillable = [
        'UserID',
        'EventID',
        'EventRating',
        'EventComment'
    ];
    
    // Cast attributes to appropriate types
    protected $casts = [
        'FeedbackID' => 'integer',
        'EventID' => 'integer',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];
    
    // Define relationship with User_Details
    public function user()
    {
        return $this->belongsTo(User_Details::class, 'UserID', 'UserID');
    }
    
    // Define relationship with Event_Details
    public function event()
    {
        return $this->belongsTo(Event_Details::class, 'EventID', 'EventID');
    }
}
