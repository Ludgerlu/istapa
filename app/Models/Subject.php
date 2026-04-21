<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'teacher_id',
        'class_id',
        'author_name',
        'edition',
        'syllabus',
        'created_by',
        'section_id',
        'subject_code',
    ];

    // ─── Relationships ──────────────────────────────────────────────────────────

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class, 'section_id', 'id');
    }

    public function teacher()
    {
        // teacher_id now refers to users.id (not wp_users.ID)
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function marks()
    {
        // subject FK in marks table is subject_id referencing subject.id
        return $this->hasMany(Mark::class, 'subject_id', 'id');
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class, 'subject_id', 'id');
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'subject_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subject', 'subject_id', 'teacher_id', 'id', 'id');
    }
}