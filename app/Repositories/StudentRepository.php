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

$collection = collect(StudentDetail::join('student_parents', 'student_details.student_id', '=', 'student_parents.student_id')
    ->join('student_siblings', 'student_details.student_id', '=', 'student_siblings.student_id')
    ->join('student_documents', 'student_details.student_id', '=', 'student_documents.student_id')
    ->select(
        'student_details.*',
        'student_parents.*',
        'student_siblings.*',
        'student_documents.*'
    )
    ->get()
    ->toArray());


foreach ($collection as $item) {
    $studentDetail = [
        'student_id' => $item['student_id'],
        'organization_id' => $item['organization_id'],
        'year_grade_class_id' => $item['year_grade_class_id'],
        'admission_no' => $item['admission_no'],
        'first_name' => $item['first_name'],
        'last_name' => $item['last_name'],
        'name_with_initials' => $item['name_with_initials'],
        'name_in_full' => $item['name_in_full'],
        'address_line1' => $item['address_line1'],
        'address_line2' => $item['address_line2'],
        'address_city' => $item['address_city'],
        'telephone_residence' => $item['telephone_residence'],
        'telephone_mobile' => $item['telephone_mobile'],
        'telephone_whatsapp' => $item['telephone_whatsapp'],
        'email_address' => $item['email_address'],
        'gender' => $item['gender'],
        'date_of_birth' => $item['date_of_birth'],
        'religion' => $item['religion'],
        'ethnicity' => $item['ethnicity'],
        'birth_certificate_number' => $item['birth_certificate_number'],
        'profile_picture_path' => $item['profile_picture_path'],
        'health_conditions' => $item['health_conditions'],
        'admission_date' => $item['admission_date'],
        'admission_payment_amount' => $item['admission_payment_amount'],
        'no_of_installments' => $item['no_of_installments'],
        'admission_status' => $item['admission_status'],
        'school_fee' => $item['school_fee'],
        'total_due' => $item['total_due'],
        'payment_status' => $item['payment_status'],
        'academic_status' => $item['academic_status'],
        'updated_at' => $item['updated_at'],
        'created_at' => $item['created_at'],
        'id' => $item['id'],
    ];

    $studentParent = [
        'student_id' => $item['student_id'],
        'organization_id' => $item['organization_id'],
        'first_name' => $item['first_name'],
        'last_name' => $item['last_name'],
        'relationship' => $item['relationship'],
        'nic' => $item['nic'],
        'higher_education_qualification' => $item['higher_education_qualification'],
        'occupation' => $item['occupation'],
        'official_address' => $item['official_address'],
        'permanent_address' => $item['permanent_address'],
        'contact_official' => $item['contact_official'],
        'contact_mobile' => $item['contact_mobile'],
        'updated_at' => $item['updated_at'],
        'created_at' => $item['created_at'],
        'id' => $item['id'],
    ];

    $studentSibling = [
        'student_id' => $item['student_id'],
        'organization_id' => $item['organization_id'],
        'first_name' => $item['first_name'],
        'last_name' => $item['last_name'],
        'gender' => $item['gender'],
        'date_of_birth' => $item['date_of_birth'],
        'school' => $item['school'],
        'updated_at' => $item['updated_at'],
        'created_at' => $item['created_at'],
        'id' => $item['id'],
    ];

    $studentDocument = [
        'student_id' => $item['student_id'],
        'organization_id' => $item['organization_id'],
        'profile_picture' => $item['profile_picture'],
        'birth_certificate' => $item['birth_certificate'],
        'nic_father' => $item['nic_father'],
        'nic_mother' => $item['nic_mother'],
        'marriage_certificate' => $item['marriage_certificate'],
        'permission_letter' => $item['permission_letter'],
        'leaving_certificate' => $item['leaving_certificate'],
        'updated_at' => $item['updated_at'],
        'created_at' => $item['created_at'],
        'id' => $item['id'],
    ];

    $data['studentDetail'] = $studentDetail;
    $data['studentParent'] = $studentParent;
    $data['studentSibling'] = $studentSibling;
    $data['studentDocument'] = $studentDocument;
}

return $data;

        
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