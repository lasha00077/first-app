<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenities;


class PropertyTypeController extends Controller
{
   public function AllType(){

    $types = PropertyType::latest()->get();
    return view('backend.type.all_type',compact('types'));

   } //end method

   public function AddType(){
      
      return view('backend.type.add_type');
   }//end method

   public function StoreType(Request $request){

       //validation
    $request->validate([
      'type_name' => 'required|unique:property_types|max:200',
      'type_icon' => 'required',
   ]);
   
   PropertyType::insert([

      'type_name' => $request->type_name,
      'type_icon' => $request->type_icon,
   ]);
   $notification = array(
      'message' => 'Property Type Create Successfully',
      'alert-type' => 'success'
  );
  return redirect()->route('all.type')->with($notification);

   }//end method

   public function EditType($id){
      $types = PropertyType::findOrFail($id);
      return view('backend.type.edit_type',compact('types'));

   }//end method

   public function UpdateType(Request $request){

  $pid = $request->id;    
  PropertyType::findOrFail($pid)->update([

     'type_name' => $request->type_name,
     'type_icon' => $request->type_icon,
  ]);
  $notification = array(
     'message' => 'Property Type Create Successfully',
     'alert-type' => 'success'
 );
 return redirect()->route('all.type')->with($notification);

  }//end method


  public function DeleteType($id){
 
   PropertyType::findOrFail($id)->delete();
   $notification = array(
      'message' => 'Property Type Deleted Successfully',
      'alert-type' => 'success'
  );
  return redirect()->back()->with($notification);
   
  }//end method 

  //// amenities all method

  public function AllAmenitie(){

   $amenities = Amenities::latest()->get();
   return view('backend.amenities.all_amenities',compact('amenities'));

  }  //end method
  
  public function AddAmenitie(){

   return view('backend.amenities.add_amenities');

  } //end method


  public function StoreAmenitie(Request $request){

Amenities::insert([

  'amenitis_name' => $request->amenitis_name,
]);
$notification = array(
  'message' => 'Amenities Create Successfully',
  'alert-type' => 'success'
);
return redirect()->route('all.amenitie')->with($notification);

}//end method


public function EditAmenitie($id){

  $amenities = Amenities::findOrFail($id);
  return view('backend.amenities.edit_amenities',compact('amenities'));

}//end method


public function UpdateAmenitie(Request $request){
   
   $ame_id = $request->id;
   Amenities::findOrFail($ame_id)->update([
   
     'amenitis_name' => $request->amenitis_name,
   ]);
   $notification = array(
     'message' => 'Amenities Updated Successfully',
     'alert-type' => 'success'
   );
   return redirect()->route('all.amenitie')->with($notification);
   
   }//end method

   public function DeleteAmenitie($id){

      Amenities::findOrFail($id)->delete();

      $notification = array(
         'message' => 'Amenities Deleted Successfully',
         'alert-type' => 'success'
       );
       return redirect()->back()->with($notification);

   }//End Method

   public function 

}
