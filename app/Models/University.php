<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    // Table & primary key setup
    protected $table = 'universities';
    protected $primaryKey = 'uniID';
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'uniName',
        'approval_status',
        'submitted_by',
    ];

    // Relationship to the submitting user
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    // Accessor for readability (optional)
    public function getNameAttribute()
    {
        return $this->uniName;
    }
}

 
