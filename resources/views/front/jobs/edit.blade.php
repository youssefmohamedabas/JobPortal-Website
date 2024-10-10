@extends('layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.acc.sidebar')
            </div>
            <div class="col-lg-9">
                @if(Session::has('success'))
                <div class="alert alert-success">
                <p>
                   {{   Session::get('success')}}
                
                </p>
                </div>
                @endif
                <form method="post" id="editjobForm" name="editjobForm" action="" >
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Job Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" value="{{ $job->title }}">
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                    @foreach ($categories as $category )
                                    <option value="{{ (int)$category->id }}" {{ (int)$job->category_id == (int)$category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                    
                                    
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                <select name="jobtype" id="jobtype"  class="form-select">
                                    <option  value="">Select Job Nature</option>

                                    @if($jobtypes->isNotEmpty())
                                    @foreach ($jobtypes as $jobtype )
                                    <option value="{{$jobtype->id }}" {{ ($job->job_type_id==$jobtype->id) ? 'selected': '' }}>{{ $jobtype->name }}</option>
                                    @endforeach
                                    @endif
                                    
                                </select>
                                <p></p>

                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control" value="{{ $job->vacancy }}">
                                <p></p>
                            </div>
                           

                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Salary</label>
                                <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control" value="{{ $job->salary }}">
                                <p></p>

                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location<span class="req">*</span></label>
                                <input type="text" placeholder="location" id="location" name="location" class="form-control" value="{{ $job->location }}">
                                <p></p>
                            </div>
                            
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description" >{{ $job->description }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Responsibility</label>
                            <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Qualifications</label>
                            <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                            <p></p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="" class="mb-2">Experience</label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Select Experience</option>
                                <option value="1"{{ ($job->experience==1) ?'selected':'' }}>1 Year</option>
                                <option value="2" {{ ($job->experience==2) ?'selected':'' }}>2 Years</option>
                                <option value="3" {{ ($job->experience==3) ?'selected':'' }}>3 Years</option>
                                <option value="4"{{ ($job->experience==4) ?'selected':'' }}>4 Years</option>

                                <option value="5"{{ ($job->experience==5) ?'selected':'' }}>5 Years</option> 
                                <option value="6"{{ ($job->experience==6) ?'selected':'' }}>6 Years</option>
                                <option value="7"{{ ($job->experience==7) ?'selected':'' }}>7 Years</option>
                                <option value="8"{{ ($job->experience==8) ?'selected':'' }}>8 Years</option>
                                <option value="9"{{ ($job->experience==9) ?'selected':'' }}>9 Years</option>
                                <option value="10"{{ ($job->experience==10) ?'selected':'' }}>10 Years</option>
                                <option value="10_plus"{{ ($job->experience=='10_plus') ?'selected':'' }}>10+ Years</option>
                                <p></p>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                            <input type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control" value="{{ $job->keywords }}">
                            <p></p>
                        </div>

                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Name<span class="req">*</span></label>
                                <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control" value="{{ $job->company_name }}">
                                <p></p>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location</label>
                                <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control" value="{{ $job->company_location }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Website</label>
                            <input type="text" placeholder="Website" id="company_website" name="company_website" class="form-control" value="{{ $job->company_website }}">
                        </div>
                    </div> 
                    <div class="card-footer  p-4">
                        <button type="sumbit" class="btn btn-primary">Update Job</button>
                    </div>               
            </div>
                </form>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
$("#editjobForm").submit(function(e){
e.preventDefault();
$('button[type="submit"]').prop('disabled', false);

console.log($("editjobForm").serializeArray())
$.ajax({
        url: '{{ route("acc.updatejob",$job->id) }}',
        type: 'POST',
        data: $("#editjobForm").serializeArray(),
        dataType: 'json',
        success: function(response){
            $('button[type="submit"]').prop('disabled', true);

            if(response.status == false){
                var errors = response.errors;
                
                // Handle error display for each field
                ['title', 'category', 'location', 'jobtype', 'vacancy', 'description', 'experience', 'company_name', 'keywords'].forEach(function(field){
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
                window.location.href = '{{ route("acc.myjob") }}';
            }
        }
    });
});
</script>
@endsection