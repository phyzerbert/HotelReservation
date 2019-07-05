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

    public function delete($id){
        $item = Notification::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }
}
