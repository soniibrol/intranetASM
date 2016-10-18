<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ActionPlan;
use App\EventPlan;
use App\Creative;
use DB;

use App\Announcement;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user()->roles);
        $data = array();
        $today = date('Y-m-d');

        $data['announcements'] = Announcement::where(function($query) use($today) {
                                                    $query->where('announcement_startdate', '>=', $today)
                                                            ->where('announcement_enddate', '<=', $today);
                                                })->orWhere(function($query) use($today) {
                                                    $query->where('announcement_startdate', '<=', $today)
                                                            ->where('announcement_enddate', '>=', $today);
                                                })->where('active', '=', '1')->get();

        /*dd($data);*/
        $data['eventplan'] = EventPlan::where('active', '1')->where('flow_no', '98')->where(DB::raw('datediff("'.date('Y-m-d').'", event_plan_deadline)'), '>', 30)->get();

        return view('home', $data);
    }

    public function apiPlan()
    {
        $data = array();
        $data['monthly'] = array();

        $actionplan = ActionPlan::where('active', '1')->where('flow_no', '98')->get();
        foreach ($actionplan as $key => $value) {
            $ap = array();
            $ap['id'] = $value->action_plan_id;
            $ap['name'] = $value->action_plan_title;
            $ap['startdate'] = $value->action_plan_startdate;
            $ap['enddate'] = $value->action_plan_enddate;
            $ap['starttime'] = '0:00';
            $ap['endtime'] = '23:59';
            $ap['color'] = '#FFB128';
            $ap['url'] = '#';
            array_push($data['monthly'], $ap);
        }

        $eventplan = EventPlan::where('active', '1')->where('flow_no', '98')->get();
        foreach ($eventplan as $key => $value) {
            $ep = array();
            $ep['id'] = $value->event_plan_id;
            $ep['name'] = $value->event_plan_name;
            $ep['startdate'] = $value->event_plan_deadline;
            $ep['enddate'] = '';
            $ep['starttime'] = '0:00';
            $ep['endtime'] = '23:59';
            $ep['color'] = '#4286f4';
            $ep['url'] = '#';
            array_push($data['monthly'], $ep);
        }

        return response()->json($data);
    }

    public function apiUpcomingPlan($mode, $day)
    {
        if($mode=='below')
        {
            $sym = '>';
        }else{
            $sym = '<';
        }

        $curdate = date('Y-m-d');

        $data = array();
        $data['monthly'] = array();

        $actionplan = ActionPlan::select('action_plans.*',DB::raw('ABS(datediff("'.$curdate.'", action_plan_startdate)) AS timeto'))->where('active', '1')->where('flow_no', '98')->where(DB::raw('datediff("'.$curdate.'", action_plan_startdate)'), $sym, $day)->where(DB::raw('datediff("'.$curdate.'", action_plan_startdate)'), '<', 0)->orderBy('action_plan_startdate', 'asc')->take(5)->get();
        foreach ($actionplan as $key => $value) {
            $ap = array();
            $ap['id'] = $value->action_plan_id;
            $ap['name'] = $value->action_plan_title;
            $ap['startdate'] = $value->action_plan_startdate;
            $ap['enddate'] = $value->action_plan_enddate;
            $ap['starttime'] = '0:00';
            $ap['endtime'] = '23:59';
            $ap['color'] = '#FFB128';
            $ap['url'] = '#';
            $ap['timeto'] = $value->timeto;
            array_push($data['monthly'], $ap);
        }

        $eventplan = EventPlan::select('event_plans.*',DB::raw('ABS(datediff("'.$curdate.'", event_plan_deadline)) AS timeto'))->where('active', '1')->where('flow_no', '98')->where(DB::raw('datediff("'.$curdate.'", event_plan_deadline)'), $sym, $day)->where(DB::raw('datediff("'.$curdate.'", event_plan_deadline)'), '<', 0)->orderBy('event_plan_deadline', 'asc')->take(5)->get();
        foreach ($eventplan as $key => $value) {
            $ep = array();
            $ep['id'] = $value->event_plan_id;
            $ep['name'] = $value->event_plan_name;
            $ep['startdate'] = $value->event_plan_deadline;
            $ep['enddate'] = '';
            $ep['starttime'] = '0:00';
            $ep['endtime'] = '23:59';
            $ep['color'] = '#4286f4';
            $ep['url'] = '#';
            $ep['timeto'] = $value->timeto;
            array_push($data['monthly'], $ep);
        }

        return response()->json($data);
    }
}
