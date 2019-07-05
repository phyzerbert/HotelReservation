<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Hotel;
use App\Models\Companion;
use App\Models\NumberOfRoom;
use App\Models\Notification;

use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use App\Mail\HotelMail;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        config(['site.page' => 'reservation']);
    }

    public function index(Request $request)
    {        
        $user = Auth::user();
        $role = $user->role->slug;
        $hotels = Hotel::all();
        $mod = new Reservation();

        $visitor_name = $hotel_id = $gm_status = $om_status = $period = '';

        if ($request->get('visitor_name') != ""){
            $visitor_name = $request->get('visitor_name');
            $mod = $mod->where('visitor_name', 'LIKE', "%$visitor_name%");
        }
        if ($request->get('hotel_id') != ""){
            $hotel_id = $request->get('hotel_id');
            $mod = $mod->where('hotel_id', $hotel_id);
        }
        if ($request->get('gm_status') != ""){
            $gm_status = $request->get('gm_status');
            $mod = $mod->where('gm_status', $gm_status);
        }
        if ($request->get('om_status') != ""){
            $om_status = $request->get('om_status');
            $mod = $mod->where('om_status', $om_status);
        }
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);  

        return view('reservation.index', compact('data', 'hotels', 'visitor_name', 'hotel_id', 'gm_status', 'om_status', 'period'));
    }

    public function create(Request $request){
        $hotels = Hotel::all();
        $number_of_rooms = NumberOfRoom::all();

        return view('reservation.create', compact('hotels', 'number_of_rooms'));
    }

    public function save(Request $request){
        $data = $request->all();
        $item = new Reservation();
        $item->user_id = Auth::user()->id;
        $item->visitor_name = $data['visitor_name'];
        $item->visitor_email = $data['visitor_email'];
        $item->visitor_phone_number = $data['visitor_phone_number'];
        $item->visit_date = $data['visit_date'];
        $item->id_number = $data['id_number'];
        $item->passport_id = $data['passport_id'];

        if($request->has("passport_image")){
            $picture = request()->file('passport_image');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded'), $imageName);
            $item->passport_image = 'images/uploaded/'.$imageName;
        }

        $item->hotel_id = $data['hotel_id'];
        $item->number_of_rooms = $data['number_of_rooms'];
        $item->room_type = $data['room_type'];
        $item->note = $data['note'];
        $item->check_in_date = $data['check_in_date'];
        $item->check_out_date = $data['check_out_date'];
        $item->save();
        $content = "New reservation is created.";
        Notification::create([
            'type' => 'new_reservation',
            'content' => $content,
            'reservation_id' => $item->id,
        ]);
        for ($i=0; $i < count($data['companion_name']); $i++) { 
            Companion::create([
                'reservation_id' => $item->id,
                'name' => $data['companion_name'][$i],
                'id_number' => $data['companion_id_number'][$i],
                'phone_number' => $data['companion_phone_number'][$i],
            ]);
        }

        return back()->with('success', 'Created Successfully');
        
    }

    public function edit($id){
        $reservation = Reservation::find($id);
        $companions = $reservation->companions;
        $hotels = Hotel::all();
        return view('reservation.detail', compact('reservation' ,'companions', 'hotels'));
    }

    public function update(Request $request){
        $request->validate([
            // 'name'=>'required',
        ]);
        $data = $request->all();
        $item = Reservation::find($request->get("id"));
        $item->visitor_name = $data['visitor_name'];
        $item->visitor_email = $data['visitor_email'];
        $item->visitor_phone_number = $data['visitor_phone_number'];
        $item->visit_date = $data['visit_date'];
        $item->id_number = $data['id_number'];
        $item->passport_id = $data['passport_id'];

        if($request->has("passport_image")){
            $picture = request()->file('passport_image');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded'), $imageName);
            $item->passport_image = 'images/uploaded/'.$imageName;
        }

        $item->hotel_id = $data['hotel_id'];
        $item->number_of_rooms = $data['number_of_rooms'];
        $item->room_type = $data['room_type'];
        $item->note = $data['note'];
        $item->check_in_date = $data['check_in_date'];
        $item->check_out_date = $data['check_out_date'];
        $item->save();

        // $companions = $item->companions()->pluck('id')->toArray();

        for ($i=0; $i < count($data['companion_name']); $i++) {
            if(isset($data['companion_id'][$i])){
                $companion = Companion::find($data['companion_id'][$i]);
                $companion->name = $data['companion_name'][$i];
                $companion->id_number = $data['companion_id_number'][$i];
                $companion->phone_number = $data['companion_phone_number'][$i];
                $companion->save();
            }else{
                Companion::create([
                    'reservation_id' => $item->id,
                    'name' => $data['companion_name'][$i],
                    'id_number' => $data['companion_id_number'][$i],
                    'phone_number' => $data['companion_phone_number'][$i],
                ]);
            }            
        }
        return back()->with('success', 'Updated Successfully');
    }

    public function reply(Request $request){
        $item = Reservation::find($request->get('id'));
        $user = Auth::user();
        $role = $user->role->slug;
        if($role == 'office_manager'){
            $item->om_id = $user->id;
            $item->om_status = $request->get('status');
            $item->om_date = date('Y-m-d H:i:s');
            $item->save();
            if($item->om_status == 2){
                $content = "Office Manager accepted a reservation.";
                Notification::create([
                    'type' => 'om_accept',
                    'content' => $content,
                    'reservation_id' => $item->id,
                ]);
            }
        }else if($role == 'general_manager'){
            $item->gm_id = $user->id;
            $item->gm_status = $request->get('status');
            $item->gm_date = date('Y-m-d H:i:s');
            $item->save();
            if($item->gm_status == 2){
                $content = "General Manager accepted a reservation.";
                Notification::create([
                    'type' => 'gm_accept',
                    'content' => $content,
                    'reservation_id' => $item->id,
                ]);
                // Mail::to($item->visitor_email)->send(new ReservationMail($item));
                if(isset($item->hotel->email)){
                    $url = route('hotel_verify', [$item->id, csrf_token()]); 
                    Mail::to($item->hotel->email)->send(new HotelMail($item, $url));
                }
            }
        }        
        return back()->with('success', 'Replied for the reservation.');
    }

    public function delete($id){
        $item = Reservation::find($id);
        $item->companions->delete();
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }

    public function test_email(){
        $item = Reservation::first();
        Mail::to("xian1017@outlook.com")->send(new ReservationMail($item));
    }
}
