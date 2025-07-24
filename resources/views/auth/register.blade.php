@extends('main')

@section('content')
    <div class="row mt-3">
        <div class="col-6 offset-3">
            <div class="card">
                <div class="card-header">Form <strong>Login</strong></div>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf 

                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input 
                                type="text" 
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Nama Anda....">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input 
                                type="text" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Masukan Email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Password....">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Konfirmasi Password....">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>

                        <button type="submit" class="mt-2 btn btn-primary btn-sm">Register</button>
                        

                        <div class="mt-2">
                            <p>Punya akun? <a href="{{ url('/login') }}">login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        


@endsection