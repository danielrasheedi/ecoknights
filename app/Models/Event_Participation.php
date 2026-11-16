<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Participation extends Model
{
    use HasFactory;
    
    // Table name
    protected $table = 'event_participation';
    // Primary key
    protected $primaryKey = 'ParticipationID';
    // Enable auto-incrementing
    public $incrementing = true;
    // Enable timestamps since the migration include them
    public $timestamps = true;
    // Override timestamp column names
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    
    // Mass assignable attributes
    protected $fillable = [
        'VolunteerID',
        'EventID',
        'EventRole',
        'ApprovalStatus',
        'AttendanceStatus'
    ];
    
    // Cast attributes to appropriate types
    protected $casts = [
        'ParticipationID' => 'integer',
        'EventID' => 'integer',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    // Define relationship with volunteer in User_Details 
    public function volunteer()
    {
        return $this->belongsTo(User_Details::class, 'VolunteerID', 'UserID');
    }
    
    // Define relationship with Event_Details
    public function event()
    {
        return $this->belongsTo(Event_Details::class, 'EventID', 'EventID');
    }
}
