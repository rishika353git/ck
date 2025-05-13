<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::get();
        return view('categories.forum.index', compact('forums'));
    }

    public function create(Request $request)
    {
        $heading = "Create New Forum Categories";
        $btntext = "Create";
        $actionurl = route('forums.store');
        return view('categories.forum.store', compact('heading', 'btntext', 'actionurl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
        ];

        DB::beginTransaction();
        try {
            $Forum = Forum::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $Forum = null;
        }

        if ($Forum != null) {
            return redirect()->route('forums')->with('success', 'Forum Categories Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }



    public function edit($id){
        $Forum = Forum::findOrFail($id);
        $heading = "Update Forum Categories";
        $btntext = "Update";
        $actionurl = route('forums.update');
        return view('categories.forum.store', compact('heading', 'btntext', 'actionurl','Forum'));
    }

    public function update(Request $request,) {
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $Forum = Forum::findOrFail($id);
        $Forum->name = $validatedData['name'];
        $Forum->save();
        return redirect()->route('forums')->with('success', 'Forum Categories Updated Successfully');

    }

    public function disable($id)
    {

        // Your deletion logic here
        $Forum = Forum::findOrFail($id);
            $Forum->status = '0';
            $Forum->save();

            if($Forum){
                return redirect()->route('forums')->with('delete', 'Forum Categories Disable Successfully');
            }else{
                return redirect()->route('forums')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $Forum = Forum::findOrFail($id);
            $Forum->status = '1';
            $Forum->save();

            if($Forum){
                return redirect()->route('forums')->with('success', 'Forum Categories Enable Successfully');
            }else{
                return redirect()->route('forums')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
}
