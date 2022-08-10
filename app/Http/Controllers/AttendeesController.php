<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SaveAttendeeRequest;
use App\Models\Attendee;
use App\Mail\MessageReceived;
use App\Providers\MessageWasReceived;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AttendeesController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if ($request->ajax()) {
            // dd($request->all());

            $attendees = Attendee::select('id as _Attendee','name as Name', 'email as Email','attendees as Attendee','created_at as Created')
            ->orderBy('Created','desc')
            ->get();

            $total = Attendee::select('attendees')
            ->sum('attendees');

            foreach ($attendees as $key => $attendee) {
                $attendee->_Attendee = Crypt::encrypt($attendee->_Attendee);
            }
            
            return response()->json([
                'msg' => 'success',
                'attendees' => $attendees,
                'total' => $total,
            ]);

        } else {
            return view('main.asistencia_list');
        }
    }
    
    public function store(Request $request){
        if ($request->ajax()) {
            

            $validEmail = Attendee::where([ ['email',$request->email] ])->count();
            // dd($validEmail);
            if ($validEmail > 0) {
                return response()->json(["msg"=>"error",'email'=>'Este correo ya está registrado']);
            } 

            // $attendee = (new Attendee)->fill($request->all());
            $attendee = (new Attendee)->fill([
                'name'=>$request->name,
                'email'=>$request->email,
                'attendees'=>$request->attendee,
            ]);

            $attendee->save();

            $attendee;
            // dd($message);
            Mail::to($attendee->email)->send(new MessageReceived($attendee));
            Mail::to('admin@pepeyvalentina.com')->send(new MessageReceived($attendee));
            // event(new MessageWasReceived($message));

            return response()->json(["msg"=>"success",'id'=>$attendee->id]);
            
        } else {
            abort(404);
        }
        
    }

}
