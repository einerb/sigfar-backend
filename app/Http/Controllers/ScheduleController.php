<?php

namespace App\Http\Controllers;

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
            $schedule = Schedule::all();

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
        try {
            $request->validate([
                'description' => 'string',
                'date_start' => 'required',
                'time_start' => 'required',
                'time_end' => 'required',
                'user_id' => 'integer'
            ]);
            $schedule = new Schedule([
                'description'     => $request->description,
                'date_start'     => $request->date_start,
                'time_start'     => $request->time_start,
                'time_end'     => $request->time_end,
                'user_id' => $request->user_id
            ]);

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
            $schedule = Schedule::find($id);

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
    {
        
    }
}
