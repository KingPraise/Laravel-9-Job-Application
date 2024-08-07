<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'roles',
        'job_type',
        'address',
        'salary',
        'application_close_date',
        'feature_image',
        'slug'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "listing_user", "listing_id", "user_id")->withPivot("shortlisted")->withTimestamps();
    }
}