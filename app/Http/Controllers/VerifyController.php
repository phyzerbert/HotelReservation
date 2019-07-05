<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class VerifyController extends Controller
{
    public function hotel_verify($id, $token){
        $item = Reservation::find($id);
        return view('verify.reply', compact('item'));
    }

    public function hotel_reply($id, $result){
        $item = Reservation::find($id);
        $item->hotel_status = $result;
        $item->save();
        return back()->with('success', 'You have repied successfully');        
    }
}
