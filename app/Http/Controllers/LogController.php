<?php

namespace LaravelTestTask\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Request;
use LaravelTestTask\Log;

class LogController extends Controller
{
    public function createLog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'from'      => 'required|date_format:d/m/Y G:i',
            'to'        => 'required|date_format:d/m/Y G:i|after:from'
        ]);

        if ($validator->fails()) {
           return Response::json(['error' => $validator->errors()->all()], 400);
        }

        $name = $request->get('name');
        $from = (\DateTime::createFromFormat('d/m/Y G:i', $request->get('from')))->getTimestamp();
        $to   = (\DateTime::createFromFormat('d/m/Y G:i', $request->get('to')))->getTimestamp();

        foreach ($this->getTodayLogs($request->get('name')) as $todayLog) {
            if($todayLog->from->getTimestamp() > $from && $todayLog->to->getTimestamp() < $from) {
                return Response::json(['error' => 'Room was busy that time'], 400);
            }
        }

        Log::create([
            'from' => $from,
            'to'   => $to,
            'name' => $name
        ]);

        return Response::make(null, 201);
    }

    public function getRoomOccupancy()
    {
        $roomOccupancy = [];
        $logs = $this->getTodayLogs();
        foreach ($logs->all() as $log) {
            if(!isset($roomOccupancy[$log->name])) {
                $roomOccupancy[$log->name] = 0;
            }
            $roomOccupancy[$log->name] += $log->to->getTimestamp() - $log->from->getTimestamp();
        }
        $response = [];
        foreach ($roomOccupancy as $name => $timeOccupied) {
            $response[] = ['name'=>$name, 'occupancy'=> number_format(($timeOccupied/(24*60*60))*100, 2)];
        }

        return Response::json($response);
    }


    private function getTodayLogs($name = null)
    {
        $condition = [
            ['from', '>=', new \DateTime('today midnight')],
            ['to',   '<', new \DateTime('tomorrow midnight')]
        ];

        if($name) {
            $condition[] = ['name', '=', $name];
        }

        return Log::where(
            $condition
        )->get();
    }
}