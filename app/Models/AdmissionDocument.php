<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionDocument extends Model
{
    protected $table = 'admission_documents';
    public $timestamps = false;

    protected $fillable = ['admission_request_id', 'doc_type', 'file_path', 'original_name'];

    public function admissionRequest()
    {
        return $this->belongsTo(AdmissionRequest::class);
    }
}