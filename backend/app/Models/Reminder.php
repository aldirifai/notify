<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'category_id',
        'title',
        'description',
        'repeat_type',
        'notification_date_time',
        'deadline_date_time',
        'is_done',
        'is_important',
    ];

    protected $casts = [
        'notification_date_time' => 'datetime',
        'deadline_date_time' => 'datetime',
        'is_done' => 'boolean',
        'is_important' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
