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
        if ($item->hotel_status == 1) {
            $sms_content = "Hi, ".$item->visitor_name."  Your reservation is accepted.";
            $msg = $this->utf8_to_unicode_codepoints($sms_content);
            $data = [
                'apiKey' => env('ALFA_KEY'),
                'numbers' => $item->visitor_phone_number,
                'sender' => "Mohammed",
                'applicationType' => '68',
                'msg' => $msg,
            ];

            $ch = curl_init('https://www.alfa-cell.com/api/msgSend.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($ch);
            curl_close($ch);
        }
        return back()->with('success', 'You have repied successfully');        
    }

    public function test_sms(){
        // $msg = '00570065006C0063006F006D006500200074006F00200061006C00660061002D00630065006C006C002E0063006F006D';
        // $source = mb_convert_encoding('test', 'unicode', 'UTF-8');
        // $source = unpack('C*', $source);
        $source = $this->utf8_to_unicode_codepoints("Welcome to alfa-cell");
        dd($source);
        $data = [
            'apiKey' => env('ALFA_KEY'),
            'numbers' => "8615641572188",
            'sender' => "ABC",
            'applicationType' => '68',
            'msg' => $msg,
        ];

        $ch = curl_init('https://www.alfa-cell.com/api/msgSend.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        curl_close($ch);        
        dump($response);
    }

    public function utf8_to_unicode_codepoints($text) {
        return ''.implode(unpack('H*', iconv("UTF-8", "UCS-2BE", $text)));
    }
}
