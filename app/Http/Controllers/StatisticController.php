<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Statistic;
use App\Models\StatisticType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['types'] = StatisticType::all();
        $data['reports'] = self::getReports();
        $data['statistics'] = self::getStatistics();

        return view('statistics.list', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll()
    {
        $data['types'] = StatisticType::all();
        $data['animals'] = Animal::all();
        $data['reports'] = self::getReports(true);
        $data['statistics'] = self::getStatistics(true);

        return view('statistics/admin.list', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReports($admin = false)
    {
        $data['types'] = StatisticType::all();

        if (!$admin) {
            $data['data'] = Statistic::where('user_id', Auth::id())
                ->get();
        } else {
            $data['data'] = Statistic::select('animal_id', 'type_id', 'report_date', DB::raw('SUM(amount) as amount'))
                ->where(function ($query) {
                    if($fromDate = request('from_date')) {
                        $query->where('report_date', '>=', $fromDate);
                    }
                })
                ->where(function ($query) {
                    if($toDate = request('to_date')) {
                        $query->where('report_date', '<=', $toDate);
                    }
                })
                ->where(function ($query) {
                    if($animalId = request('animal')) {
                        $query->where('animal_id', $animalId);
                    }
                })
                ->groupBy('animal_id', 'type_id', 'report_date')
                ->get();
        }


        $animal = null;
        $report_date = null;
        $index = 0;
        if(count($data['data']) != 0) {
            foreach ($data['data'] as $report) {
                if ($animal != $report->animal->title || $report_date != $report['report_date']) {
                    $index++;
                    $animal = $report->animal->title;
                    $data['reports'][$index]['animal'] = $animal;
                    $report_date = $report['report_date'];
                    $data['reports'][$index]['report_date'] = $report_date;
                }
                $data['reports'][$index][$report->type->title] = $report['amount'];
            }
            return $data['reports'];
        }
        return $data['data'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatistics($admin = false)
    {
        $data['types'] = StatisticType::all();

        if (!$admin) {
            $data['statistics'] = Statistic::select('animal_id', 'type_id', DB::raw('SUM(amount) as sum'))
                ->where('user_id', Auth::id())
                ->groupBy('animal_id', 'type_id')
                ->get();
        } else {
            $data['statistics'] = Statistic::select('animal_id', 'type_id', DB::raw('SUM(amount) as sum'))
                ->where(function ($query) {
                    if($fromDate = request('from_date')) {
                        $query->where('report_date', '>=', $fromDate);
                    }
                })
                ->where(function ($query) {
                    if($toDate = request('to_date')) {
                        $query->where('report_date', '<=', $toDate);
                    }
                })
                ->where(function ($query) {
                    if($animal = request('animal')) {
                        $query->where('animal_id', $animal);
                    }
                })
                ->groupBy('animal_id', 'type_id')
                ->get();
        }

        return $data['statistics'];
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['animals'] = Animal::all();
        $data['types'] = StatisticType::all();
        return view('statistics.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeCount = StatisticType::count();

        for($i = 1; $i <= $typeCount; $i++) {
            $statistic = new Statistic();
            $statistic->report_date = $request->post('report_date');
            $statistic->user_id = Auth::id();
            $statistic->type_id = $i;
            $statistic->amount = $request->post('amount' . $i);
            $statistic->animal_id = $request->post('animalId');

            $statistic->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
