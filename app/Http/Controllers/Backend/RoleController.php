<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use App\Models\User;
use DB;

class RoleController extends Controller
{
    public function AllPermission()
    {
       $permissions = Permission::all();
       return view('backend.pages.permission.all_permission',compact('permissions'));       
    } //end method

    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    }// end method

    public function StorePermission(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,  
        ]);

        $notification = array(
            'message' => 'Permission Create Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }// end method

    public function EditPermission($id){
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));

    }

    public function UpdatePesmission(Request $request)
    {
        $per_id = $request->id;

        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,  
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }// end method

    public function DeletePermission($id){
    
        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }//end method

    public function ImportPermission (){
        return view('backend.pages.permission.import_permission');
    } //End Method

    public function Export(){
       return Excel::download(new PermissionExport, 'permission.xlsx');
    }//End Method

    public function Import(Request $request){

        Excel::import(new PermissionImport, $request->file('import_file'));
        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method

    ///Role all method

    public function AllRoles(){
       $roles = Role :: all();
       return view('backend.pages.roles.all_roles',compact('roles'));
    }

    public function AddRoles(){
        return view('backend.pages.roles.add_roles');
    }//end method

    public function StoreRoles(Request $request)
    {
        Role::create([
            'name' => $request->name, 
        ]);

        $notification = array(
            'message' => 'Role Create Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    }// end method

     public function EditRoles($id){
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles',compact('roles'));
     }

     public function UpdateRoles(Request $request)
    {
        $role_id = $request->id;
        Role::findOrFail($role_id)->update([
            'name' => $request->name, 
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    }// end method
     

    public function DeleteRoles($id){
        
        Role::findOrFail($id)->delete();
          
          $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
          );

          return redirect()->back()->with($notification);
    }//end method


    /////////////  Add Role Permission all Method //////////

    public function AddRolesPermission(){

        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission',compact('roles','permissions','permission_groups'));
    }//end method

    public function RolePermissionStore(Request $request){
 
      $data = array();
      $permissions = $request->permission;

      foreach($permissions as $key => $item){
        $data['role_id'] = $request->role_id;
        $data['permission_id'] = $item;

        DB::table('role_has_permissions')->insert($data);

      }//end foreach

      $notification = array(
        'message' => 'Role Permission Added Successfully',
        'alert-type' => 'success'
      );
        return redirect()->route('all.roles.permission')->with($notification);

    }//end method

    public function AllRolesPermission(){
        
         $roles = Role::all();
         return view('backend.pages.rolesetup.all_roles_permission',compact('roles'));

    }//end method

    public function AdminEditRoles($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission',
        compact('role','permissions','permission_groups'));
    }//end method

    public function AdminRolesUpdate(Request $request, $id){

       $role = Role :: findOrFail($id);
       $permissions = $request->permission;

       if (!empty($permissions)) {
        $role->syncPermissions($permissions);
       }

       $notification = array(
        'message' => 'Role Permission Updated Successfully',
        'alert-type' => 'success'
      );
     
      return redirect()->route('all.roles.permission')->with($notification);

    }//end method

    public function AdminDeleteRoles($id){
     
        $role = Role::findOrFail($id);
        if(!is_null($role)) {
            $role->delete();
        } 

        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
          );

          return redirect()->back()->with($notification);

    }
}
