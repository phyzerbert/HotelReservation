<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'hotel']);
        $data = Hotel::paginate(15);
        return view('hotels', compact('data'));
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);
        $data = $request->all();
        Hotel::create($data);
        return response()->json('success');
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $data = $request->all();
        $item = Hotel::find($request->get("id"));
        $item->update($data);
        return response()->json('success');
    }

    public function delete($id){
        $item = Hotel::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }
}
