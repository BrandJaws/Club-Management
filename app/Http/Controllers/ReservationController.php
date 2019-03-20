<?php
namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;

class ReservationController extends Controller
{

    private $restService = [
        'court' => 'admin/court/reservations',
        'reservation' => 'admin/court/reserve',
        'updateReservation' => 'admin/court/update-reservation',
        'deleteReservation' => 'admin/court/reservations/delete/'
    ];

    private $error;

    public function index()
    {

        if (!Authorization::canAccess('reservations')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get($this->restService['court'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data) {
            return \View::make('reservation.reservation', compact('data'));
        } else {
            return \Redirect::to('dashboard')->with([
                'serverError' => $this->error
            ]);
        }
    }

    public function getReservationsByDate(Request $request, $date)
    {
        if (!Authorization::canAccess('reservations')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get($this->restService['court'] . "/" . $date)->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data) {
            
            return $data;
        } else {
            return $this->error;
        }
    }

    public function store(Request $request)
    {
        if (!Authorization::canAccess('reservations')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'club_id' => 'required',
            'court_id' => 'required',
            'time' => 'required',
            'reserved_at' => 'required',
        ]);
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return $this->error;
        }
        
        try {
            $response = $this->post($this->restService['reservation'], $request->all())
                ->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = $exp;
        }
        
        if ($this->error != '') {
            return $this->error;
        } else {
            return $response;
        }
    }

    public function update(Request $request)
    {
        if (!Authorization::canAccess('reservations')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'tennis_reservation_id' => 'required',
            'player' => 'required',
            'parent_id' => 'required'
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return $this->error;
        }
        
        try {
            $response = $this->post($this->restService['updateReservation'], $request->all())
                ->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if ($this->error != '') {
            return $this->error;
        } else {
            return $response;
        }
    }

    /**
     * Called from Ajax
     * 
     * @param int $tennis_reservation_id            
     * @return string
     */
    public function destroy($tennis_reservation_id)
    {
        if (!Authorization::canAccess('reservations')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }
        
        if (! isset($tennis_reservation_id) || (int) $tennis_reservation_id === 0) {
            $this->error = "Tennis Reservation Id is required";
            return $this->error;
        }
        
        try {
            $response = $this->get($this->restService['deleteReservation'] . $tennis_reservation_id)->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if ($this->error != '') {
            return $this->error;
        } else {
            return $response;
        }
    }
}
