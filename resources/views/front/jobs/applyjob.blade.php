@extends('layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My Jobs</li>
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
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href="{{ route('acc.makejob') }}" class="btn btn-primary">Post a Job</a>
                            </div>
                            
                        </div>
                        
                        <div class="table-responsive">
                            
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobs->isNotEmpty())
                                    @foreach ($jobs as $jobe )
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $jobe->job->title }}</div>
                                            <div class="info1">{{ $jobe->job->jobType->name }}.{{ $jobe->job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($jobe->created_at)->format('d M, Y') }}</td>
                                        <td>{{ $jobe->job->applications->count() }} Application </td>
                                        <td>
                                            @if ($jobe->job->status ==1)
                                            <div class="job-status text-capitalize">active</div>
                                            @else
                                            <div class="job-status text-capitalize">Block</div>
                                            @endif
                                           
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('getjob', $jobe->job->id ) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    
                                                    <li><a class="dropdown-item" onclick="deleteJob({{ $jobe->job->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                  
                                </tbody>
                                
                            </table>
                        </div>
                    <div> 
                        {{ $jobs->links() }}
                    </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
 function deleteJob(jobId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the delete request
                $.ajax({
                    url: "{{ route('acc.removejob') }}",
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        jobId: jobId
                    },
                    success: function(response) {
                        if (response.status === true) {
                            Swal.fire(
                                'Deleted!',
                                'Job has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page or redirect to another page
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the job.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
</script>
@endsection