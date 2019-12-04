<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Vehicle;
use App\Violation;

class ClerkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:clerk');
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pending = DB::table('vehicles')
                        ->where('registered', '=', 'pending')
                        ->get();

        return view('clerk')->with('pending', $pending);
    }

    public function addViolation(Request $request) {
        $rules = [
            'vehicle' => 'required',
            'date' => 'required',
            'place' => 'required',
        ];
    
        $customMessages = [
            'required' => 'Všetky polia musia byť vyplnené.'
        ];

        $this->validate($request, $rules, $customMessages);


        $vehicle_plate = $request->input('vehicle');
        $vehicle = DB::table('vehicles')
                                    ->where('plate', '=', $vehicle_plate)
                                    ->get();
        
        if ( count($vehicle) == 0 ) {
            return redirect()->back()->with('failure', 'Vozidlo nenájdené.');
        }
        
        $vehicle = $vehicle[0];
        

        $violation = new Violation;
        $violation->happened_on = $request->input('date');
        $violation->happened_at = $request->input('place');
        $violation->vehicle_id = $vehicle->id;
        $violation->user_id = $vehicle->user_id;
        $violation->save();

        $pending = DB::table('vehicles')
                        ->where('registered', '=', 'pending')
                        ->get();

        return redirect()->back()
                        ->with('success', 'Priestupok priradený.')
                        ->with('pending', $pending);
    }
}
