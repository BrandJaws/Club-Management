<?php
namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Http\Libraries\Pagination;

class MemberController extends Controller
{

    private $restService = [
        'listMember' => 'admin/member',
        'createMember' => 'admin/member',
        'editMember' => 'admin/member/%s/details',
        'updateMember' => 'admin/member/%s',
        'deleteMember' => 'admin/member/%s',
        'searchAndListMembers' => 'admin/member/list',
        'importMembers' => 'admin/member/import',
        'listMembersForWaitingApproval' => 'admin/member/waiting/approval',
        'listRejectedMembers' => 'admin/member/rejected',
        'approveAffiliateMember' => 'admin/member/approve/affiliate/%s',
        'rejectAffiliateMember' => 'admin/member/reject/affiliate/%s'
    ];

    public $error;

    public function index(Request $request)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = [];
        $page = ($request->has('page')) ? $request->get('page') : 1;
        $search = ($request->has('search')) ? trim($request->get('search')) : "";
        try {
            $data = $this->get($this->restService['listMember'], [
                'page' => $page,
                'search' => $search
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
                ->per_page(80)
                ->page_name('page')
                ->ul_class('pagination');
            return \View::make('member.list', compact('data', 'paginator'));
        }
        return \View::make('member.list', [
            'serverError' => $this->error
        ]);
    }

    public function create()
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        return \View::make('member.create', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|min:1,max:40',
            'lastName' => 'required|min:1,max:40',
            'email' => 'required|email',
            // 'phone' => 'required', 
            'password' => 'required',
            'gender' => 'required|in:FEMALE,MALE',
            //'dob' => 'required'
        ]);
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        try {
            $data = $request->all();
            if ($request->has('relation') && $request->get('relation') == 'affiliate') {
                $data['main_member_id'] = $request->get('parentMember');
                $data['type'] = $request->get('type');
                unset($data['relation']);
                unset($data['parentMember']);
            }
            $response = $this->post($this->restService['createMember'], $data)->response();
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
        return \Redirect::to('\member')->with([
            'success' => \trans('messages.member_create_success')
        ]);
    }

    public function edit($memberId)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get(sprintf($this->restService['editMember'], $memberId))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data)
            return \View::make('member.edit', compact('data'));
        return \Redirect::back()->with([
            'serverError' => $this->error
        ]);
    }

    /**
     *
     * @param Request $request
     * @param int $memberId
     *            return redirect
     */
    public function update(Request $request, $memberId)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|min:1,max:40',
            'lastName' => 'required|min:1,max:40',
            'email' => 'required|email',
            //'phone' => 'required',
            // 'password' => 'required',
            'gender' => 'required|in:FEMALE,MALE',
            //'dob' => 'required'
        ]);
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withErrors($this->error);
        }
        
        try {
            $data = $request->all();
            if ($request->has('relation') && $request->get('relation') == 'affiliate') {
                $data['main_member_id'] = $request->get('parentMember');
                $data['type'] = $request->get('type');
                unset($data['relation']);
                unset($data['parentMember']);
            }
            
            $response = $this->put(sprintf($this->restService['updateMember'], $memberId), $data)->response();
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
        return \Redirect::to('member')->with([
            'success' => \trans('messages.member_update_success')
        ]);
    }

    /**
     *
     * @param int $memberId
     *            return redirect
     */
    public function destroy($memberId)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $response = $this->delete(sprintf($this->restService['deleteMember'], $memberId))->response();
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
        return \Redirect::to('member')->with([
            'success' => \trans('messages.member_update_success')
        ]);
    }

    public function searchAndListMembers(Request $request)
    {
        $search = $request->has('search') ? $request->get('search') : '';
        
        try {
            $data = $this->get(sprintf($this->restService['searchAndListMembers'] . "?search=" . $search))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (isset($data)) {
            return \Response::json($data);
        }
    }

    public function importMembers(Request $request)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'csv_import' => 'required|mimes:csv,txt|max:1024'
        ]);
        
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withInput()->withErrors($this->error);
        }
        try {
            if ($request->hasFile('csv_import')) {
                $tempFile = $request->file('csv_import')->move($request->file('csv_import')
                    ->getPath(), str_replace(' ', '_', $request->file('csv_import')
                    ->getFilename()) . '_' . time() . '_' . "." . $request->file('csv_import')
                    ->getClientOriginalExtension());
                $data['csv_import'] = fopen($tempFile, 'r');
            }
            
            $response = $this->post($this->restService['importMembers'], $data)->response();
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
        return \Redirect::to('member')->with([
            'success' => \trans('messages.member_import_operations_success')
        ]);
    }

    public function pendingApproval(Request $request)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = [];
        try {
            $data = $this->get($this->restService['listMembersForWaitingApproval'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data) {
            return \View::make('member.pending', compact('data'));
        }
        return \View::make('member.pending', [
            'serverError' => $this->error
        ]);
    }

    public function rejected(Request $request)
    {
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        $data = [];
        try {
            $data = $this->get($this->restService['listRejectedMembers'])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }

        if (is_null($this->error) && $data) {
            return \View::make('member.rejected', compact('data'));
        }
        return \View::make('member.rejected', [
          'serverError' => $this->error
        ]);
    }

    public function approveAffiliateMember($affiliateId){
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get(sprintf($this->restService['approveAffiliateMember'], $affiliateId))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data) {
            return \Redirect::back()->with(['success'=>\trans('messages.affiliate_member_approved')]);
        }
        return \View::make('member.pending', [
            'serverError' => $this->error
        ]);
    }
    public function rejectAffiliateMember($affiliateId){
        if (!Authorization::canAccess('members')) {
            return Redirect::route('dashboard')->with([
              'error' => \trans('message.unauthorized_access')
            ]);
        }

        try {
            $data = $this->get(sprintf($this->restService['rejectAffiliateMember'], $affiliateId))->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        
        if (is_null($this->error) && $data) {
            return \Redirect::back()->with(['success'=>\trans('messages.affiliate_member_rejected')]);
        }
        return \View::make('member.pending', [
            'serverError' => $this->error
        ]);
    }
}
