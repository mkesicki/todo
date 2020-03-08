<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Lists;
    use Auth;
    use App\Http\Responses\Response;
    use Illuminate\Support\Facades\DB;
    
    class ListsController extends Controller
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
                "description" => 'required',
                "user_id" => 'required',
                "date" => 'required',
             ]);

             
            if(Auth::user()->lists()->Create($request->all())) {
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
            $list = Lists::where('id', $id)->where('user_id', Auth::user()->id)->get();
          
            if(!\count($list)) {
                return response()->json([],Response::STATUS_NOT_FOUND);    
            }
            return response()->json($list);
        }

         /**
         * Display the specified resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function get()
        {
            //we can add information about category and user in response
            $lists = Lists::where('user_id', Auth::user()->id)->get();
            return response()->json($lists);
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
                "user_id" => 'filled',
                "date" => 'filled',
            ]);

            $list = Lists::where('user_id', Auth::user()->id)->find($id);
            
            if($list->fill($request->all())->save()){
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
            if(Lists::where('user_id', Auth::user()->id)->find($id)->destroy($id)){
                 return response()->json([],Response::STATUS_NO_CONTENT);
            }
        }

        public function getTasks($id)
        {
            $list = Lists::where('user_id', Auth::user()->id)->find($id);
           
            if($list) {
                return response()->json($list->tasks()->get());
            }

            return response()->json([], Response::STATUS_NOT_FOUND);
        }

        public function getFilteredList($filters)
        {
            //date filters should be in format like:
            //YYYY-mm-dd - for date and mont
            //YYYY-mm - for month only
            $where = '';
            $query = "SELECT * FROM lists l
            WHERE l.user_id = ?";

            $whereValues = [Auth::user()->id];


            $list = [];
            $filter = explode("=", $filters);
            if($filter[0] == 'date') {

                $where = " AND date LIKE(?)";
                $whereValues[] = $filter[1]."%";
            }

            $lists = DB::select($query.$where, $whereValues);
            if($lists) {
                return response()->json($lists);
            }

            return response()->json([], Response::STATUS_NOT_FOUND);
        }
       
    }