<?php

namespace App\Http\Controllers\web;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::get();
        return view('courts.index', compact('courts'));
    }

    public function create(Request $request)
    {
        $heading = "Create New Court";
        $btntext = "Create";
        $actionurl = route('courts.store');
        return view('courts.store', compact('heading', 'btntext', 'actionurl'));
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
            $Court = Court::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $Court = null;
        }

        if ($Court != null) {
            return redirect()->route('courts')->with('success', 'Court Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function edit($id){
        $Court = Court::findOrFail($id);
        $heading = "Update Court";
        $btntext = "Update";
        $actionurl = route('courts.update');
        return view('courts.store', compact('heading', 'btntext', 'actionurl','Court'));
    }

    public function update(Request $request,) {
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $Court = Court::findOrFail($id);
        $Court->name = $validatedData['name'];
        $Court->save();
        return redirect()->route('courts')->with('success', 'Court Updated Successfully');

    }

    public function disable($id)
    {

        // Your deletion logic here
        $Court = Court::findOrFail($id);
            $Court->status = '0';
            $Court->save();

            if($Court){
                return redirect()->route('courts')->with('delete', 'Court Disable Successfully');
            }else{
                return redirect()->route('courts')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $Court = Court::findOrFail($id);
            $Court->status = '1';
            $Court->save();

            if($Court){
                return redirect()->route('courts')->with('success', 'Court Enable Successfully');
            }else{
                return redirect()->route('courts')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
}
