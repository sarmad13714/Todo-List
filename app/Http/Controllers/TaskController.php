<?php

namespace App\Http\Controllers;

use App\Traits\FormatDates;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect;
use JamesMills\LaravelTimezone\Timezone;

class TaskController extends Controller
{
    use FormatDates;

    public function index(){
        $tasks = Task::orderBy("id", "DESC")->get();
        return view("tasks", compact('tasks'));
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
        return Redirect::back()->with("message", "Task has been added");

    }
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return Redirect::back()->with('message', "Task has been deleted");
    }

}
