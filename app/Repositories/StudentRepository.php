<?php

namespace App\Repositories;

use Exception;
use App\Interfaces\DBPreparableInterface;
use App\Interfaces\StudentInterface;
use App\Models\StudentDetail;
use App\Models\StudentDocument;
use App\Models\StudentParent;
use App\Models\StudentSibling;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class StudentRepository implements StudentInterface, DBPreparableInterface {
    public function getAll(array $filterData)
    {
        $filter = $this->getFilterData($filterData);

       $query = StudentDetail::join('student_parents', 'student_details.student_id', '=', 'student_parents.student_id')
            ->join('student_siblings', 'student_details.student_id', '=', 'student_siblings.student_id')
            ->join('student_documents', 'student_details.student_id', '=', 'student_documents.student_id')
            ->select(
                'student_details.*',
                'student_parents.*',
                'student_siblings.*',
                'student_documents.*'
            )
        ->get();

        // if (!empty($filter['search'])) {
        //     $query->where(function ($query) use ($filter) {
        //         $searched = '%' . $filter['search'] . '%';
        //         $query->where('student', 'like', $searched);
        //     });
        // }

        return $query;

        
        //return  $permissions = StudentDetail::get();
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

    public function getById(int $id): ?StudentDetail
    {
        $student = StudentDetail::find($id);

        if (empty($student)) {
            throw new Exception("User student does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $student;
    }

    public function create(array $data): ?object 
{
    $studentDetail = StudentDetail::create($data);
    $studentParent = StudentParent::create($data);
    $studentSibling = StudentSibling::create($data);
    $studentDocument = StudentDocument::create($data);

    // Check if any of the models is null
    if ($studentDetail === null || $studentParent === null || $studentSibling === null || $studentDocument === null) {
        return null;
    }

    $collection = collect([
        'studentDetail' => $studentDetail,
        'studentParent' => $studentParent,
        'studentSibling' => $studentSibling,
        'studentDocument' => $studentDocument,
    ]);

    return $collection;
}

    public function update(int $id, array $data): ?StudentDetail
    {
        $student = $this->getById($id);

        $updated = $student->update($this->prepareForDB($data, $student));

        if ($updated) {
            $student = $this->getById($id);
        }

        return $student;
    }

    public function delete(int $id): ?StudentDetail
    {
        $student = $this->getById($id);
        $deleted = $student->delete();

        if (!$deleted) {
            throw new Exception("User student could not be deleted.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $student;
    }

    public function prepareForDB(array $data, ?StudentDetail $student = null): array
    {
        if (empty($data['student_id'])) {
            $data['student_id'] = $this->createUniqueSlug($data['student_id']);
        }
        return $data;
    }

    private function createUniqueSlug(string $title): string
    {
        return Str::slug(substr($title, 0, 80)) . '-' . time();
    }




}