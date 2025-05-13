<?php

namespace App\Http\Controllers\web;

use App\Models\Court;
use App\Models\SubCourt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubCourtController extends Controller
{
    public function index()
    {

        $subcourts = DB::table('sub_court')
        ->join('court', 'sub_court.court_id', 'court.id')
        ->select('sub_court.*', 'court.*', 'court.name as courtname', 'sub_court.name as sub_courtname','sub_court.id as sub_courtid')
        ->get();
        return view('subcourts.index', compact('subcourts'));
    }

    public function create(Request $request)
    {
        $heading = "Create New Sub Court";
        $btntext = "Create";
        $actionurl = route('subcourts.store');
        $courts = Court::where('status',1)->get();
        return view('subcourts.store', compact('heading', 'btntext', 'actionurl','courts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'court_id' => 'required',
            'name'=>'required',
        ]);

        $data = [
            'court_id' => $request->court_id,
            'name' => $request->name,
        ];

        DB::beginTransaction();
        try {
            $SubCourt = SubCourt::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $SubCourt = null;
        }

        if ($SubCourt != null) {
            return redirect()->route('subcourts')->with('success', 'Sub Court Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {

        // Your deletion logic here
        $SubCourt = SubCourt::findOrFail($id)->delete();

            if($SubCourt){
                return redirect()->route('subcourts')->with('delete', 'Sub Court delete Successfully');
            }else{
                return redirect()->route('subcourts')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function edit($id){
        $SubCourt = SubCourt::findOrFail($id);
        $heading = "Update Sub Court";
        $btntext = "Update";
        $actionurl = route('subcourts.update');
        $courts = Court::get();
        return view('subcourts.store', compact('heading', 'btntext', 'actionurl','SubCourt','courts'));
    }

    public function update(Request $request,) {
        // Validate incoming request data
        $id = $request->input('id');
        $validatedData = $request->validate([
            'court_id' => 'required',
            'name' => 'required',
        ]);

        // Find the SubCourt by ID
        $subCourt = SubCourt::findOrFail($id);

        // Update the SubCourt with the provided data
        $subCourt->court_id = $validatedData['court_id'];
        $subCourt->name = $validatedData['name'];
        $subCourt->save();

        // Redirect back with success message
       // subcourts
        return redirect()->route('subcourts')->with('success', 'Sub Court Updated Successfully');

    }

}
