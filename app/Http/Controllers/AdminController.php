<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');

    }   //end Methid

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } //End Method

    
    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

   public function AdminProfile()
   {
      $id = Auth::user()->id;
      $profileData = User::find($id);
      return view('admin.admin_profile_view',compact('profileData'));
   }

   public function AdminProfileStore(Request $request)
   {
      $id = Auth::user()->id;
      $data = User::find($id);
      $data ->username = $request->username;
      $data ->name = $request->name;
      $data ->email = $request->email;
      $data ->phone = $request->phone;
      $data ->address = $request->address;
      $data ->username = $request->username;


   if($request->file('photo')) {
       $manager = new ImageManager(new Driver());
    
       
       //$name_gen = hexdec(uniqid()).'.'.$request->file('photo')->getClientOriginalExtension();
       //$name_gen = date('YmdHi').$request->file('photo')->getClientOriginalName();
       $name_gen = date('YmdHi').$request->file('photo')->getClientOriginalExtension();
       
       $img = $manager->read($request->file('photo'));
       //$img = @$manager->make($request->file('photo'));


       $img = $img->resize(360,250);
       //$img->toJpeg(80)->save('upload/admin_images/'.$name_gen);
       $img->save('upload/admin_images/'.$name_gen);
       //$save_url = 'upload/admin_images/'.$name_gen;
       $data['photo'] = $name_gen;
   }


 //if ($request->file('photo'))
 // {

 //  $manager = new ImageManager(new Driver());
 //   $file = $request->file('photo'); 
 //   @unlink(public_path('upload/admin_images/'.$data->photo));
 //   $filename = date('YmdHi').$file->getClientOriginalName();
 //   $file->move(public_path('upload/admin_images'),$filename);
 //   $data['photo'] = $filename;
 // }
    $data->save();

    $notification = array(
        'message' => 'Admin Profile Updated Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
   }//End Method

   public function AdminChangePassword() {
    
    $id = Auth::user()->id;
    $profileData = User::find($id);

    return view('admin.admin_change_password', compact('profileData'));

   } //end method


   public function AdminUpdatePassword(Request $request){
   
    //validation
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|confirmed'
    ]);

    //match old password
    if (!Hash::check($request->old_password, auth::user()->password)){

        $notification = array(
            'message' => 'Old Password Does not match!',
            'alert-type' => 'error'
        );

        return back()->with($notification);

    }

    //update new password
    User::whereId(auth()->user()->id)->update([
        
        'password' => Hash::make($request->new_password)
        
    ]);
    $notification = array(
        'message' => 'Password changed successfully!',
        'alert-type' => 'success'
    );

    return back()->with($notification);
 
   } //end method

   /// Admin User All Method

   public function AllAdmin(){

      $alladmin = User::where('role','admin')->get();
      return view('backend.pages.admin.all_admin',compact('alladmin'));

   }//End Method

   public function AddAdmin(){

      $roles = Role::all();
      return view('backend.pages.admin.add_admin',compact('roles'));

   }//End Method

   public function StoreAdmin(Request $request){

    $user = new User();
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->password = Hash::make($request->password);
    $user->role ='admin';
    $user->status = 'active';
    $user->save();

     if ($request->roles) {
       $user->assignRole($request->roles);  
     }

     $notification = array(
         'message' => 'New Admin User Inserted Successfully!',
         'alert-type' => 'success'
     );

     return redirect()->route('all.admin')->with($notification);

  }//end method

  public function EditAdmin($id){
 
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('backend.pages.admin.edit_admin',compact('user','roles'));

  }//end method

  public function UpdateAdmin(Request $request,$id){

    $user = User::findOrFail($id);
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->role ='admin';
    $user->status = 'active';
    $user->save();
    
    $user->roles()->detach();

     if ($request->roles) {
       $user->assignRole($request->roles);  
     }

     $notification = array(
         'message' => 'Admin User Updated Successfully!',
         'alert-type' => 'success'
     );

     return redirect()->route('all.admin')->with($notification);

  }//end method

  public function DeleteAdmin($id){

    $user = User::findOrFail($id);
    if(!is_null($user)){
        
        $user->delete();
    }

    $notification = array(
        'message' => 'User Deleted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

  }

}
