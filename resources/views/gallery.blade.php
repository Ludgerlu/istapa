@extends('layouts.app')

@section('title', 'ISTAPA - Contact')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
    <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="assets/images/shapes/shape1.png" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="assets/images/shapes/shape2.png" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="assets/images/shapes/shape3.png" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape5.png" alt="" class="shape six animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape four animation-scalation">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape nine animation-scalation">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center"> Gallery</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="index.html" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> 
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> Home</a>
                            </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <a href="course.html" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> </a> 
                        </li>
                        <li class="breadcrumb__item d-none">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item"> 
                            <span class="text-main-two-600"> Gallery </span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- ==================== Breadcrumb End Here ==================== -->

    <!-- =============================== Gallery Section Start ================================== -->
    <section class="gallery py-120">
        <div class="container">
            <div class="container">
                <div class="section-heading text-center">
                  <div class="flex-align d-inline-flex gap-8 mb-16">
                      <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                      <h5 class="text-main-600 mb-0">Gallery</h5>
                  </div>
                  <h2 class="mb-24">Explore Our Gallery</h2>
                  <p class="">Students can register for the workshops through the EduAll platform. Limited seats are available</p>
                </div>

                <div class="text-center">
                  <div class="nav-tab-wrapper bg-white border border-neutral-40 p-16 mb-40 d-inline-block" data-aos="zoom-out">
                      <ul class="nav nav-pills common-tab gap-16" id="pills-tab" role="tablist">
                          <li class="nav-item" role="presentation">
                              <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8 active" id="pills-education-tab" data-bs-toggle="pill" data-bs-target="#pills-education" type="button" role="tab" aria-controls="pills-education" aria-selected="true">
                                  <i class="text-xl d-flex text-main-600 ph-bold ph-squares-four"></i>
                                  Online Education
                              </button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8" id="pills-University-tab" data-bs-toggle="pill" data-bs-target="#pills-University" type="button" role="tab" aria-controls="pills-University" aria-selected="false">
                                  <i class="text-xl d-flex text-main-600 ph-bold ph-magic-wand"></i>
                                  University
                              </button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8" id="pills-Tutors-tab" data-bs-toggle="pill" data-bs-target="#pills-Tutors" type="button" role="tab" aria-controls="pills-Tutors" aria-selected="false">
                                  <i class="text-xl d-flex text-main-600 ph-bold ph-code"></i>
                                  Tutors
                              </button>
                          </li>
                      </ul>
                  </div>
              </div>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-education" role="tabpanel" aria-labelledby="pills-education-tab" tabindex="0">
                    <!-- Masonry Start -->
<div class="masonry">
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img1.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img1.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img2.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img2.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img3.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img3.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img4.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img4.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img5.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img5.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img6.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img6.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img7.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img7.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img8.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img8.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img9.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img9.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
</div>
<!-- Masonry End -->

                </div>
                <div class="tab-pane fade" id="pills-University" role="tabpanel" aria-labelledby="pills-University-tab" tabindex="0">
                    <!-- Masonry Start -->
<div class="masonry">
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img1.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img1.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img2.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img2.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img3.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img3.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img4.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img4.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img5.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img5.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img6.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img6.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img7.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img7.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img8.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img8.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img9.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img9.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
</div>
<!-- Masonry End -->

                </div>
                <div class="tab-pane fade" id="pills-Tutors" role="tabpanel" aria-labelledby="pills-Tutors-tab" tabindex="0">
                    <!-- Masonry Start -->
<div class="masonry">
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img1.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img1.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img2.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img2.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img3.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img3.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img4.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img4.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img5.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img5.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img6.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img6.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img7.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img7.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img8.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img8.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
    <div class="masonry__item position-relative rounded-12 overflow-hidden">
        <img src="assets/images/thumbs/gallery-img9.png" alt="image" class="cover-img">
        <a href="assets/images/thumbs/gallery-img9.png" class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0">
            <i class="ph ph-magnifying-glass-plus"></i>
        </a>
    </div>
</div>
<!-- Masonry End -->

                </div>
              </div>

            </div>
        </div>
    </section>
    <!-- =============================== Gallery Section End ================================== -->
@endsection
