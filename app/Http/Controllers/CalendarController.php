<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class CalendarController extends Controller
{

    public function index(){
        $appointments = Appointment::with('users')
                                ->orderBy('meeting_date', 'asc')
                                ->paginate(10);
        return Inertia::render('Help/Calendar/Appointment/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getappointments' => $appointments
        ]);
    }

    public function calendar(){
        $appointments = Appointment::where('meeting_date', '>=', Carbon::now('UTC'))->with('users')->with('calendar')
                                 ->orderBy('meeting_date', 'asc')
                                 ->get();


                                 //dd($appointments);
        $excludedRoleName = ['dev', 'admin', 'client'];
        $users=User::with('roles')
            ->whereDoesntHave('roles', function ($query) use ($excludedRoleName) {
                $query->whereIn('name', $excludedRoleName);
            })->with('calendar')->with('calendar.appointments')->get();
        return Inertia::render('Home/Client/Appointment2', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getappointments' => $appointments,
            'getusers' => $users
        ]);
    }

    public function store(Request $request){
        //dd($request);
        $appointment = new Appointment($request->only(['meeting_date', 'duration_time', 'duration_unit', 'comment', 'type', 'status', 'calendar_id']));
        $appointment->save();
        //dd($appointment);
        //$post->post_id = $request->post_id['id'];
        //Auth::user()->appointments()->save($appointment);
        $appointment->users()->attach($request->requestor, ['type' => 'requestor']);
        $appointment->users()->attach($request->trainer, ['type' => 'trainer']);
        $appointment->save();

        return redirect()->back()->with('status', 'Rendez-vous créé avec succès ! Vous serez notifié lorsque qu\'il aura été validé par l\'intervenant');
    }

    public function update(Request $request, Appointment $appointment){
        //dd($appointment);
        $appointment->fill($request->only(['meeting_date', 'duration_time', 'duration_unit', 'comment', 'type', 'status']));
        $appointment->save();
        if ($appointment->status == 'accepted') {
            return redirect()->back()->with('status', 'Le RDV a bien été accepté ! Votre client sera notifié.');
        }
        elseif ($appointment->status == 'declined') {
            return redirect()->back()->with('status', 'Le RDV a bien été refusé ! Votre client sera notifié.');
        }
        else {
            return redirect()->back()->with('status', 'Le RDV a bien été mis à jour.');
        }
    }

    public function updateCalendar(Request $request, Calendar $calendar){
        //dd($appointment);
        $calendar->fill($request->only([
            'availability_type', 'beginning_hour', 'created_at', 'description', 'ending_hour', 'friday', 'is_off', 'return_date', 'saturday', 'slot_duration_time',
            'slot_duration_unit', 'sunday', 'thursday', 'tuesday', 'updated_at', 'user_id', 'wednesday', 'monday'
        ]));
        $calendar->save();
        return redirect()->back()->with('status', 'Le calendrier a bien été modifié.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageSection  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //dd($appointment);
        $appointment->delete();
        return redirect()->back()->with('status', 'Le rendez-vous a bien été supprimé.');
    }
}
