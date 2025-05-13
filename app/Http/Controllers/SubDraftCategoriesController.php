<?php

namespace App\Http\Controllers;

use App\Models\DraftCategories;
use App\Models\SubDraftCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubDraftCategoriesController extends Controller
{
    public function index()
    {

        $subdrafts = DB::table('sub_draft_categories')
            ->join('draft_categories', 'sub_draft_categories.draft_id', 'draft_categories.id')
            ->select('sub_draft_categories.*',
                'draft_categories.*',
                'draft_categories.name as draft_categoriesname',
                'sub_draft_categories.name as sub_draft_categoriesname',
                'sub_draft_categories.id as sub_draft_categoriesid')
            ->get();

        return view('categories.subdraft.index', compact('subdrafts'));
    }

    public function create(Request $request)
    {
        $heading = "Create New Sub Drafts";
        $btntext = "Create";
        $actionurl = route('subdrafts.store');
        $drafts = DraftCategories::where('status', 1)->get();
        return view('categories.subdraft.store', compact('heading', 'btntext', 'actionurl', 'drafts'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'draft_id' => 'required',
            'name' => 'required',
        ]);

        $data = [
            'draft_id' => $request->draft_id,
            'name' => $request->name,
        ];

        DB::beginTransaction();
        try {
            $SubDraft = SubDraftCategories::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $SubDraft = null;
        }

        if ($SubDraft != null) {
            return redirect()->route('subdrafts')->with('success', 'Sub Drfats Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {

        $SubDraft = SubDraftCategories::findOrFail($id)->delete();

        if ($SubDraft) {
            return redirect()->route('subdrafts')->with('delete', 'Sub Draft delete Successfully');
        } else {
            return redirect()->route('subdrafts')->with('info', 'Internal Serve Error');
        }

    }
    public function edit($id)
    {
        $SubDraft = SubDraftCategories::findOrFail($id);
        $heading = "Update Sub Draft Categories";
        $btntext = "Update";
        $actionurl = route('subdrafts.update');
        $drafts = DraftCategories::get();
        return view('categories.subdraft.store', compact('heading', 'btntext', 'actionurl', 'SubDraft', 'drafts'));
    }

    public function update(Request $request, )
    {
        // dd($request->all());
        //     // Validate incoming request data
        $id = $request->input('id');
        $validatedData = $request->validate([
            'draft_id' => 'required',
            'name' => 'required',
        ]);

        // Find the SubCourt by ID
        $SubDraft = SubDraftCategories::findOrFail($id);

        // Update the SubDraft with the provided data
        $SubDraft->draft_id = $validatedData['draft_id'];
        $SubDraft->name = $validatedData['name'];
        $SubDraft->save();

        // Redirect back with success message
        // subcourts
        return redirect()->route('subdrafts')->with('success', 'Sub Drafts Updated Successfully');

    }

}
