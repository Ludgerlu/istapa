<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';
    protected $primaryKey = 'subid';
    public $timestamps = false;

    protected $fillable = [
        'sub_name',
        'teacher_id',
        'class_id',
        'author_name',
        'edition',
        'syllabus',
        'created_by',
        'section_id',
        'subject_code'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class, 'section_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'ID');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'subject_id', 'subid');
    }
}