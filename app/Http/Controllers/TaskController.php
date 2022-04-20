<?php

namespace App\Http\Controllers;

use App\Traits\FormatDates;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect;
use JamesMills\LaravelTimezone\Timezone;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    use FormatDates;

    public function index(Request $request){
        $tasks = Task::orderBy("id", "DESC")->get();
        $region = FormatDates::get_local_time();

        if ($request->ajax()) {
            $tasks = Task::orderBy("id", "DESC")->get();
            return DataTables::of($tasks)
                ->addIndexColumn()
                ->addColumn('description', function($row){
                    $desc = '<p>'.$row->name.' - <span style="font-style: italic; font-weight: 500">'.date('g:i A, jS F, Y', strtotime($row->deadline)).'</span></p>';
                    return $desc;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0);" data-val="'.$row->id.'" onclick="deleteTask('.$row->id.')" class="deleteBtn btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action','description'])
                ->make(true);
        }

        return view("tasks", compact('tasks', 'region'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required'
        ]);

        $input = $request->all();
        $task = new Task();
        $task->name = request("name");
        $task->deadline = FormatDates::convertTimeToUTCzone(request("date").' '.request("time"), FormatDates::get_local_time());
        $task->save();

    }
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        echo json_encode(['status' => 'success', 'message' => 'Task Deleted Successfully']);
    }

}
