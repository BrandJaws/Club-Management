<?php
namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Libraries\Pagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TrainingsController extends Controller
{
    use \ImageHandler;

    private $restService = [
        'list' => 'admin/training',
        'edit' => 'admin/training/%s',
        'create' => 'admin/training',
        'update' => 'admin/training/%s',
        'delete' => 'admin/training/%s',
        'coaches' => 'admin/coach/list',
        'listCourt' => 'admin/court',
        'listParticipants' => 'admin/training/participants/%s',
        'reserve' => 'admin/training/reserve',
        'cancel-reservation' => 'admin/training/cancel-reservation',
        'clone-training' => 'admin/training/%s/clone'
    ];

    public $error;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = [];
        $page = ($request->has('page')) ? $request->get('page') : 1;
        try {
            $data = $this->get($this->restService['list'], [
                'page' => $page
            ])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (is_null($this->error) && $data) {
            $paginator = (new Pagination())->total($data['total'])
                ->per_page(10)
                ->page_name('page')
                ->ul_class('pagination');
            return \View::make('trainings.list', compact('data', 'paginator'));
        }
        return \View::make('trainings.list', [
            'serverError' => $this->error
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = $coaches = $courts = [];
        try {
            $courts = $this->get($this->restService['listCourt'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        try {
            $coaches = $this->get($this->restService['coaches'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if ($request->old()) {
            $data = $request->old();
        }
        return view('trainings.create-new', compact('data', 'coaches', 'courts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1,max:99',
            'description' => 'required|min:1,max:250',
            'instructor' => 'required|numeric',
            'numberOfSlots' => 'required|numeric|max:3',
            'promotionImage' => 'required_if:promotionType,IMAGE|image|mimes:jpeg,bmp,png,jpg|max:1024',
            'videoUrl' => 'required_if:promotionType,VIDEO|active_url',
            'registrationStartAt' => 'required|date_format:Y-m-d H:i',
            'registrationCloseAt' => 'required|date_format:Y-m-d H:i|after:registrationStartAt',
            'trainingStart' => 'required|date_format:Y-m-d H:i|after:registrationCloseAt',
            'numberOfSessions' => 'required|numeric',
            'price' => 'required|numeric',
            'minRegistrations' => 'required|numeric',
            'maxRegistrations' => 'required|numeric',
            'court' => 'required|array'
        ]);
        // $validator->after(function ($validator) use($request) {
        // if(!is_array($request->get('court')) || count($request->get('court')) < 1){
        // $validator->errors()->add('court', 'Please select atleast one court from the list');
        // }
        // });
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        
        try {
            $data = $request->all();
            if (isset($data['instructor'])) {
                $data['coach_id'] = $data['instructor'];
                unset($data['instructor']);
            }
            // if (isset($data['court'])) {
            // $data['court_id'] = $data['court'];
            // unset($data['court']);
            // }
            if ($request->has('playerAbilityRestriction')) {
                $playerAbility = explode(';', $request->get('playerAbility'));
                if (count($playerAbility) == 2) {
                    $data['minLevel'] = $playerAbility[0];
                    $data['maxLevel'] = $playerAbility[1];
                    unset($data['playerAbility']);
                }
            }
            if ($request->has('ageRestriction')) {
                $playerAge = explode(';', $request->get('age'));
                if (count($playerAge) == 2) {
                    $data['ageFrom'] = $playerAge[0];
                    $data['ageTo'] = $playerAge[1];
                    unset($data['age']);
                }
            }
            if ($request->hasFile('promotionImage')) {
                $tempFile = $request->file('promotionImage')->move($request->file('promotionImage')
                    ->getPath(), str_replace(' ', '_', $request->file('promotionImage')
                    ->getFilename()) . '_' . time() . '_' . "." . $request->file('promotionImage')
                    ->getClientOriginalExtension());
                $data['promotionImage'] = fopen($tempFile, 'r');
            }
            
            $response = $this->post($this->restService['create'], $data)->response();
            if ($request->hasFile('promotionImage'))
                \Illuminate\Support\Facades\File::delete($tempFile);
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if ($this->error != '') {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
        return \Redirect::route('trainings.list')->with([
            'success' => \trans('messages.training_created_successfully')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $trainingId)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = $coaches = $courts = [];
        try {
            $courts = $this->get($this->restService['listCourt'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        try {
            $coaches = $this->get($this->restService['coaches'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {} catch (\Exception $exp) {}
        try {
            $data = $this->get(sprintf($this->restService['edit'], $trainingId))->response();
            if (array_get($data, 'promotionType', false) == config('global.contentType.video')) {
                $data['videoUrl'] = array_get($data, 'promotionContent', false);
            }
            
            if (array_get($data, 'training_courts', false)) {
                foreach (array_get($data, 'training_courts', []) as $key => $courtRelation) {
                    $data['slectedCourts'][] = array_get($courtRelation, 'court_id');
                }
            }
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $coaches) {
            if (isset($data['coach_id'])) {
                $data['instructor'] = $data['coach_id'];
                unset($data['coach_id']);
            }
            if ($request->old()) {
                $data = array_replace($data, $request->old());
                if (! $request->old('playerAbilityRestriction')) {
                    unset($data['playerAbilityRestriction']);
                }
                if (! $request->old('disablePlayerCancellation')) {
                    unset($data['disablePlayerCancellation']);
                }
                if (! $request->old('applyCancellationPolicy')) {
                    unset($data['applyCancellationPolicy']);
                }
                if (! $request->old('ageRestriction')) {
                    unset($data['ageRestriction']);
                }
            }
            return \View::make('trainings.create-new', compact('data', 'trainingId', 'coaches', 'courts'));
        } else {
            return \Redirect::back()->with([
                'serverError' => $this->error
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1,max:99',
            'description' => 'required|min:1,max:250',
            'instructor' => 'required|numeric',
            'numberOfSlots' => 'required|numeric|max:3',
            'registrationStartAt' => 'required|date_format:Y-m-d H:i',
            'registrationCloseAt' => 'required|date_format:Y-m-d H:i|after:registrationStartAt',
            'trainingStart' => 'required|date_format:Y-m-d H:i|after:registrationCloseAt',
            'numberOfSessions' => 'required|numeric',
            'price' => 'required|numeric',
            'minRegistrations' => 'required|numeric',
            'maxRegistrations' => 'required|numeric',
            'court' => 'required|array'
        ]);
        // $validator->after(function ($validator) use($request){
        // if(!is_array($request->get('court')) || count($request->get('court')) < 1){
        // $validator->errors()->add('court', 'Please select atleast one court from the list');
        // }
        // });
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        try {
            $data = $request->all();
            if (isset($data['instructor'])) {
                $data['coach_id'] = $data['instructor'];
                unset($data['instructor']);
            }
            // if (isset($data['court'])) {
            // $data['court_id'] = $data['court'];
            // unset($data['court']);
            // }
            if ($request->has('playerAbilityRestriction')) {
                $playerAbility = explode(';', $request->get('playerAbility'));
                if (count($playerAbility) == 2) {
                    $data['minLevel'] = $playerAbility[0];
                    $data['maxLevel'] = $playerAbility[1];
                    unset($data['playerAbility']);
                }
            }
            if ($request->has('ageRestriction')) {
                $playerAge = explode(';', $request->get('age'));
                if (count($playerAge) == 2) {
                    $data['ageFrom'] = $playerAge[0];
                    $data['ageTo'] = $playerAge[1];
                    unset($data['age']);
                }
            }
            if ($request->hasFile('promotionImage')) {
                $tempFile = $request->file('promotionImage')->move($request->file('promotionImage')
                    ->getPath(), str_replace(' ', '_', $request->file('promotionImage')
                    ->getFilename()) . '_' . time() . '_' . "." . $request->file('promotionImage')
                    ->getClientOriginalExtension());
                $data['promotionImage'] = fopen($tempFile, 'r');
            }
            
            $response = $this->post(sprintf($this->restService['update'], $id), $data)->response();
            if ($request->hasFile('promotionImage'))
                \Illuminate\Support\Facades\File::delete($tempFile);
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if ($this->error != '') {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
        return \Redirect::route('trainings.list')->with([
            'success' => \trans('messages.training_update_successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $response = $this->delete(sprintf($this->restService['delete'], $id))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            
            $this->error = \trans('messages.general_error');
        }
        
        if ($this->error != '') {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
        return \Redirect::route('trainings.list')->with([
            'success' => \trans('messages.training_deleted_successfully')
        ]);
    }

    public function show($trainingId)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get(sprintf($this->restService['listParticipants'], $trainingId))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        return \View::make('trainings.participants', compact('data', 'trainingId'));
        // }
        /*
         * return \Redirect::route('trainings.list')->with([
         * 'serverError' => $this->error
         * ]);
         */
    }

    public function bookTraining(Request $request)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->post($this->restService['reserve'], $request->all())
                ->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (isset($data) && is_null($this->error)) {
            return \Redirect::back()->withInput()->with([
                'success' => \trans('messages.training_reservation_successfully')
            ]);
        } else {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
    }

    public function removeReservation($reservation_player_id)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->post($this->restService['cancel-reservation'], [
                'reservation_player_id' => $reservation_player_id
            ])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (isset($data) && is_null($this->error)) {
            return \Redirect::back()->withInput()->with([
                'success' => \trans('messages.training_reservation_cancel_successfully')
            ]);
        } else {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
    }

    public function cloneTraining($trainingId)
    {
        if (!Authorization::canAccess('trainings')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->post(sprintf($this->restService['clone-training'], $trainingId), [])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (isset($data) && is_null($this->error)) {
            return \Redirect::back()->withInput()->with([
                'success' => \trans('messages.training_cloned_successfully')
            ]);
        } else {
            return \Redirect::back()->withInput()->with([
                'serverError' => $this->error
            ]);
        }
    }
}
