<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Permission;
use App\Grants;
use Validator;
use Auth;
use Hash;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
         $this->middleware('auth');
         $route = Route::getCurrentRoute()->getPath();
         $route = explode("/", $route);
         $exceptions = $route;
         $route = $route[0];
         $session = Session::get('grants');
         if(empty($session[$route]) && ( $exceptions[1] !="changepassword" && $exceptions[1] !="savepassword")){
           abort('401');
      
        }
 
        }

     /**
     * Changepassword function.
     *
     * @return \Illuminate\Http\Response
     */

    public function changepassword(){
       
        return view('users.changepassword');
    }
    
    public function savepassword(Request $request){
        
    $validator = Validator::make($request->all(),User::$changepassword,User::$messages);        
     if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
         $user = User::where('id','=',Auth::user()->id)
                     ->where('PASSWORD','=',bcrypt($request->oldpassword))  
                     ->first();
   


        if(!Hash::check($request->oldpassword, Auth::user()->password)){
            $validator->errors()->add('oldpassword', 
            'كلمة سر غير صحيحة');
            $this->throwValidationException(
                $request, $validator
            );
        }
        else {

        User::where('id', '=', Auth::user()->id)->update(['PASSWORD'=>bcrypt($request->password)]);
        \Session::flash('message','تم تغير كلمة المرور بنجاح');
        return redirect("/home");   
        }
       
    }


    public function create(){
         $permissions = Permission::all();
      
      return view('users.create',['permissions'=>$permissions]);   
    }


    public function add(Request $request){
     $validator = Validator::make($request->all(),User::$validations,User::$messages);
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

         $data = ['name'=>$request->name,
        'email'=>$request->email,
        'user_group' => 2,
        'STATUS' => 1 
        ];
        
        if(!empty($request->password)){
            $data['PASSWORD'] = bcrypt($request->password);
        }
         $next_id = collect(\DB::select(' SELECT USERS_SEQ.nextval FROM DUAL'))->first();
         $data['id'] = $next_id->nextval;
        $user = User::create($data);
       if($user){
        if(!empty($request->permissions)){
         foreach($request->permissions as $permission){
            Grants::create(['user_id'=>$user->id , 'permission_id' => $permission ]);
            }
        }
    }
       \Session::flash('message','تم اضافة المستخدم بنجاح');
        return redirect("users/users");   
    }




     /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */

    public function users(){

        $users = User::where('status','=','1')
                     ->where('user_group','=','2')
                     ->get();
        return view('users.users',['users'=>$users]);
    }


    public function suspend(Request $request){
        $data = $request->only('id');
       if(User::where('id', '=', $data['id'])->update(['status' => '0'])){
        return "success";
       }
        return "Error"; 
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {
               $user = User::where('id','=',$id)
                     ->where('user_group','=','2')
                     ->first();
        if($user){             
        $grants = $user->getgrants()->get(); 
        $usergrants = array();
        foreach ($grants as $grant ) {
            
            $usergrants[$grant->permission_id]="checked";
        }
        return view('users.edit',['user'=>$user,'usergrants'=>$usergrants,'permissions'=> Permission::all()]);
     }
     return view('home') ;
    }

   

     public function update(Request $request){

        $data = $request->only('name','email','password');
        
        $validator = Validator::make($request->all(),User::$editvalidations,User::$messages);
        
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $data = ['name'=>$request->name,
        'email'=>$request->email,
        ];
        
        if(!empty($request->password)){
            $data['PASSWORD'] = bcrypt($request->password);
        }

       if(User::where('id', '=', $request->id)->where('email', '=', $data['email'])->update($data)){
       
        
        Grants::where('user_id', $request->id)->delete(); 
        if(!empty($request->permissions)){
         foreach($request->permissions as $permission){
            Grants::create(['user_id'=>$request->id , 'permission_id' => $permission ]);
            }
        }

       \Session::flash('message','تم تعديل المستخدم بنجاح');
        return redirect("users/users");
       
       }

      

        //return "Error"; 
    
    }


    

}
