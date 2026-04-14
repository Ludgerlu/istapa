<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'user_activation_key',
        'user_status',
        'display_name'
    ];

    protected $hidden = [
        'user_pass',
        'user_activation_key',
    ];

    protected $casts = [
        'user_registered' => 'datetime',
        'user_status' => 'integer',
    ];

    // Get auth password
    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    // Get email for authentication
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    // Get username for authentication
    public function getAuthIdentifierName()
    {
        return 'user_login';
    }

    public function getAuthIdentifier()
    {
        return $this->user_login;
    }

    // Relationships
    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID');
    }

    public function getMeta($key)
    {
        $meta = $this->userMeta()->where('meta_key', $key)->first();
        return $meta ? $meta->meta_value : null;
    }

    public function setMeta($key, $value)
    {
        $meta = $this->userMeta()->where('meta_key', $key)->first();
        if ($meta) {
            $meta->meta_value = $value;
            $meta->save();
        } else {
            $this->userMeta()->create([
                'meta_key' => $key,
                'meta_value' => $value
            ]);
        }
    }

    // Role checks
    public function isAdmin()
    {
        $capabilities = $this->getMeta('wp_capabilities');
        if ($capabilities) {
            $caps = unserialize($capabilities);
            return isset($caps['administrator']);
        }
        return false;
    }

    public function isTeacher()
    {
        $capabilities = $this->getMeta('wp_capabilities');
        if ($capabilities) {
            $caps = unserialize($capabilities);
            return isset($caps['teacher']);
        }
        return false;
    }

    public function isStudent()
    {
        $capabilities = $this->getMeta('wp_capabilities');
        if ($capabilities) {
            $caps = unserialize($capabilities);
            return isset($caps['student']);
        }
        return false;
    }

    public function getRole()
    {
        if ($this->isAdmin()) return 'admin';
        if ($this->isTeacher()) return 'teacher';
        if ($this->isStudent()) return 'student';
        return 'subscriber';
    }

    // Student specific
    public function studentClass()
    {
        $classId = $this->getMeta('class_name');
        return $classId ? ClassModel::find($classId) : null;
    }

    public function studentSection()
    {
        $sectionId = $this->getMeta('class_section');
        return $sectionId ? ClassSection::find($sectionId) : null;
    }

    public function rollId()
    {
        return $this->getMeta('roll_id');
    }

    // Teacher specific
    public function teacherClasses()
    {
        return $this->belongsToMany(ClassModel::class, 'teacher_class', 'teacher_id', 'class_id', 'ID', 'class_id');
    }

    public function teacherSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id', 'ID', 'subid');
    }
}