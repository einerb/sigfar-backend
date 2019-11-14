<?php

namespace App\Http\Controllers;

use Validator;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $schedule = Schedule::with('user')->get();

            $response = [
                'success' => true,
                'data' => $schedule,
                'message' => 'Successfully created schedule!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    public function indexByUser($id)
    {
        try {
            $schedule = Schedule::with('user')->where("user_id", $id)->get();

            $response = [
                'success' => true,
                'data' => $schedule,
                'message' => 'Successfully created schedule!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'description' => 'string',
            'date_start' => 'required',
            'date_end' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'user_id' => 'integer'
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        $schedule = new Schedule([
            'description'     => $request->description,
            'date_start'     => $request->date_start,
            'date_end'     => $request->date_end,
            'time_start'     => $request->time_start,
            'time_end'     => $request->time_end,
            'user_id' => $request->user_id
        ]);

        try {
            $user = User::find($request->user_id);

            if (!$user) return jsend_error('User not found!');

            $schedule->save();

            $response = [
                'success' => true,
                'data' => $schedule,
                'message' => 'Successfully created schedule!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $schedule = Schedule::with('user')->where('id', $id)->get();

            if (!$schedule) return jsend_error('Schedule not found!');

            $response = [
                'success' => true,
                'data' => $schedule,
                'message' => 'Successful schedule listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $schedule = Schedule::find($id);

            if (!$schedule) return jsend_error('Schedule not found!');

            $schedule->description   = $request->description;
            $schedule->date_start    = $request->date_start;
            $schedule->date_end    = $request->date_end;
            $schedule->time_start    = $request->time_start;
            $schedule->time_end    = $request->time_end;
            $schedule->save();

            $response = [
                'success' => true,
                'data' => $schedule,
                'message' => 'Successfully updated schedule!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { }
}
