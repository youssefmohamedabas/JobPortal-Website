<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Mail\jobnotificationmail;
use App\Models\jobapplication;
use App\Models\Savejob;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class JobController extends Controller
{ public function indexjobs(){
    $categories=Category::where('status',1)->get();
    $jobtypes=JobType::where('status',1)->get();
    $jobs=Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->paginate(9);
return view('front.jobs.jobs',['categories'=>$categories,'jobtypes'=>$jobtypes,'jobs'=>$jobs,'req'=>null]);
    
}
    public function index(){
     $categoris=   Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
    $isfeaturedjob=Job::where(['status'=>1,
        'isFeatured'=>1])->orderBy('created_at','DESC')->with('jobType')->take(6)->get();
        $latest=Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->take(6)->get();
        return view('front.jobs.homejobs',['isfeaturedjobs'=>$isfeaturedjob,'latests'=>$latest,'categoris'=>$categoris]);
        
    }
    public function makejob(){
$categories=Category::orderBy('name','ASC')->where('status',1)->get();
$job_types=JobType::orderBy('name','ASC')->where('status',1)->get();
    return view('front.jobs.postjob',['categories'=>$categories,'jobtypes'=>$job_types
]);
    }

    public function savejob(Request $req) {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required', 
            'location' => 'required|max:50', 
            'jobtype' => 'required',
            'vacancy' => 'required|integer',
            'description' => 'required',
            'experience' => 'required',
            'company_name' => 'required|min:3|max:70',
            'keywords' => 'required',
        ];
    
        $validator = Validator::make($req->all(), $rules);
        $id = Auth::user()->id;        
    
        if ($validator->passes()) {
            $job = new Job();
            $job->title = $req->title;
            $job->category_id = $req->category;
            $job->user_id = $id;
            $job->location = $req->location;
            $job->job_type_id = $req->jobtype;
            $job->description = $req->description;
            $job->salary = $req->salary;
            $job->responsibility = $req->responsibility;
            $job->qualifications = $req->qualifications;
            $job->benefits = $req->benefits;
            $job->vacancy = $req->vacancy;
            $job->experience = $req->experience;
            $job->company_name = $req->company_name;
            $job->company_location = $req->company_location;
            $job->company_website = $req->company_website;
            $job->keywords = $req->keywords;
            
            $job->save();
    
            // Fetch the user
            $user = User::find($id);
            
            // Fetch the newly created job using its ID
            $jobnoty = Job::with(['categoryType', 'jobType'])->find($job->id); // Change here
    
            // Ensure the job exists before sending the email
            if ($jobnoty) {
                $maildata = [
                    'user' => $user,
                    'job' => $jobnoty
                ];
                Mail::to($user->email)->send(new jobnotificationmail($maildata));
            } else {
                // Handle the case where the job couldn't be found
                return response()->json([
                    'status' => false,
                    'errors' => ['job' => 'Job not found.']
                ]);
            }
    
            session()->flash('success', 'Job created Successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    
    public function showjob(){
$id=Auth::user()->id;
$jobs=Job::where('user_id',$id)->with('jobType')->paginate(10);

return view('front.jobs.myjob',['jobs'=>$jobs]);
        
    }
    public function editjob(Request $req,$id){
        $categories=Category::orderBy('name','ASC')->where('status',1)->get();
        $jobtypes=JobType::orderBy('name','ASC')->where('status',1)->get();
      
       $job= Job::where(['user_id'=>Auth::user()->id,'id'=>$id])->first();
       if($job==null){
        abort(404);
       }
       
return view('front.jobs.edit',['categories'=>$categories,'jobtypes'=>$jobtypes,'job'=>$job]);
        
    }
    public function updatejob(Request $req,$id){

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
$idauth=Auth::user()->id;        
if($validator->passes()){
$job= Job::find($id);

    $job->title=$req->title;
    $job->category_id=$req->category;
    $job->user_id=$idauth;

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
session()->flash('success','Job Updated Successfully');
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
    public function deletejob(Request $req){
        $jobid=$req->jobId;

        $job=Job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$jobid])->first();
if(!$job==null){
    Job::where([
        'user_id'=>Auth::user()->id,
        'id'=>$jobid])->delete();
        session()->flash('success','Job Deleted Successfully.');
         return response()->json(['status'=>true])  ; 
    
}
session()->flash('error','Either job deleted or not founded');
         return response()->json(['status'=>true])  ; 
    }

    public function detail($id){
       $job= Job::where(['id'=>$id ,
       'status'=>1])->with('jobType')->first();
       if($job==null){
        abort(404);
       }
        return view('front.jobs.job-page',['job'=>$job]);
    }
    public function detailmyjob($id){
        $job= Job::where(['id'=>$id ,
        'status'=>1])->with('jobType')->first();
        if($job==null){
         abort(404);
        }
         return view('front.jobs.myjob-page',['job'=>$job]);
     }
    
    public function applyjob($jobid) {
$job=Job::where('id',$jobid)->first();  
if (jobapplication::where('employer_id', auth()->id())->where('job_id', $jobid)->exists()) {
    return back()->with('error', 'You have already applied for this job.');
} 
if(($job->status==1) && ($job->user_id!=Auth::user()->id)){
 $apply=  new jobapplication();
$apply->user_id=$job->user_id;
$apply->job_id = $jobid;
$apply->applied_at = now();
$apply->employer_id = Auth::user()->id;
$apply->save();
 
    session()->flash('success','you are applied succesffuly for this job');
    return back();
}   else{
    return back()->with('error', 'Somthing went wrong try again');
}


}
public function myapplyjob(){
$jobs=jobapplication::where('employer_id',Auth::user()->id)->with(['job','job.jobType','job.applications'])->paginate(10);
    
return view('front.jobs.applyjob',['jobs'=>$jobs]);
    
}
public function removejob(Request $req){
  $job= jobapplication::where('job_id',$req->jobId)->where('employer_id',Auth::user()->id)->first();

    if(!is_null($job)){
$job->delete();
session()->flash('success','Job you was applied deleted  successfully');
        return response()-> json(['status'=>true]);
    }
    session()->flash('error','Somthing Went Wrong please try again');
    return response()-> json(['status'=>false]);

}
public function setSavejob($id){
    $job=Job::where('id',$id)->first();
    if(!is_null($job))
    {
       $savejob= Savejob::where('user_id',Auth::user()->id)->where('job_id',$id)->first();
       if(is_null($savejob))
       {
      $savejobe= new Savejob();
      $savejobe->user_id= Auth::user()->id;
      $savejobe->job_id= $id;
      $savejobe->save();
    session()->flash('success','Job Saved Succeffully in profile');
    return back();       }
       session()->flash('error','you are already saved the job');
       return back();
    }
    session()->flash('error',' Error:Job Not exist ');
    return back();
}

public function getsavejob(){
$userid=Auth::user()->id;
   $savejobs=Savejob::where('user_id',$userid)->with(['job','job.jobType','job.applications'])->paginate(10);
   return view('front.jobs.savejobs',['jobs'=>$savejobs]);
}
public function removesavejob(Request $req){
    $job= Savejob::where('job_id',$req->jobId)->where('user_id',Auth::user()->id)->first();
  
      if(!is_null($job)){
  $job->delete();
  session()->flash('success','Job you was Saved removed  successfully');
          return response()-> json(['status'=>true]);
      }
      session()->flash('error','Something Went Wrong please try again');
      return response()-> json(['status'=>false]);
  
  }
  public function searchjob(Request $req) {
    // Initialize the query builder for the Job model
    $query = Job::query();

    // Check if the category is provided, then add to query
    if ($req->has('category') && !empty($req->category)) {
        $query->where('category_id', $req->category);
    }

    // Check if the keywords are provided, then add to query
    if ($req->has('keywords') && !empty($req->keywords)) {
        $query->where(function($q) use ($req) {
            $q->where('keywords', 'LIKE', '%' . $req->keywords . '%')
              ->orWhere('title', 'LIKE', '%' . $req->keywords . '%');
        });
    }

    // Check if the location is provided, then add to query
    if ($req->has('location') && !empty($req->location)) {
        $query->where('location', 'LIKE', '%' . $req->location . '%');
    }

    // Check if the job type is provided, then add to query
    if ($req->has('job_types') && !empty($req->job_types)) {
        // Debugging: Log the selected job types
        
        $query->whereIn('job_type_id', $req->job_types);
    }

    // Check if the experience is provided, then add to query
    if ($req->has('experience') && !empty($req->experience)) {
        // Assuming 'experience' is stored as years in the database
        if ($req->experience == 11) {
            $query->where('experience', '>', 10);
        } else {
            $query->where('experience', '=', $req->experience);
        }
    }
if ($req->has('sort')&&!empty($req->sort)){
    if($req->sort=='latest'){
        $query->orderBy('created_at','DESC');
    }
    elseif($req->sort=='oldest'){
        $query->orderBy('created_at','ASC');
    }
}
    // Execute the query and get the results
    $jobs = $query->with('jobType')->get();
    $categories = Category::where('status', 1)->get();
    $jobtypes = JobType::where('status', 1)->get();

    // Return the view with the jobs result
    return view('front.jobs.jobs', [
        'categories' => $categories,
        'jobtypes' => $jobtypes,
        'jobs' => $jobs,
        'req' => $req
    ]);
}


}