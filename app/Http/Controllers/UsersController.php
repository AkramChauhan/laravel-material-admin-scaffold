<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin',['only'=>['index','admin_manage_users']]);
        $this->middleware('auth');
    }
    public function index()
    {
        return view('layouts.admins.manage_users');
    }
    public function admin_manage_users(Request $request){
    
    
      $user_name_string = $request->input('search_str');
      
      $current_page = $request->input('current_page');
      $limit = $request->input('item_per_page');
      $offset = (($current_page-1) * $limit);
  
      $users = User::where('email','!=',NULL);
  
      // if($category_id!=0 && $category_id!=''){
      //   $users->where('category_id',$category_id);
      // }
      // if($group_type_id!=0 && $group_type_id!=''){
      //   $users->where('group_type_id',$group_type_id);
      // }
      if($user_name_string!=''){
        $users->where('name','LIKE','%'.$user_name_string.'%');
        $users->orWhere('phone_number','LIKE','%'.$user_name_string.'%');
      }
      
      $tempTotalUsers = $users->get();
      $total_records = count($tempTotalUsers);
      $users->offset($offset);
      $users->limit($limit);
      $users->orderBy('id','DESC');
  
      // echo $users->toSql();
      $users = $users->get();
       
      $pagination = array(
        "offset"=>$offset,
        "total_records"=>$total_records,
        "item_per_page"=>$limit,
        "total_pages"=>ceil($total_records/$limit),
        "current_page"=>$current_page,
      );
  
      $data = view('layouts.admins.ajax_users',['users'=>$users,'pagination'=>$pagination])->render();
      //$data = View::make('layouts.users.ajax_users',['users'=>$users])->render();
      return ['data'=>$data,'pagination'=>$pagination];
    }
    public function edit(){
        $user= User::find(Auth::user()->id);
        return view('layouts.users.my-account',['user'=>$user]);
    }
    
    public function update_basic(Request $request){
      $validator = Validator::make($request->all(), [
        'name'=> 'required|min:3',
        'username'=> "required|regex:/^[a-zA-Z_0-9]+$/u|min:6|unique:users,username,".Auth::user()->id,
      ]);
      if ($validator->fails()) {
        return redirect()->route('my-account', ['tab'=>'basic'])->withErrors($validator)->withInput();
      }

      $username = Str::slug($request->input('username'),'_');
      //save data 
      $userUpdate = User::where('id',Auth::user()->id)->update([
        'name'=>$request->input('name'),
        'username'=>$username,
        'phone_number'=>$request->input('phone_number'),
      ]);
      if($userUpdate){
        Session::flash('success', 'Your details updated successfully');
        return redirect()->route('my-account');           
      }else{
        Session::flash('errors', 'Error while updating your details');
      }
      //redirect with inputed data if something goes wrong
      return  back()->withInput();
    }
    public function update_social_media(Request $request){

      //just saving logic for future for profile score
      $validator = Validator::make($request->all(), [
        'facebook_link' => 'required_without_all:twitter_link,instagram_link',
        'twitter_link' => 'required_without_all:facebook_link,instagram_link',
        'instagram_link' => 'required_without_all:facebook_link,twitter_link',
      ]);
      if ($validator->fails()) {
        return redirect()->route('my-account', ['tab'=>'social-media-links'])->withErrors($validator)->withInput();
      }

      $socialLinkUpdates = User::where('id',Auth::user()->id)->update([
        'facebook_link'=>$request->input('facebook_link'),
        'twitter_link'=>$request->input('twitter_link'),
        'linkedin_link'=>$request->input('linkedin_link'),
        'instagram_link'=>$request->input('instagram_link'),
        'youtube_link'=>$request->input('youtube_link'),
        'website_link'=>$request->input('website_link'),
      ]);
      if($socialLinkUpdates){
        Session::flash('success', 'Social media links updated successfully');
        return redirect()->route('my-account',['tab'=>'social-media-links']);           
      }else{
        Session::flash('errors', 'Error while updating your details');
        return redirect()->route('my-account', ['tab'=>'social-media-links'])->withInput();
      } 
    }
    public function save_headshot(Request $request){
      $user_id= Auth::user()->id;
      $tmp= explode(',',request()->data);
      $image_data = base64_decode($tmp[1]);

      $base64_imageData = request()->data;
      $original_image_name = request()->name;
      $explodingArray = explode(".",$original_image_name);
      $extension = strtolower($explodingArray[count($explodingArray)-1]);
      $headshot_name = "user_".$user_id.".".$extension;
      // $extension = $extension);
      File::put('resources/headshots/' . $headshot_name, $image_data);
      
      $headshot_url=url('/')."/resources/headshots/".$headshot_name;
      $response = array(
        "status"	=> "success",
        "url"	=> $headshot_url,
        "filename"	=> $headshot_name
      );

      $profile_score = Auth::user()->profile_score;

      if(Auth::user()->headshot=="" && $headshot_url!=""){
        $profile_score+=10;
      }else if($headshot_url=='' && Auth::user()->headshot!=''){
        $profile_score-=10;
      }  
      
      $userUpdate = User::where('id',Auth::user()->id)->update([
        'profile_picture_url'=>$headshot_url,
      ]);
      echo json_encode($response);
    }
    public function change_password(Request $request){
      $messages = [
        'required'  => 'The :attribute field is required.',
        'same'    => 'New password and re-type password must be same.',
      ];
      $validator = Validator::make($request->all(), [
        'old_password'=> 'required|min:6',
        'new_password'=> 'required|min:6',
        'retype_password'=> 'required_with:new_password|same:new_password',
      ],$messages);
      if ($validator->fails()) {
        return redirect()->route('my-account', ['tab'=>'change-password'])->withErrors($validator)->withInput();
      }
      
      if (!Hash::check($request->old_password, Auth::user()->password)) { 
        Session::flash('error','Old password is Incorrect !');
        return redirect()->route('my-account', ['tab'=>'change-password'])->withInput();
      }else{
        $userUpdate = User::where('id',Auth::user()->id)->update([
          'password'=>bcrypt($request->input('new_password')),
        ]);
      }
      
      if($userUpdate){
        Session::flash('success', 'Password changed successfully');
        return redirect()->route('my-account', ['tab'=>'change-password']);           
      }else{
        Session::flash('errors', 'Error while changing your password');
        return redirect()->route('my-account', ['tab'=>'change-password'])->withInput();
      }
    }    
}
