<?php

namespace App\Repositories;

use Exception;
use App\Interfaces\DBPreparableInterface;
use App\Models\MasterExtracurricular;
use App\Interfaces\MasterExtracurricularInterface ;
use Illuminate\Http\Response;


class MasterExtracurricularRepository implements MasterExtracurricularInterface, DBPreparableInterface {
    public function getAll(array $filterData)
    {
        $filter = $this->getFilterData($filterData);
        $query = MasterExtracurricular::get(); 
        // $query = MasterExtracurricular::orderBy($filter['orderBy'], $filter['order']);

        // if (!empty($filter['search'])) {
        //     $query->where(function ($query) use ($filter) {
        //         $searched = '%' . $filter['search'] . '%';
        //         $query->where('level', 'like', $searched)
        //         ->orWhere('title', 'like', $searched);
        //     });
        // }
        return $query;
    }

    public function getFilterData(array $filterData): array
    {
        $defaultArgs = [
            'perPage' => 10,
            'search' => '',
            'orderBy' => 'id',
            'order' => 'desc'
        ];

        return array_merge($defaultArgs, $filterData);
    }

    public function getById(int $id): ?MasterExtracurricular
    {
        $master_extracurricular = MasterExtracurricular::find($id);

        if (empty($master_extracurricular)) {
            throw new Exception("Master extracurricular does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $master_extracurricular;
    }

    public function create(array $data): ?MasterExtracurricular
    {
        $data = $this->prepareForDB($data);

        return MasterExtracurricular::create($data);
    }

    public function update(int $id, array $data): ?MasterExtracurricular
    {
        $master_extracurricular = $this->getById($id);

        $updated = $master_extracurricular->update($this->prepareForDB($data, $master_extracurricular));

        if ($updated) {
            $master_extracurricular = $this->getById($id);
        }

        return $master_extracurricular;
    }

    public function delete(int $id): ?MasterExtracurricular
    {
        $master_extracurricular = $this->getById($id);
        $deleted = $master_extracurricular->delete();

        if (!$deleted) {
            throw new Exception("Master extracurricular could not be deleted.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $master_extracurricular;
    }

    public function prepareForDB(array $data, ?MasterExtracurricular $master_extracurricular = null): array
    {
        return [
            'organization_id' => $data['organization_id'],
            'extracurricular_name' => $data['extracurricular_name'],

        ];
    }

    




}