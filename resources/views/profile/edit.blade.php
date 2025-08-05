@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-white">👤 Profile</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow">
                <div class="card-header bg-primary text-white">Update Profile Information</div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4 shadow">
                <div class="card-header bg-warning text-white">Update Password</div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-danger text-white">Hapus Akun</div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
