<?php

namespace Core\Base;


abstract class BaseRepo implements BaseRepoInterface
{

    abstract public function getModel();

    public function find($id)
    {
        try {
            return jsend_success($this->getModel()->findOrFail($id));
        }catch (\Exception $e) {
            return jsend_error('Error when returning record: '.$e->getMessage());
        }
    }


    public function all($orderBy = false, string $order =  'DESC')
    {
        try {
            $query = $this->getModel();

            if($orderBy) {
                $query->orderBy($orderBy, $order);
            }

            return jsend_success($query->get());

        }catch (\Exception $e) {
            return jsend_error('Error to list: '.$e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return jsend_success($this->getModel()->create($data));
        }catch (\Exception $e) {
            return jsend_error('Error when saving: '.$e->getMessage());
        }
    }

    public function update($request, $id)
    {
        try {
            $query = $this->getModel()::findOrFail($id);
            $query->fill($request);
            if($query->save()){
                return $this->find($id);
            }
            return null;
        }catch (\Exception $e) {
            return jsend_error('Error updating record: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $query = $this->getModel()->findOrFail($id);
            $query->active = 0;
            return jsend_success($query->save());
//            $delete = $dato->delete();
        }catch (\Exception $e) {
            return jsend_error('Fail to deactivate registration: '.$e->getMessage());
        }
    }

    public function findByAttributes(array $attributes)
    {
        try {
            $query = $this->buildQueryByAttributes($attributes);
            return $query->first();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        try {
            $query = $this->buildQueryByAttributes($attributes, $orderBy, $sortOrder);
            return $query->get();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function findByMany(array $ids)
    {
        try {
            $query = $this->getModel()->query();
            return $query->whereIn("id", $ids)->get();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function clearCache()
    {
        return true;
    }


    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->getModel()->query();
        if (method_exists($this->getModel(), 'translations')) {
            $query = $query->with('translations');
        }
        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }
        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }
        return $query;
    }

}
