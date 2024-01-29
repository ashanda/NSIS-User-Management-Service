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

    return  $permissions = StudentDetail::where('sd_academic_status', 1)->get();

        
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

    public function getById($id): ?StudentDetail
    {
       $student = StudentDetail::with('parent_data')
        ->with('sibling_data')
        ->with('documents')
        ->with(['year_class_data' => function ($query) {
            $query->with(['grade', 'class']);
        }])
        ->where('student_id', $id)
        ->first();

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

public function update(array $data, $studentId): ?object 
{
    // Fetch existing records
    $studentDetails = StudentDetail::where('student_id',$studentId)->first();
    $studentParents = StudentParent::where('student_id',$studentId)->first();
    $studentSiblings = StudentSibling::where('student_id',$studentId)->first();
    $studentDocuments = StudentDocument::where('student_id',$studentId)->first();
    
    
    $studentDetail = StudentDetail::find($studentDetails->id);
    $studentParent = StudentParent::find($studentParents->id);
    $studentSibling = StudentSibling::find($studentSiblings->id);
    $studentDocument = StudentDocument::find($studentDocuments->id);


    // Check if any of the models is null
    if ($studentDetail === null || $studentParent === null || $studentSibling === null || $studentDocument === null) {
        return null;
    }

    // Update the existing records with the new data
    $studentDetail->update($data);
    $studentParent->update($data);
    $studentSibling->update($data);
    $studentDocument->update($data);

    // Fetch the updated records (optional, depending on your needs)
    $studentDetail = StudentDetail::find($studentDetails->id);
    $studentParent = StudentParent::find($studentParents->id);
    $studentSibling = StudentSibling::find($studentSiblings->id);
    $studentDocument = StudentDocument::find($studentDocuments->id);

    $collection = collect([
        'studentDetail' => $studentDetail,
        'studentParent' => $studentParent,
        'studentSibling' => $studentSibling,
        'studentDocument' => $studentDocument,
    ]);

    return $collection;
}



     public function delete($id): ?StudentDetail
        {
            $student = StudentDetail::where('student_id', $id)->first();
        
            if (!$student) {
                throw new Exception("User student could not be found.", Response::HTTP_NOT_FOUND);
            }
        
            // Update the student's academic status
            $updateResult = StudentDetail::where('id', $student->id)->update(['sd_academic_status' => 0]);
        
            if ($updateResult === false) {
                throw new Exception("Failed to update academic status.", Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        
            // Return the deleted student instance
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