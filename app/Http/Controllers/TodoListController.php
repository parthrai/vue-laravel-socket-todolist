<?php

namespace App\Http\Controllers;

use App\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class TodoListController extends Controller
{
    //

    public function index(){

        return response(Todo::all()->jsonSerialize(), Response::HTTP_OK);

    }

    public function store(Request $request){

        //dd(Auth::check());

        $task = new Todo();
        $task->task = $request->task;
        $task->user_id=1;
        $task->save();

        $data=[
            'event'=>'TaskAdded',
            'data'=>[
                'taskName'=>$request->task,
            ]

        ];

        Redis::publish('test-channel',json_encode($data));






        return response($task->jsonSerialize(), Response::HTTP_CREATED);

    }

    public function destroy($id){

        Todo::destroy($id);


        //return response(Todo::all()->jsonSerialize(), Response::HTTP_OK);

        $data=[
            'event'=>'TaskAdded',
            'data'=>[
                'allTasks'=>Todo::all(),
            ]

        ];

        Redis::publish('test-channel',json_encode($data));

        return response("deleted with id ".$id, Response::HTTP_OK);
    }
}
