<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Categories;
    use Auth;
    use App\Http\Responses\Response;
    
    class CategoriesController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
        }
        
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function create(Request $request)
        {
            //add more advanced validation like checking if relation object exists
            $this->validate($request, [
                "name" => 'required',
                "description" => 'required'               
             ]);

             
            if(Categories::Create($request->all())){
                return response()->json([], Response::STATUS_CREATED);
            }else{
                return response()->json(['status' => 'error'], Response::STATUS_BAD_REQUEST);
            }
        }
       
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function getById($id)
        {
            //we can add information about category and user in response
            $category = Categories::where('id', $id)->get();
            if(count($category)) {
                return response()->json($category);
            }

            return response()->json([], Response::STATUS_NOT_FOUND);
        }

         /**
         * Display the specified resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function get()
        {
            //we can add information about category and user in response
            $categories = Categories::get();
            return response()->json($categories);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            //add better validation
            $this->validate($request, [
                "name" => 'filled',
                "description" => 'filled',               
            ]);

            $category = Categories::find($id);
            
            if($category->fill($request->all())->save()){
               return response()->json([], Response::STATUS_NO_CONTENT);
            }

            return response()->json(Response::error("Something went wrong"));
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function delete($id)
        {
            if(Categories::destroy($id)){
                 return response()->json([],Response::STATUS_NO_CONTENT);
            }
        }
    }