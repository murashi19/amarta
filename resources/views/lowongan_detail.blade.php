@extends('layouts.app')

@section('content')
<section id="lowongan-detail" class="py-5">
  <div class="container">
    <!-- Back Button -->
    <div class="mb-4">
      <a href="" class="btn btn-outline-secondary d-inline-flex align-items-center">
        <i class="fas fa-arrow-left me-2"></i>
        {{ __('app.back_to_home') }}
      </a>
    </div>

    <!-- Section Title -->
    <div class="text-center mb-5">
      <h2 class="display-4 fw-bold text-primary">{{ $jobData['title'] }}</h2>
      <div class="mx-auto mt-3" style="width: 100px; height: 3px; background: linear-gradient(90deg, #007bff, #0056b3);"></div>
    </div>

    @if(isset($jobData['is_multiple']) && $jobData['is_multiple'])
      <!-- Tampilan untuk card "lainnya" yang berisi multiple categories -->
      <div class="detail-content">
        <div class="row justify-content-center mb-4">
          <div class="col-lg-10">
            <div class="alert alert-info border-0 shadow-sm">
              <div class="d-flex align-items-center mb-3">
                <i class="fas fa-info-circle me-2 fs-4"></i>
                <h4 class="mb-0 fw-semibold">{{ __('app.other_opportunities') }}</h4>
              </div>
              <p class="mb-0 lead">{{ $jobData['description'] }}</p>
            </div>
          </div>
        </div>

        <!-- Loop through sub categories -->
        @foreach($jobData['sub_categories'] as $subKey => $subData)
          <div class="sub-category mb-5">
            <div class="card border-0 shadow-sm overflow-hidden">
              <div class="row g-0">
                <div class="col-md-5">
                  <div class="position-relative h-100" style="min-height: 300px;">
                    <img src="{{ asset($subData['image']) }}" 
                         alt="{{ $subData['title'] }}" 
                         class="img-fluid w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10"></div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="card-body p-4 p-lg-5">
                    <h3 class="card-title text-primary fw-bold mb-4">{{ $subData['title'] }}</h3>
                    
                    <div class="mb-4">
                      <h5 class="text-secondary fw-semibold mb-3">
                        <i class="fas fa-file-alt me-2"></i>{{ __('app.description') }}
                      </h5>
                      <p class="text-muted lh-lg">{{ $subData['description'] }}</p>
                    </div>

                    <div class="mb-4">
                      <h5 class="text-secondary fw-semibold mb-3">
                        <i class="fas fa-check-circle me-2"></i>{{ __('app.requirements') }}
                      </h5>
                      <ul class="list-unstyled">
                        @foreach($subData['requirements'] as $requirement)
                          <li class="mb-2">
                            <i class="fas fa-chevron-right text-primary me-2"></i>
                            <span class="text-muted">{{ $requirement }}</span>
                          </li>
                        @endforeach
                      </ul>
                    </div>

                    <a href="{{ url('daftar') }}" class="btn btn-primary btn-lg px-4 py-2 shadow-sm text-decoration-none">
                      <i class="fas fa-paper-plane me-2"></i>
                      {{ __('app.apply_for', ['job' => $subData['title']]) }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          @if(!$loop->last)
            <div class="text-center my-5">
              <div class="d-inline-block px-4 py-2 bg-light rounded-pill">
                <i class="fas fa-ellipsis-h text-muted"></i>
              </div>
            </div>
          @endif
        @endforeach

        <!-- Persyaratan umum -->
        <div class="row justify-content-center mt-5">
          <div class="col-lg-10">
            <div class="card border-0 shadow-sm bg-light">
              <div class="card-body p-4 p-lg-5">
                <div class="d-flex align-items-center mb-4">
                  <i class="fas fa-clipboard-list me-3 text-primary fs-3"></i>
                  <h4 class="mb-0 fw-bold text-primary">{{ __('app.general_requirements') }}</h4>
                </div>
                <div class="row">
                  <div class="col-12">
                    <ul class="list-unstyled row">
                      @foreach($jobData['requirements'] as $requirement)
                        <li class="col-md-6 mb-3">
                          <div class="d-flex align-items-start">
                            <i class="fas fa-star text-warning me-3 mt-1"></i>
                            <span class="text-muted">{{ $requirement }}</span>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    @else
      <!-- Tampilan untuk lowongan tunggal -->
      <div class="detail-content">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden">
              <div class="row g-0">
                <div class="col-md-5">
                  <div class="position-relative h-100" style="min-height: 400px;">
                    <img src="{{ asset($jobData['image']) }}" 
                         alt="{{ $jobData['title'] }}" 
                         class="img-fluid w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-to-r from-transparent to-primary opacity-20"></div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="card-body p-4 p-lg-5 h-100 d-flex flex-column">
                    <div class="flex-grow-1">
                      <div class="mb-4">
                        <h3 class="text-primary fw-bold mb-3">
                          <i class="fas fa-info-circle me-2"></i>{{ __('app.description') }}
                        </h3>
                        <p class="text-muted lh-lg fs-6">{{ $jobData['description'] }}</p>
                      </div>

                      <div class="mb-4">
                        <h3 class="text-primary fw-bold mb-3">
                          <i class="fas fa-tasks me-2"></i>{{ __('app.requirements') }}
                        </h3>
                        <ul class="list-unstyled">
                          @foreach($jobData['requirements'] as $requirement)
                            <li class="mb-2">
                              <i class="fas fa-check text-success me-2"></i>
                              <span class="text-muted">{{ $requirement }}</span>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>

                    <div class="mt-auto">
                      <a href="{{ url('daftar') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm w-100 text-decoration-none">
                        <i class="fas fa-paper-plane me-2"></i>
                        {{ __('app.apply_now') }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>
</section>

@push('styles')
<style>
  .object-fit-cover {
    object-fit: cover;
  }
  
  .bg-gradient-to-r {
    background: linear-gradient(to right, var(--bs-transparent), var(--bs-primary));
  }
  
  .opacity-20 {
    opacity: 0.2;
  }
  
  .lh-lg {
    line-height: 1.8;
  }
  
  .card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
  }
  
  .btn {
    transition: all 0.2s ease-in-out;
  }
  
  .btn:hover {
    transform: translateY(-1px);
  }
  
  .btn-outline-secondary {
    border-color: #6c757d;
    transition: all 0.2s ease-in-out;
  }
  
  .btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    transform: translateY(-1px);
  }
</style>
@endpush
@endsection