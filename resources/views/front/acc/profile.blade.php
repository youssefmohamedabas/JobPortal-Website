
@extends('layouts.app')
@section('main')<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
               
                
                @include('front.acc.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body  p-4">
                        @if(Session::has('success'))
<div class="alert alert-success">
<p>
   {{   Session::get('success')}}

</p>
</div>
@endif
                        <h3 class="fs-4 mb-1">My Profile</h3>
                        <form action="{{ route('acc.updateprofile') }}"  method="POST" id="userForm" name="userForm">
                            @csrf  @method('PUT') <div class="mb-4">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Enter Name" class="form-control" value="">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email"placeholder="Enter Email" value="{{ $user->email }}"class="form-control">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Designation*</label>
                            <input type="text"  name="designation" value="{{ $user->designation }}"id="designation"placeholder="Designation" class="form-control">
                           
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Mobile*</label>
                            <input type="text" name="mobile"  value="{{ $user->mobile }}" id="mobile"placeholder="Mobile" class="form-control">
                          
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit"  class="btn btn-primary">Update</button>
                    </div>
                </form>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
$("#userForm").submit(function(e){
e.preventDefault();
$.ajax({
        url: '{{ route("acc.updateprofile") }}',
        type: 'put',
        data: $("#userForm").serializeArray(),
        dataType: 'json',
        success: function(response){
            if(response.status == false){
                var errors = response.errors;
                
                // Handle error display for each field
                ['name', 'email'].forEach(function(field){
                    if(errors[field]){
                        $("#" + field).addClass('is-invalid')
                            .siblings('p').addClass('invalid-feedback')
                            .html(errors[field]);
                    } else {
                        $("#" + field).removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html('');
                    }
                });
            } else {
                // On success, clear errors and redirect
                window.location.href = '{{ route("acc.profile") }}';
            }
        }
    });
});
</script>
@endsection