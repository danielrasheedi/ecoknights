<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Details extends Model
{
    use HasFactory;
    
    // Table name
    protected $table = 'event_details';
    // Primary key
    protected $primaryKey = 'EventID';
    // Enable auto-incrementing
    public $incrementing = true;
    // Enable timestamps since the migration include them
    public $timestamps = true;
    // Override timestamp column names
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    
    // Mass assignable attributes
    protected $fillable = [
        'EventName',
        'EventDescription',
        'EventStartDate',
        'EventEndDate',
        'EventLocation',
        'EventStatus',
        'CoordinatorID',
        'MaxVolunteers'
    ];
    
    // Cast attributes to appropriate types
    protected $casts = [
        'EventStartDate' => 'date',
        'EventEndDate' => 'date',
        'MaxVolunteers' => 'integer',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime',
    ];

    /**
     * Relationship: Event belongs to a coordinator (user)
     */
    public function coordinator()
    {
        return $this->belongsTo(User_Details::class, 'CoordinatorID', 'UserID');
    }

    /**
     * Relationship: Event has many participations
     */
    public function participations()
    {
        return $this->hasMany(Event_Participation::class, 'EventID', 'EventID');
    }

    /**
     * Relationship: Event has many feedbacks
     */
    public function feedbacks()
    {
        return $this->hasMany(Event_Feedback::class, 'EventID', 'EventID');
    }
}
