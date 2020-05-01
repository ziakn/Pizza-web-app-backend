<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pizza;
use App\PizzaBranch;
use App\PizzaImage;
use App\PizzaCusine;
use App\PizzaIngredient;
use Auth;
use DB;
use Image;
class PizzaController extends Controller
{
    public function index(Request $request)
    {
        $data=Pizza::orderBy('id','ASC');
        if(isset($request->category_id) && !empty($request->category_id))
        {
            $category_id=$request->category_id;
            $data=$data->where('category_id',$category_id);
    
        }
        $data=$data->with('category')
        ->with('image')
        ->paginate(10);
       return $data;
    }
    public function products(Request $request)
    {
        $data=PizzaBranch::orderBy('id','ASC');
        if(isset($request->branch_id) && !empty($request->branch_id))
        {
            $branch_id=$request->branch_id;
            $data=$data->where('branch_id', '=', $branch_id);
    
        }
        $data=$data->with('Pizza')
        ->with('price')
        ->whereHas('Pizza', function ($query) {
            $query->where('status', '=', 1);
        })
        ->get();
       return $data;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        $auth_id=Auth::id();
        // dd($request->all());
        $validator = Validator::make(
            $request->all(), [
            'media.*' => 'required|mimes:jpg,jpeg,png,bmp|max:3000'
            ]
        );
        
        if ($validator->fails()) {
            $response['data'] = $validator->getMessageBag()->toArray();
            return response()->json($response);
        }

        DB::beginTransaction();
        try {

            $response['data']=Pizza::create([
                'user_id' => $auth_id,
                'category_id' => $request->category_id,
                'title'=>$request->title,
                'description' => $request->description,
                'model' => $request->model,
                'point' => $request->point,
                'sort' => $request->sort,
                'priceType' => $request->priceType,
                'price' => $request->price,
                'dimension' => $request->dimension,
                'veg' => $request->veg,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'status' => $request->status,
            ]);
            if(isset($request->media) && count($request->media))
            {
                foreach($request->media as $media)
                {
                    // dd($doc);
                    $name=$media->getClientOriginalName();
                    $src= $media->hashName();
                    $media->store('public/uploads/media');
                    PizzaImage::create([
                        'pizza_id' =>$response['data']->id,
                        'name' => $name,
                        'src' => '/storage/uploads/media/'.$src,
    
                    ]);
                }
        
            }
           
                   
            
            if(isset($request->cuisine) && count($request->cuisine))
            {
                
                foreach($request->cuisine as $cuisine)
                {
                    $cuisine=json_decode($cuisine);                  
                    PizzaCusine::create([
                        'pizza_id' => $response['data']->id,
                        'cuisine_id' => $cuisine->id,        
                    ]);
                }
            }
           
            if(isset($request->ingredient) && count($request->ingredient))
            {
                
                foreach($request->ingredient as $ingredient)
                {
                    $ingredient=json_decode($ingredient);                  
                    PizzaIngredient::create([
                        'pizza_id' => $response['data']->id,
                        'ingredient_id' => $ingredient->id,        
                    ]);
                }
            }
            
            DB::commit();
            $response['status'] = true;
        } catch (\Exception $e) {
            $response['data']=$e->getMessage();
            $response['status'] = false;
            DB::rollback();
        }
            
        return response()->json($response);
    }

    public function show($id)
    {
        $data=Pizza::with('cuisine')
        ->with('ingredient')
        ->with('image')
        ->find($id);
        return $data;
    }

    public function edit(Request $request,$id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
            if($request->status == "true")
            {
                $response['data']=Pizza::where('id',$id)
                ->update([
                    'status' => 0,
                ]);         
            }
            elseif($request->status == "false")
            {
                $response['data']=Pizza::where('id',$id)
                ->update([
                    'status' => 1,
                ]);         
            }
           
            DB::commit();
            $response['status'] = true;
        } catch (\Exception $e) {
            $response['data']=$e->getMessage();
            $response['status'] = false;
            DB::rollback();
        }
            
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
          // dd($request->all());
          $response=array();
          $response['status']=false;
          $response['data'] ='';
          $auth_id=Auth::id();
          if(!$auth_id)
              return response()->json($response);
  
              $validator = Validator::make(
                  $request->all(), [
                  'media.*' => 'required|mimes:jpg,jpeg,png,bmp|max:300'
                  ]
              );
              
              if ($validator->fails()) {
                  $response['data'] = $validator->getMessageBag()->toArray();
                  return response()->json($response);
              }
  
          DB::beginTransaction();
          try {
              $response['data']=Pizza::where('id',$request->id)
              ->update([
                'category_id' => $request->category_id,
                'title'=>$request->title,
                'description' => $request->description,
                'model' => $request->model,
                'point' => $request->point,
                'sort' => $request->sort,
                'priceType' => $request->priceType,
                'price' => $request->price,
                'dimension' => $request->dimension,
                'veg' => $request->veg,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'status' => $request->status,
              ]);
             
             
              PizzaCusine::where('pizza_id',$request->id)->delete();
              if(isset($request->cuisineEdit) && count($request->cuisineEdit))
              {
                  foreach($request->cuisineEdit as $cuisineEdit)
                  {                  
                      $cuisineEdit=json_decode($cuisineEdit);
                      PizzaCusine::create([
                          'pizza_id' => $request->id,
                          'cuisine_id' => $cuisineEdit->id,        
                      ]);
                  }
              }
           
              PizzaIngredient::where('pizza_id',$request->id)->delete();
              if(isset($request->ingredientEdit) && count($request->ingredientEdit))
              {
                  foreach($request->ingredientEdit as $ingredientEdit)
                  {                  
                      $ingredientEdit=json_decode($ingredientEdit);
                      PizzaIngredient::create([
                          'pizza_id' => $request->id,
                          'ingredient_id' => $ingredientEdit->id,        
                      ]);
                  }
              }
           
              PizzaImage::where('pizza_id',$request->id)->delete();      
              if(isset($request->imageEdit) && count($request->imageEdit))
              {
  
                  foreach($request->imageEdit as $image)
                  {
                      $image=json_decode($image); 
                      
                      $created=PizzaImage::create([
                          'pizza_id' =>$request->id,
                          'name' => $image->name,
                          'src' => $image->src,
      
                      ]);
                      // dd($image);
                  }
          
              }            
              if(isset($request->media) && count($request->media))
              {
                  foreach($request->media as $media)
                  {
                      $name=$media->getClientOriginalName();
                      $src= $media->hashName();
                      $media->store('public/uploads/media');
                      PizzaImage::create([
                          'pizza_id' => $request->id,
                          'name' => $name,
                          'src' => '/storage/uploads/media/'.$src,
                      ]);
                  }
          
              }            
              DB::commit();
              $response['status'] = true;
          } catch (\Exception $e) {
              $response['data']=$e->getMessage().', Line: '.$e->getLine();
              $response['status'] = false;
              DB::rollback();
          }
              
          return response()->json($response);
    }

    public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data'] = Pizza::find($id);
        if($response['data'])
        {
            DB::beginTransaction();
            try {
                DB::commit();
                PizzaImage::where('pizza_id',$id)->delete();
                PizzaCusine::where('pizza_id',$id)->delete();
                PizzaIngredient::where('pizza_id',$id)->delete();
                $response['data']=$response['data']->delete();
                $response['status'] = true;
            } catch (\Exception $e) {
                $response['data']=$e->getMessage().', Line: '.$e->getLine();
                $response['status'] = false;
                DB::rollback();
            }            

        }
        else
        {
            $response['data']="Product not Exist";  
        }
        return response()->json($response);

    }

    
}

