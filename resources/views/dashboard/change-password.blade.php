@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Password | <small>Change </small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Reset Password Title -->

        <section class="section dashboard">

            <!-- Reset Password -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <div class="container row d-flex justify-content-center">
                        <div class="col-sm-8 mb-3">
                            <label for="current_password" class="form-label">Password Lama</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name='current_password' required>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-sm-8 mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        
                        <div class="col-sm-8 mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-key"></i> Reset Password</button>
                            </div>
                            <div class="text-center p-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- End Reset Password -->

        </section>

@endsection