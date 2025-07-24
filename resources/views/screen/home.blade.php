@extends('main')

@section('title', 'Welcome to Library App')

@section('content')
<section class="hero-section d-flex align-items-center py-5">
    <div class="row gx-5 align-items-center">
        <div class="col-lg-6 order-lg-1 order-2">
            <h1 class="display-4 fw-bold mb-3" style="color: #3b3f5c;">Welcome to the Library App</h1>
            <p class="lead text-secondary mb-4" style="max-width: 480px;">
                Manage, explore, and discover a wide range of books with ease. Your digital library starts here.
            </p>
            <a href="{{ url('/books') }}" class="btn btn-glow btn-lg shadow-lg">
                <i class="bi bi-book-half me-2"></i> Browse Books
            </a>
            
        </div>
        <div class="col-lg-6 order-lg-2 order-1 text-center">
            <img src="{{ asset('images/library.jpg') }}" alt="Library Illustration" class="img-fluid rounded-4 shadow-lg" style="max-height: 460px; object-fit: cover;">
        </div>
    </div>
</section>

<hr class="my-5">

<section class="features-section">
    <div class="row gy-4 text-center">
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <i class="bi bi-book display-3 text-indigo mb-3"></i>
                <h5 class="mb-2 fw-semibold">Book Catalog</h5>
                <p class="text-muted">Browse our full catalog of books across all genres and categories.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <i class="bi bi-pencil-square display-3 text-indigo mb-3"></i>
                <h5 class="mb-2 fw-semibold">Manage Collection</h5>
                <p class="text-muted">Add, edit, and organize your library's collection with powerful tools.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <i class="bi bi-people display-3 text-indigo mb-3"></i>
                <h5 class="mb-2 fw-semibold">Community & Support</h5>
                <p class="text-muted">Get help, join discussions, and share recommendations with others.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .btn-indigo {
        background-color: #4f46e5;
        color: white;
        transition: background-color 0.3s ease;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        border: none;
    }
    .btn-indigo:hover {
        background-color: #4338ca;
        box-shadow: 0 8px 25px rgba(67, 56, 202, 0.5);
        color: white;
    }

    .text-indigo {
        color: #4f46e5;
    }

    .feature-card {
        background: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
    }
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(79, 70, 229, 0.25);
    }

    .btn-glow {
        background: linear-gradient(135deg, #eaeaea, #ffffff);
        color: #fff;
        font-weight: 600;
        padding: 0.9rem 2.2rem;
        border-radius: 50px;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-glow:hover {
        transition: transform 0.3s ease-in-out;
        background: linear-gradient(135deg, #eeeeee, #ffffff);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.6), 0 8px 25px rgba(67, 56, 202, 0.3);
        transform: translateY(-2px);
    }

    .btn-glow i {
        font-size: 1.2rem;
        vertical-align: middle;
    }

</style>
@endpush
