<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19/06/2018
 * Time: 1:09 PM
 */

namespace Core\Base;


use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->model->all();
        }catch (\Exception $e) {
            return jsend_error('Error to list: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return $this->model->create($request->all());
        }catch (\Exception $e) {
            return jsend_error('Error when saving: '.$e->getMessage());
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
        try {
            return $this->model->find($id);
        }catch (\Exception $e) {
            return jsend_error('Error when returning record: '.$e->getMessage());
        }
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
        try {
            return $this->model->update($request->all(), $id);
        }catch (\Exception $e) {
            return jsend_error('Error updating record: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return $this->model->destroy($id);
        }catch (\Exception $e) {
            return jsend_error('Fail to deactivate registration: '.$e->getMessage());
        }
    }
}
