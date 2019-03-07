<?php
namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Libraries\Pagination;
use Illuminate\Support\Facades\Redirect;


class PrivateLessonsController extends Controller
{
    use \ImageHandler;

    private $restService = [
      'list' => 'admin/private-lessons'
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
                'current_page' => $page
            ])->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {
            $this->error = \trans('messages.general_error');
        }
        if (is_null($this->error) && $data) {

            foreach($data["data"] as $index=>$lesson){
                $affilates = [];
                foreach($lesson["reservation_players"] as $reservationPlayer ){
                    if($reservationPlayer["member_id"] != $lesson["member_id"] ){
                        $affilates[] = $reservationPlayer["member"]["firstName"].' '.$reservationPlayer["member"]["lastName"];
                    }
                }
                $data["data"][$index]["affiliateNames"] = count($affilates) ? implode(', ',$affilates) : '-';
                $data["data"][$index]["dayNames"] = implode(', ',$data["data"][$index]["days"]);
            }
           
            $paginator = (new Pagination())->total($data['total'])
                ->per_page(20)
                ->page_name('page')
                ->ul_class('pagination');
            return \View::make('private_lessons.list', compact('data', 'paginator'));
        }
        return \View::make('private_lessons.list', [
            'serverError' => $this->error
        ]);
    }


}
