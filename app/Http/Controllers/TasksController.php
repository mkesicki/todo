<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Tasks;
    use Auth;
    use App\Http\Responses\Response;
    use Illuminate\Support\Facades\DB;
    
    class TasksController extends Controller
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
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $task = Auth::user()->tasks()->get();
            return response()->json(['status' => 'success','result' => $task]);
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
                "status" => 'required',
                "list_id" => 'required',
                "category_id" => 'required',
                "date" => 'required',
             ]);


            $list = Auth::user()->lists()->find($request['list_id']);
            if($list && $list->tasks()->Create($request->all())){
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
            $task= Tasks::find($id);
            if($task && (Auth::user()->lists()->find($task->list_id)->user_id ) == Auth::user()->id) {
                return response()->json($task);
            } {
                return response()->json([], Response::STATUS_NOT_FOUND);
            }
            
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
                "status" => 'filled',
                "list_id" => 'filled',
                "category_id" => 'filled',
                "date" => 'filled',
            ]);

            $task = Tasks::find($id);

            if($task && (Auth::user()->lists()->find($task->list_id)->user_id ) == Auth::user()->id) {
                if($task->fill($request->all())->save()) {
                    return response()->json([], Response::STATUS_NO_CONTENT);
                }
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

            $task = Tasks::find($id);
            if($task && (Auth::user()->lists()->find($task->list_id)->user_id ) == Auth::user()->id) {
                if(Tasks::destroy($id)){
                    return response()->json([],Response::STATUS_NO_CONTENT);
                }
             }
        }

        public function getFiltered($filters)
        {
            $useFilters = [];
            $validFilter = ["status", "category_id"];
            $filters = explode('&', $filters);

            $query = "SELECT * FROM tasks t
                JOIN lists l ON (t.list_id = l.id)
                WHERE l.user_id = ?";

            //filters should be send better way
            foreach($filters as $filter) {
                list($name, $value ) = explode("=", $filter);
                if(in_array($name, $validFilter)) {
                    $useFilters[$name] = $value;
                }
            }

            $i = 0;
            $filterValues = [Auth::user()->id];

            //improve the way how query is build 
            foreach ($useFilters as $name => $value) {
              
                $query = sprintf("%s AND %s = ?", $query, $name);
                $filterValues[] = $value;
                $i++;
            }

            $tasks = DB::select($query, $filterValues);

            return response()->json($tasks);
        }
    }