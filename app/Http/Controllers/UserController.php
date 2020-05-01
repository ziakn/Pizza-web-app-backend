<?php

namespace App\Http\Controllers;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Mail;
use Auth;
use Session;
use Redirect;
use Image;
use DB;
class UserController extends Controller
{


    
    public function index()
   {
       $auth=Auth::user();
       
       if($auth->userType==1)
       {
            $data=User::where('userType','!=', 1)
            ->get();
       }
       elseif($auth->userType==2)
       {
            $bde_Data=User::where('parent_id',$auth->id)
            ->where('userType',3)
            ->get();
            $bde_id=array();
            foreach($bde_Data as $item)
            {
                array_push($bde_id,$item['id']);
            }
            $authid=$auth->id;
            $data=User::with('user_type')
            ->where(function ($query) use($authid,$bde_id){
                $query->where('parent_id',$authid)
                ->orwherein('parent_id',$bde_id);
            })
            ->get();
       
       }
       else
       {
            $data=User::with('user_type')
            ->where('parent_id',$auth->id)
            ->get();
       }

       return $data;
   }

   public function store(Request $request)
   {
        $auth=Auth::user();
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
        $user=new User;
        $user->parent_id=$auth->id;
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->userType=$request->input('userType');
        $user->password=bcrypt($request->input('password'));
        $user->save();

        // $data['password'] =$request->password;
        // $data['email'] =$request->email;
        // Mail::send('mailview', $data, function($message) use ($request) {
        //     $message->to( $request->email , $request->name )
        //     ->subject('Password for SimplistiQ Login');
        // });
        $response['data']=User::select('id','name','email','name','userType')
        ->find($user->id);
        DB::commit();
        $response['status'] = true;
    }
    catch (\Exception $e) {
        $response['data']=$e->getMessage();
        $response['status'] = false;
        DB::rollback();
    }
    return response()->json($response);
   }

   public function update(Request $request, $id)
   {
    //    dd($request->all());
        $response=array();
        $response['status']=false;
        $response['data'] ='';
        DB::beginTransaction();
        try {
            $response['data']=User::where('id',$id)
       ->update(
        [
            'name' => $request->name,
            'email' => $request->email,
            'userType' => $request->userType,
        
        ]
    );
    DB::commit();
    $response['status'] = true;
} catch (\Exception $e) {
    $response['data']=$e->getMessage();
    $response['status'] = false;
    DB::rollback();
}
return response()->json($response);
}
    
   public function destroy($id)
    {
        $response=array();
        $response['status']=false;
        $response['data']  = User::find($id);
        if($response['data'])
        {
                $response['data']=$response['data']->delete();
                $response['status']=true;
           
        }
        else
        {
            $response['data']="Data Not deleted";  
        }
        return response()->json($response);
    }


    public function logout()
    {  
        Auth::logout();
        Session::flush();
        return Redirect::to('/login');
    }

    public function profile()
    {
        $data=Auth::user();
        return $data;
    }

    public function changePass(Request $request)
    {
        

        $request->validate([
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);
        if(!Hash::check($request->oldPassword,Auth::user()->password))
        {
            return response()->json(
                [
                    'status'=> false,
                    'message'=> 'Current Password dose not matched'
                ], 200);
        }
        else
        {                     
            $update=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);  
            if($update)   
            {
                return response()->json(
                    [
                        'status'=> true,
                        'message'=> 'Successfuly Changed'
                    ], 200);
            } 
            else
            {
                return response()->json(
                    [
                        'status'=> false,
                        'message'=> 'Failed, Try again'
                    ], 200);
            }

        }
    }

    public function updateUser(Request $request)
    {
        $update=User::where('id',$request->id)->update(
            [
                'name' => $request->name
            ]);
        return $update;
    }

    public function updatepassword(Request $request)
   {
        $update=User::where('id',$request->id)->update(
           [
               'password'=>bcrypt($request->password),
           ]
        );
        // $data['password'] =$request->password;
        // $data['email'] =$request->email;
        // Mail::send('mailview', $data, function($message) use ($request) {
        //     $message->to( $request->email , $request->name )
        //     ->subject('Password for SimplistiQ Solution Login');
        // });
       return $update;
   }

   public function avatar(Request $request)
   {
       $user_id = Auth::id();
       //return $request->all();
       $request->file('myFile')->store('public/uploads/avatar');
       $pic= '/storage/uploads/avatar/'.$request->myFile->hashName();   
       Image::make('storage/uploads/avatar/'.$request->myFile->hashName())->fit(600, 400, function($constraint) {
        $constraint->aspectRatio();})->save('storage/uploads/avatar/'.$request->myFile->hashName());              
       $update=User::where('id', $user_id)->update([
           'image' => $pic
       ]);
       if($update)
       {
        return response()->json([
            'data' => $pic,
            'status' => true
        ],200);
        }
        return response()->json([
            'data' => 'Failed',
            'status' => false
        ],200);
   }
}
