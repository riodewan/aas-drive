<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    function index(){
        return view('dashboards.admins.index');           
    }

    function devices(){
        return view('dashboards.admins.devices');
    }

    function profile(){
        return view('dashboards.admins.profile');
    }
    
    function userList(){
        $users = DB::table('users') -> get();
        return view('dashboards.admins.userList', ['users' => $users]);
    }

    function updateInfo(Request $request){
        
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
                'favoritecolor'=>'required',
            ]);

            if(!$validator->passes()){
                return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
            }else{
                $query = User::find(Auth::user()->id)->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'favoriteColor'=>$request->favoritecolor,
                ]);

                if(!$query){
                    return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Your profile info has been update successfuly.']);
                }
            }
    }

    function updatePicture(Request $request){
        $path = 'users/images/';
        $file = $request->file('admin_image');
        $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed.']);
        }else{
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if( $oldPicture != '' ){
                if( \File::exists(public_path($path.$oldPicture))){
                    \File::delete(public_path($path.$oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);

            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, updating picture in db failed.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }
        }
    }

    function changePassword(Request $request){
        //Validate form
        $validator = Validator::make($request->all(),[
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !Hash::check($value, Auth::user()->password) ){
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
            ],
            'newpassword'=>'required|min:8|max:30',
            'cnewpassword'=>'required|same:newpassword'
        ],[
            'oldpassword.required'=>'Enter your current password',
            'oldpassword.min'=>'Old password must have atleast 8 characters',
            'oldpassword.max'=>'Old password must not be greater than 30 characters',
            'newpassword.required'=>'Enter new password',
            'newpassword.min'=>'New password must have atleast 8 characters',
            'newpassword.max'=>'New password must not be greater than 30 characters',
            'cnewpassword.required'=>'ReEnter your new password',
            'cnewpassword.same'=>'New password and Confirm new password must match'
        ]);

            if( !$validator->passes() ){
                return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
            }else{
                
            $update = User::find(Auth::user()->id)->update(['password'=>Hash::make($request->newpassword)]);

            if( !$update ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your password has been changed successfully']);
            }
        }
    }

    public function showAllFiles($folderId=null){

        if($folderId){
            $files = DB::table('files') -> where('folder_id', $folderId)-> get();
            $folders = [];
        }
        else{
            $files = DB::table('files') -> where('folder_id', null) -> get();
            $folders = DB::table('folders') -> get();
        }
        
        return view('dashboards.admins.index', ['files' => $files, 'folders' => $folders, 'folderId' => $folderId]);
    }

    public function adminCreateFolder(Request $request) {
        $folder = new Folder();
        $folder->folder_name=$request->name;
        $folder->user_id= Auth::user()->id;
        $folder->save();

        return back()
        ->with('success','Folder has been created.');
    }
    
    public function adminFileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:jpg,jpeg,png,mp4,pdf,docx,xlsx,xlx,zip|max:100000'
        ]);
    
        $fileModel = new File;
        $folderId = $req->input('folder_id', null);

        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = $fileName;
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->user_id = Auth::user()->id;
            $fileModel->folder_id = $folderId;
            $fileModel->save();
    
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }

    public function showAdminFiles($folderId=null){
        //$files = DB::table('files') -> get();
        $user = User::where('id',Auth::user()->id)->with('files')->with('folders')->first();
        if($folderId){
            $files = $user->files->filter(function($value)use($folderId){
                return $value->folder_id==$folderId;
            });

            $folders = [];
        }
        else{
            $files = $user->files->filter(function($value){
                return $value->folder_id==null;
            });

            $folders = $user->folders;
        }
        return view('dashboards.admins.devices', ['files' => $files, 'folders' => $folders, 'folderId' => $folderId]);
    }

    public function viewAdminFile($fileId){
        $file = File::find($fileId);

        $extension = $file->getClientOriginalExtension();
        
        return view('dashboards.admins.viewFileAdmin', compact('file'));
    }

    public function viewDashboardFile($fileId){
        $file = File::find($fileId);
        
        return view('dashboards.admins.viewFileDash', compact('file'));
    }
    
    public function deleteAdminFile($fileId) {
        File::where('id', $fileId)->delete();

        return back()
        ->with('success','File Deleted Successfully');
    }
}
