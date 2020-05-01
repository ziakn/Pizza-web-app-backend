<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Image;
use App\OrderPizza;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data=OrderPizza::orderBy('id','DESC');
              
        $data=$data->with('pizza');
        if(isset($request->show) && !empty($request->show))
        {
            $show=$request->show;
            $data=$data->paginate($show);
    
        }
        else
        {
            $data=$data->get();
        }
        return $data;
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
       
    }

    public function show($id)
    {
       
    }

    public function edit(Request $request,$id)
    {
        
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
       

    }

    
}

