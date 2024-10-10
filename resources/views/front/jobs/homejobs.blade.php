@extends('layouts.app')
@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center "   class="" data-bg="assets/images/banner5.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>
                <div class="banner-btn mt-5"><a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 "> 
    <div class="container">
        <div class="card border-0 shadow p-5">
            <div class="row">
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Keywords">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Location">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        <option value="">Engineering</option>
                        <option value="">Accountant</option>
                        <option value="">Information Technology</option>
                        <option value="">Fashion designing</option>
                    </select>
                </div>
                
                <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                    <div class="d-grid gap-2">
                        <a href="jobs.html" class="btn btn-primary btn-block">Search</a>
                    </div>
                    
                </div>
            </div>            
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
 @if($categoris->isNotEmpty())
 @foreach ($categoris as $category )
     
 
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="single_catagory">
                    <a href="jobs.html"><h4 class="pb-2">{{ $category->name }}</h4></a>
                    <p class="mb-0"> <span>50</span> Available position</p>
                </div>
              
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                   
                    <div class="row">
                       
                        @if ($isfeaturedjobs->isNotEmpty())
                        @foreach ($isfeaturedjobs as $featuredjob)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $featuredjob->title }}</h3>
                                    <p>{{ $featuredjob->description }}.</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $featuredjob->location }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$featuredjob->jobType->name  }}</span>
                                        </p>
                                        @if(!is_null($featuredjob->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $featuredjob->salary }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{ route('getjob',$featuredjob->id) }}" class="btn btn-primary btn-lg">Details</a>
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
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($latests->isNotEmpty())
                        @foreach ($latests as $latest)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $latest->title }}</h3>
                                    <p>
                                        @php
                                            $words = explode(' ', $latest->description);
                                            $short_description = implode(' ', array_slice($words, 0, 11)) . '...';
                                        @endphp
                                        {{ $short_description }}
                                    </p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $latest->location }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$latest->jobType->name  }}</span>
                                        </p>
                                        @if(!is_null($latest->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $latest->salary }}</span>
                                        </p>
                                        @endif
                                   

                                    <div class="d-grid mt-3">
                                        <a href="{{ route('getjob',$latest->id) }}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
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
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>
@endsection