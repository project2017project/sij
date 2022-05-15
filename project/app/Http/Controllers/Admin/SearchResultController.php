<?php

namespace App\Http\Controllers\Admin;
use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\SearchResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class SearchResultController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = SearchResult::orderBy('id')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('created_at', function(SearchResult $data) {
                                $date = $data->created_at->diffForHumans();
                                return  $date;
                            })
                            ->addColumn('name', function(SearchResult $data) {
                                $name = $data->search_name;
                                return  $name;
                            })
                          
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        $datas = DB::table('search_result')->get();
       // $datas = SearchResult::orderBy('id')->get();
        return view('admin.searchresult.index',compact('datas'));
    }

   
}
