<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function makejob(){
$categories=Category::orderBy('name','ASC')->where('status',1)->get();
$job_types=JobType::orderBy('name','ASC')->where('status',1)->get();
    return view('front.jobs.postjob',['categories'=>$categories,'jobtypes'=>$job_types
]);
    }

    public function savejob(Request $req){

        $rules=[
            'title'=>'required|min:5|max:200',
            'category'=>'required', 
            'location'=>'required|max:50', 
            'jobtype'=>'required',
             'vacancy'=>'required|integer',
             'description'=>'required',
             'experience'=>'required',
             'company_name'=>'required|min:3|max:70',
             'keywords'=>'required',
             
        ];
$validator=Validator::make($req->all(),$rules);
$id=Auth::user()->id;        
if($validator->passes()){
$job=new Job();
    $job->title=$req->title;
    $job->category_id=$req->category;
    $job->user_id=$id;

    $job->location=$req->location;

    $job->job_type_id=$req->jobtype;

    $job->description=$req->description;
    $job->salary=$req->salary;
    $job->responsibility=$req->responsibility;
    $job->qualifications=$req->qualifications;
    $job->benefits=$req->benefits;

    $job->vacancy=$req->vacancy;

    
    $job->experience=$req->experience;
    $job->company_name=$req->company_name;
    $job->company_location=$req->company_location;
    $job->company_website=$req->company_website;
    $job->keywords=$req->keywords;
$job->save();
session()->flash('success','Job created Successfully');
return response()->json([
    'status'=>true,
    'errors'=>[]
   ]);
}else{
   return response()->json([
    'status'=>false,
    'errors'=>$validator->errors()
   ]);
}
    }
    public function showjob(){
$id=Auth::user()->id;
$jobs=Job::where('user_id',$id)->with('jobType')->paginate(10);

return view('front.jobs.myjob',['jobs'=>$jobs]);
        
    }
}