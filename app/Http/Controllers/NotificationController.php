<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'notification']);
        $data = Notification::paginate(15);
        return view('notification', compact('data'));
    }

    public function delete(Request $request){
        $data =  explode(",", $request->get('deletemessages'));
        foreach ($data as $item) {
            $noti = Notification::find($item);
    	    $noti->delete();
        }
        // return response()->json($data);
        return response()->json('success');
    }
}
