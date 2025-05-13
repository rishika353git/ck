<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;


class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::get();
        return view('skills.index', compact('skills'));

    }
    public function create(Request $request)
    {
        $heading = "Create New Skill";
        $btntext = "Create";
        $actionurl = route('skills.store');
        return view('skills.store', compact('heading', 'btntext', 'actionurl'));
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
            $Skill = Skill::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $Skill = null;
        }

        if ($Skill != null) {
            return redirect()->route('skills')->with('success', 'Skill Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $Skill = Skill::findOrFail($id);
        $heading = "Update Skill";
        $btntext = "Update";
        $actionurl = route('skills.update');
        return view('skills.store', compact('heading', 'btntext', 'actionurl','Skill'));
    }

    public function update(Request $request,) {
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $Skill = Skill::findOrFail($id);
        $Skill->name = $validatedData['name'];
        $Skill->save();
        return redirect()->route('skills')->with('success', 'Skill Updated Successfully');

    }

    public function disable($id)
    {

        // Your deletion logic here
        $skills = Skill::findOrFail($id);
            $skills->status = '0';
            $skills->save();

            if($skills){
                return redirect()->route('skills')->with('delete', 'Skill Disable Successfully');
            }else{
                return redirect()->route('skills')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $skills = Skill::findOrFail($id);
            $skills->status = '1';
            $skills->save();

            if($skills){
                return redirect()->route('skills')->with('success', 'Skill Enable Successfully');
            }else{
                return redirect()->route('skills')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
}
