<?php

namespace App\Http\Controllers;

use App\Models\DraftCategories;
use App\Models\Premium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PremiumController extends Controller
{
    public function index()
    {
        $plans = Premium::orderBy("created_at", "desc")->get();
        return view('premium.index', compact('plans'));
    }

    public function create()
    {
        $heading = "Create New Plan";
        $btntext = "Create";
        $actionurl = route('plans.store');
        $drafts = DraftCategories::all();
        return view('premium.store', compact('heading', 'btntext', 'actionurl', 'drafts'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'monthly_amount' => 'required',
            'yearly_amount' => 'required',
            'post' => 'required',
            'blue_tick' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'monthly_amount' => $request->monthly_amount,
            'yearly_amount' => $request->yearly_amount,
            'posts' => $request->post,
            'blue_tick' => $request->blue_tick,
        ];

        DB::beginTransaction();
        try {
            $Premium = Premium::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
            $Premium = null;
        }

        if ($Premium != null) {
            return redirect()->route('plans')->with('success', 'Plan Added Successfully');
        } else {
            return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $plans = Premium::findOrFail($id);
        $heading = "Update Plan";
        $btntext = "Update";
        $actionurl = route('plans.update');
        return view('premium.store', compact('heading', 'btntext', 'actionurl', 'plans'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $validatedData = $request->validate([
            'name' => 'required',
            'monthly_amount' => 'required',
            'yearly_amount' => 'required',
            'post' => 'required',
            'blue_tick' => 'required',
        ]);

        // Find the plan by ID
        $plan = Premium::findOrFail($id);

        // Update the plan attributes
        $plan->name = $validatedData['name'];
        $plan->monthly_amount = $validatedData['monthly_amount'];
        $plan->yearly_amount = $validatedData['yearly_amount'];
        $plan->posts = $validatedData['post'];
        $plan->blue_tick = $validatedData['blue_tick'];

        // Save the changes
        $res = $plan->save();
        if ($res) {
            return redirect()->route('plans')->with('success', 'Plan Updated Successfully');
        } else {
            return redirect()->route('plans')->with('error', 'Internal Server Error');
        }

    }

    public function disable($id)
    {

        // Your deletion logic here
        $plan = Premium::findOrFail($id);
            $plan->status = '0';
            $plan->save();

            if($plan){
                return redirect()->route('plans')->with('delete', 'Plan Disable Successfully');
            }else{
                return redirect()->route('plans')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }
    public function enable($id)
    {

        // Your deletion logic here
        $plan = Premium::findOrFail($id);
            $plan->status = '1';
            $plan->save();

            if($plan){
                return redirect()->route('plans')->with('success', 'Plan Enable Successfully');
            }else{
                return redirect()->route('plans')->with('info', 'Internal Serve Error');
            }
        // Additional deletion logic if needed

        // Redirect or return response
    }

}
