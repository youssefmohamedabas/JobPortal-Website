@extends('layouts.app')
@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <form action="{{ route('searchjob') }}" method="GET">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Select time</option>
                        <option value="latest" {{ isset($req->sort) && $req->sort=='latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ isset($req->sort) && $req->sort=='oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                   

                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text"  value="{{ isset($req) ? $req->keywords : '' }}" name="keywords" id="keywords" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input type="text" value="{{ isset($req) ? $req->location : '' }}"placeholder="Location" class="form-control" name="location" id="location">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($categories->isNotEmpty())
@foreach ( $categories as $category )
<option value="{{ (int)$category->id }}" {{ isset($req) && (int)$req->category == (int)$category->id ? 'selected' : '' }}>
    {{ $category->name }}
</option>

@endforeach
                            
                            @endif
                           
                           
                        </select>
                    </div>                   

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if ($jobtypes->isNotEmpty())
                            @foreach ($jobtypes as $jobtype)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" name="job_types[]" type="checkbox" value="{{ $jobtype->id }}" id="job-type-{{ $jobtype->id }}" {{ isset($req) && in_array($jobtype->id, $req->job_types ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="job-type-{{ $jobtype->id }}">{{ $jobtype->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <select name="experience" id="experience" class="form-control">
                            <option value="">Select Experience</option>
                            <option value="1" {{ isset($req->experience) && $req->experience == 1 ? 'selected' : '' }}>1 Year</option>
                            <option value="2" {{ isset($req->experience) && $req->experience == 2 ? 'selected' : '' }}>2 Years</option>
                            <option value="3" {{ isset($req->experience) && $req->experience == 3 ? 'selected' : '' }}>3 Years</option>
                            <option value="4" {{ isset($req->experience) && $req->experience == 4 ? 'selected' : '' }}>4 Years</option>
                            <option value="5" {{ isset($req->experience) && $req->experience == 5 ? 'selected' : '' }}>5 Years</option>
                            <option value="6" {{ isset($req->experience) && $req->experience == 6 ? 'selected' : '' }}>6 Years</option>
                            <option value="7" {{ isset($req->experience) && $req->experience == 7 ? 'selected' : '' }}>7 Years</option>
                            <option value="8" {{ isset($req->experience) && $req->experience == 8 ? 'selected' : '' }}>8 Years</option>
                            <option value="9" {{ isset($req->experience) && $req->experience == 9 ? 'selected' : '' }}>9 Years</option>
                            <option value="10" {{ isset($req->experience) && $req->experience == 10 ? 'selected' : '' }}>10 Years</option>
                            <option value="11" {{ isset($req->experience) && $req->experience > 10 ? 'selected' : '' }}>10+ Years</option>
                        </select>
                        
                    </div> 
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>                   
                </div>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">
                        @if($jobs->isNotEmpty())
                        @foreach ($jobs as $job )
                            
                       
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{$job->title  }}</h3>
                                    <p>
                                       {{ Str::words($job->description,$words=10,'...') }}
                                    </p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $job->location }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{ $job->jobType->name }}</span>
                                        </p>
                                        @if(!is_null($job->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $job->salary }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{ route('getjob',$job->id) }}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                       
                     @endif 
                       
                 
                        
                                                 
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection