<?php

namespace App\Http\Controllers;

use App\Models\DraftCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DraftCategoriesController extends Controller
{
    public function index()
    {

        $drafts = DraftCategories::get();
        return view('categories.draft.index', compact('drafts'));
    }

    public function create(Request $request)
    {
        $heading = "Create New Draft";
        $btntext = "Create";
        $actionurl = route('drafts.store');
        return view('categories.draft.store', compact('heading', 'btntext', 'actionurl'));
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
            $Draft = DraftCategories::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $Draft = null;
        }

        if ($Draft != null) {
            return redirect()->route('drafts')->with('success', 'Draft Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $Draft = DraftCategories::findOrFail($id);
        $heading = "Update Draft";
        $btntext = "Update";
        $actionurl = route('drafts.update');
        return view('categories.draft.store', compact('heading', 'btntext', 'actionurl', 'Draft'));
    }

    public function update(Request $request, )
    {
        // //dd($request->all());
        // // Validate incoming request data
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $Draft = DraftCategories::findOrFail($id);

        $Draft->name = $validatedData['name'];
        $Draft->save();

        return redirect()->route('drafts')->with('success', 'Draft Updated Successfully');

    }

    public function disable($id)
    {

        // Your deletion logic here
        $Draft = DraftCategories::findOrFail($id);
            $Draft->status = '0';
            $Draft->save();

            if($Draft){
                return redirect()->route('drafts')->with('delete', 'Draft Disable Successfully');
            }else{
                return redirect()->route('drafts')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $Draft = DraftCategories::findOrFail($id);
            $Draft->status = '1';
            $Draft->save();

            if($Draft){
                return redirect()->route('drafts')->with('success', 'Draft Enable Successfully');
            }else{
                return redirect()->route('drafts')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
}
