<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Models\AreaPractice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AreaPracticeController extends Controller
{
    public function index(){
        $areas = AreaPractice::orderBy("id","desc")->get();
        return view("practice.index",compact("areas"));

    }

    public function create(Request $request)
    {
        $heading = "Create New Area of Practice";
        $btntext = "Create";
        $actionurl = route('area.practice.store');
        return view('practice.store', compact('heading', 'btntext', 'actionurl'));
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
            $data = AreaPractice::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $data = null;
        }

        if ($data != null) {
            return redirect()->route('area.practice')->with('success', 'Area of Practice Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $AreaPractice = AreaPractice::findOrFail($id);
        $heading = "Update Area of Practice";
        $btntext = "Update";
        $actionurl = route('area.practice.update');
        return view('practice.store', compact('heading', 'btntext', 'actionurl','AreaPractice'));
    }

    public function update(Request $request,) {
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $data = AreaPractice::findOrFail($id);
        $data->name = $validatedData['name'];
        $data->save();
        return redirect()->route('area.practice')->with('success', 'Area of Practice Updated Successfully');

    }

    public function disable($id)
    {

        // Your deletion logic here
        $data = AreaPractice::findOrFail($id);
            $data->status = '0';
            $data->save();

            if($data){
                return redirect()->route('area.practice')->with('delete', 'Court Disable Successfully');
            }else{
                return redirect()->route('area.practice')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $data = AreaPractice::findOrFail($id);
            $data->status = '1';
            $data->save();

            if($data){
                return redirect()->route('area.practice')->with('success', 'Court Enable Successfully');
            }else{
                return redirect()->route('area.practiceR̥')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
}
