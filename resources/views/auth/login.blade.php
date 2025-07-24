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
                            <label for="email">Email</label>
                            <input 
                                type="text" 
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Email....">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Password....">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
    
                        </div>
                        

                        <button type="submit" class="mt-2 btn btn-primary btn-sm">Login</button>
                        

                        <div class="mt-2">
                            <p>Belum punya akun? <a href="{{ url('/register') }}">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        


@endsection