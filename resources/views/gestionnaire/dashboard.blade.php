@extends('layouts.admin')

@section('title', 'Tableau de bord gestionnaire')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Tableau de bord gestionnaire</h4>
        <p class="text-neutral-400 mt-8">Bienvenue, {{ auth()->user()->first_name ?? auth()->user()->role }}.</p>
    </div>
</div>

<div class="row gy-4 mb-4">
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Articles de blog</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($totalBlogs ?? 0) }}</h6>
                </div>
                <span class="w-44 h-44 bg-main-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-newspaper text-white text-20"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Commentaires</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($totalComments ?? 0) }}</h6>
                </div>
                <span class="w-44 h-44 bg-success-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-chat-dots text-white text-20"></i>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
