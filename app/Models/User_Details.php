<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Details extends Model
{
    use HasFactory;
        
    // Table name
    protected $table = 'user_details';
    // Primary key
    protected $primaryKey = 'UserID';
    // The primary key type is integer
    protected $keyType = 'string';
    // Disable auto-incrementing
    public $incrementing = false;
    // Enable timestamps since the migration include them
    public $timestamps = true; 
    // Override timestamp column names
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    // Mass assignable attributes
    protected $fillable = [
        'UserID',
        'UserFullName',
        'UserDateOfBirth',
        'UserGender',
        'UserEmail',
        'UserPassword',
        'UserPhoneNumber',
        'UserAddress',
        'UserOccupation',
        'UserTransport',
        'UserShirtSize',
        'UserDietaryRequirements',
        'UserMedicalConditions',
        'UserSkillsAndExperiences',
        'UserRole'
    ];

    // Cast attributes to appropriate types
    protected $casts = [
        'UserDateOfBirth' => 'date',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime'
    ];

    // Hide sensitive attributes
    protected $hidden = [
        'UserPassword'
    ];
}
