<?php
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Http\Request;
    use App\Users;
    use Illuminate\Support\Str;
    use App\Http\Responses\Response;

    class UsersController extends Controller
    {
      public function __construct()
       {
         //  $this->middleware('auth:api');
       }
       
       
       public function login(Request $request)
       {
           $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
           ]);
       
           $user = Users::where('email', $request->input('email'))->first();
       
           if($user && Hash::check($request->input('password'), $user->password)) {
              $apikey = base64_encode(Str::random(64));
              Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
             
              return response()->json(['status' => 'success','api_key' => $apikey]);
          
           } else{
              return response()->json(['status' => 'fail'], 401);
          }
       }

       public function register(Request $request)
       {
           $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6',
                "firstname" => "required",
                "lastname"  => "required",
                "birthdate"  => "date", //improve 
                "phone" => "required", // add more complex validation like regex pattern
                "gender"  => "in:male,female",
           ]);

           $user = Users::where('email', $request->input('email'))->first();
       
           if($user) {
                return response()->json(Response::error("User already exists!"), Response::STATUS_BAD_REQUEST); 
           }

           $data = $request->all();
           $data["password"] = Hash::make($data["password"]); 

           $user = Users::create($data);

           //TODO check/ add better error handling ? 
           
           return response()->json([], Response::STATUS_CREATED); 
       
       }
    }    
    ?>