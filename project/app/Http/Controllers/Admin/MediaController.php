<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Media::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('photo', function(Media $data) {
                                $photo = $data->photo ? url('assets/images/medias/'.$data->photo):url('assets/images/noimage.png');
                                return '<img src="' . $photo . '" alt="Image">';
                            })
                            ->addColumn('url', function(Media $data) {
                                $url = $data->photo ? url('assets/images/medias/'.$data->photo):url('assets/images/noimage.png');
                                return $url;
                            }) 
                            
                            ->rawColumns(['photo', 'url'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.media.index');
    }

    //*** GET Request
    public function create()
    {
       
        return view('admin.media.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Media();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/medias',$name);           
            $input['photo'] = $name;
        } 
        if (!empty($request->meta_tag)) 
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);       
         }  
        if (!empty($request->tags)) 
         {
            $input['tags'] = implode(',', $request->tags);       
         }
        if ($request->secheck == "") 
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;         
         } 
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.'.'<a href="'.route("admin-media-index").'">View Post Lists</a>';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
        $cats = BlogCategory::all();
        $data = Media::findOrFail($id);
        return view('admin.media.edit',compact('data','cats'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Media::findOrFail($id);
        $input = $request->all();
            if ($file = $request->file('photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/medias',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/medias/'.$data->photo)) {
                        unlink(public_path().'/assets/images/medias/'.$data->photo);
                    }
                }            
            $input['photo'] = $name;
            } 
        if (!empty($request->meta_tag)) 
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);       
         } 
        else {
            $input['meta_tag'] = null;
         }
        if (!empty($request->tags)) 
         {
            $input['tags'] = implode(',', $request->tags);       
         }
        else {
            $input['tags'] = null;
         } 
        if ($request->secheck == "") 
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;         
         } 
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.'.'<a href="'.route("admin-media-index").'">View Post Lists</a>';
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Media::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(public_path().'/assets/images/medias/'.$data->photo)) {
            unlink(public_path().'/assets/images/medias/'.$data->photo);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
