<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceList extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'students_lists', 'list_id')
            ->using(AttendanceListStudent::class)->withPivot('attended');
    }
}
