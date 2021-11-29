<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function index(){
        return view('dashboards.users.index');
    }

    function profile(){
       return view('dashboards.users.profile');
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
        $file = $request->file('user_image');
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

    public function fileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:jpg,jpeg,png,gif,mp4,mp3,pdf,docx,xlsx,xlx,zip,rar|max:100000'
        ]);

        $fileModel = new File;
        $folderId = $req->input('folder_id', null);

        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->user_id = Auth::user()->id;
            $fileModel->folder_id = $folderId;

            $fileModel->save();

            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }

    public function showUserFiles($folderId=null){
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
        return view('dashboards.users.index', ['files' => $files, 'folders' => $folders, 'folderId' => $folderId]);
    }

    public function createFolder(Request $request) {
        $folder = new Folder();
        $folder->folder_name=$request->name;
        $folder->user_id= Auth::user()->id;
        $folder->save();

        return back()
        ->with('success','Folder has been created.');
    }

    public function viewFile($fileId){
        $file = File::find($fileId);
        
        return view('dashboards.users.view', compact('file'));
    }

    public function deleteFile($fileId) {
        File::where('id', $fileId)->delete();

        return back()
        ->with('success','File Deleted Successfully');
    }
}
