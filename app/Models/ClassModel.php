<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    protected $fillable = [
        'class_name',
        'class_num_name',
        'class_section',
        'class_capacity',
        'creater_id',
        'created_date',
        'modified_date'
    ];

    public function sections()
    {
        return $this->hasMany(ClassSection::class, 'class_id', 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id', 'class_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_name', 'class_id')
                    ->whereHas('userMeta', function($q) {
                        $q->where('meta_key', 'wp_capabilities')
                          ->where('meta_value', 'like', '%student%');
                    });
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_class', 'class_id', 'teacher_id', 'class_id', 'ID');
    }

    public function fees()
    {
        return $this->hasMany(Fees::class, 'class_id', 'class_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'class_id', 'class_id');
    }
}