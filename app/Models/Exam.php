<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';
    protected $primaryKey = 'exam_id';
    public $timestamps = false;

    protected $fillable = [
        'exam_name',
        'class_id',
        'section_id',
        'exam_term',
        'passing_mark',
        'total_mark',
        'exam_start_date',
        'exam_end_date',
        'exam_syllabus',
        'exam_comment',
        'created_date',
        'modified_date',
        'exam_creater_id',
        'contributions',
        'contributions_data'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class, 'section_id', 'id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'exam_id', 'exam_id');
    }
}