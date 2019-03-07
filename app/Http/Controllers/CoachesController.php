<?php
namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use App\Http\Models\Coach;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Libraries\Pagination;

class CoachesController extends Controller
{
    use \ImageHandler;

    private $restService = [
        'list' => 'admin/coach',
        'edit' => 'admin/coach/%s',
        'create' => 'admin/coach',
        'update' => 'admin/coach/%s',
        'delete' => 'admin/coach/%s'
    ];

    public $error;

    public function index(Request $request)
    {
        if (!Authorization::canAccess('coaches')) {
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
            return \View::make('coaches.list', compact('data', 'paginator'));
        }
        return \View::make('coaches.list', [
            'serverError' => $this->error
        ]);
    }

    public function create()
    {
        if (!Authorization::canAccess('coaches')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        return view('coaches.create');
    }

    public function edit(Request $request, $coachId)
    {
        if (!Authorization::canAccess('coaches')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $coach = [];
        try {
            $coach = $this->get(sprintf($this->restService['edit'], $coachId))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (is_null($this->error) && $coach) {
            return \View::make('coaches.edit', compact('coach','coachId'));
        } else {
            return \Redirect::back()->with([
                'serverError' => $this->error
            ]);
        }
    }

    public function store(Request $request)
    {
        if (!Authorization::canAccess('coaches')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|min:1,max:40',
            'lastName' => 'required|min:1,max:40',
            'email' => 'required|email',
            'phone' => 'numeric',
            'profilePic' => 'sometimes|image|max:1024'
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        
        try {
            $data = $request->all();
            if ($request->hasFile('profilePic')) {
                $tempFile = $request->file('profilePic')->move($request->file('profilePic')
                    ->getPath(), str_replace(' ', '_', $request->file('profilePic')
                    ->getFilename()) . '_' . time() . '_' . "." . $request->file('profilePic')
                    ->getClientOriginalExtension());
                $data['profilePic'] = fopen($tempFile, 'r');
            }
            $response = $this->post($this->restService['create'], $data)->response();
            if ($request->hasFile('profilePic'))
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
        return \Redirect::route('coaches.list')->with([
            'success' => \trans('messages.coach_created_successfully')
        ]);
    }

    public function update(Request $request, $coachId)
    {
        if (!Authorization::canAccess('coaches')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|min:1,max:40',
            'lastName' => 'required|min:1,max:40',
            'email' => 'required|email',
            'phone' => 'numeric',
            'profilePic' => 'sometimes|image|max:1024'
        ]);
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        try {
            $data = $request->all();
            if ($request->hasFile('profilePic')) {
                $tempFile = $request->file('profilePic')->move($request->file('profilePic')
                    ->getPath(), str_replace(' ', '_', $request->file('profilePic')
                    ->getFilename()) . '_' . time() . '_' . "." . $request->file('profilePic')
                    ->getClientOriginalExtension());
                $data['profilePic'] = fopen($tempFile, 'r');
            }
            $response = $this->post(sprintf($this->restService['update'], $coachId), $data)->response();
            if ($request->hasFile('profilePic'))
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
        return \Redirect::route('coaches.list')->with([
            'success' => \trans('messages.coach_updated_successfully')
        ]);
    }

    public function destroy($coachId)
    {
        if (!Authorization::canAccess('coaches')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $response = $this->delete(sprintf($this->restService['delete'], $coachId))->response();
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
        return \Redirect::route('coaches.list')->with([
            'success' => \trans('messages.coach_deleted_successfully')
        ]);
    }
}
