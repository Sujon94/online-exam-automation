<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৫:০৪ PM
 */

namespace App\Manager\backend;


use App\Contract\backend\StudentContract;
use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\Students;
use App\Entities\backend\StudentTransaction;
use App\Enums\ColumnName;
use App\Enums\DocFileCode;
use App\Enums\LTransactionStatus;
use App\Enums\Role;
use App\Enums\TableName;
use App\Enums\YesNoFlag;
use App\Helpers\HelperClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentManager implements StudentContract
{
    //private Students $student;
    private $student;
    protected $file;

    public function __construct()
    {
        $this->student = new Students();
        $this->file = new SelfDevelopmentFile();
    }

    public function getAllStudents()
    {
        return $this->student->all();
    }

    public function getAStudentDetail(int $id)
    {
        return $this->student->where('student_id', '=', $id)->with('photo','student_cert', 'profession_type', 'religion', 'exam')->first();
    }

    public function getStudentsOnProfession(int $id)
    {
        return $this->student->where('profession_type_id', '=', $id)->orderBy('created_at','desc')->get();
    }

    public function studentCreate(array $data)
    {
        try {
            DB::beginTransaction();
            $this->student->profession_type_id = $data['profession'];
            $this->student->candidate_name = htmlspecialchars($data['name']);
            $this->student->mobile = htmlspecialchars($data['mobile']);
            $this->student->email = htmlspecialchars($data['email']);
            $this->student->password = $data['password'];
            $this->student->save();

            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Student Created', 'id' => $this->student->student_id];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function studentUpdate(int $id, Request $request)
    {
        try {
            DB::beginTransaction();
            $student = $this->student->where('student_id', '=', $id)->first();

            $student->father_name = $request->post('father_name');
            $student->mother_name = htmlspecialchars($request->post('mother_name'));
            $student->guardian_name = $request->post('guardian_name') ? htmlspecialchars($request->post('guardian_name')) : null;
            $student->guardian_mobile = $request->post('guardian_mobile') ? ($request->post('guardian_mobile')) : null;
            $student->nationality = htmlspecialchars($request->post('nationality'));
            $student->date_of_birth = date('Y-m-d', strtotime($request->post('date_of_birth')));
            $student->religion_id = $request->post('religion');
            $student->gender_id = $request->post('gender');
            $student->present_address = $request->post('present_address');
            $student->permanent_address = $request->post('permanent_address');
            $student->same_address_yn = $request->post('permanent_address_same_present') && ($request->post('permanent_address_same_present') == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO;
            $student->exam_id = $request->post('exam_type') ? $request->post('exam_type') : null;
            $student->pass_year = $request->post('pass_year') ? $request->post('pass_year') : null;
            $student->institute_name = $request->post('institute_name') ? $request->post('institute_name') : null;
            $student->registration_no = $request->post('reg_no') ? $request->post('reg_no') : null;
            $student->roll_no = $request->post('roll_no') ? $request->post('roll_no') : null;
            $student->gpa_division = $request->post('gpa_division') ? $request->post('gpa_division') : null;
            $student->board = $request->post('board') ? $request->post('board') : null;
            $student->merit_no = $request->post('merit_no') ? $request->post('merit_no') : null;
            $student->designation = $request->post('job_prof_des') ? $request->post('job_prof_des') : null;
            $student->academic_background = $request->post('academic_background') ? $request->post('academic_background') : null;
            $student->interested_courses = $request->post('interest_another_course') ? $request->post('interest_another_course') : null;
            $student->organization = $request->post('org_com') ? $request->post('org_com') : null;
            $student->student_status_id = 3;
            $student->save();


            $image = $request->file('profile_image');
            $certificateFile = $request->file('certificate_file');

            if ($request->hasFile('profile_image')) {
                $proImgInfo = $this->file->where(['parent_table' => TableName::STUDENTS_TABLE, 'parent_id' => $id, 'doc_file_short_code' => DocFileCode::PROFILE])->first();

                $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                $fileExt = $image->getMimeType();
                $fileName = $image->getClientOriginalName();

                /*SelfDevelopmentFile::firstOrCreate([
                    "parent_table" => TableName::STUDENTS_TABLE,
                    "parent_id" => $id,
                    'doc_file_short_code' => DocFileCode::PROFILE
                ], [
                    "doc_file_name" => $fileName,
                    "doc_file_type" => $fileExt,
                    "doc_file" => $byteCode,
                    "doc_file_short_code" => DocFileCode::PROFILE,
                    "thumbnail_yn" => YesNoFlag::NO
                ]);

                $proImgInfo->parent_table = TableName::STUDENTS_TABLE;
                $proImgInfo->parent_id = $id;
                $proImgInfo->doc_file_name =$fileName;
                $proImgInfo->doc_file_type = $fileExt;
                $proImgInfo->doc_file = $byteCode;
                $proImgInfo->doc_file_short_code = DocFileCode::PROFILE;
                $proImgInfo->thumbnail_yn = YesNoFlag::NO;*/

                //$proImgInfo->save();


                 if (!empty($proImgInfo)) {
                     $proImgInfo->parent_table = TableName::STUDENTS_TABLE;
                     $proImgInfo->parent_id = $id;
                     $proImgInfo->doc_file_name =$fileName;
                     $proImgInfo->doc_file_type = $fileExt;
                     $proImgInfo->doc_file = $byteCode;
                     $proImgInfo->doc_file_short_code = DocFileCode::PROFILE;
                     $proImgInfo->thumbnail_yn = YesNoFlag::NO;

                     $proImgInfo->save();
                 } else {
                     $this->file1 = new SelfDevelopmentFile();
                     $this->file1->parent_table = TableName::STUDENTS_TABLE;
                     $this->file1->parent_id = $id;
                     $this->file1->doc_file_name = $fileName;
                     $this->file1->doc_file_type = $fileExt;
                     $this->file1->doc_file = $byteCode;
                     $this->file1->doc_file_short_code = DocFileCode::PROFILE;
                     $this->file1->thumbnail_yn = YesNoFlag::NO;

                     $this->file1->save();
                 }
            }

            if ($request->hasFile('certificate_file')){
                $cerFileInfo = $this->file->where(['parent_table'=>TableName::STUDENTS_TABLE,'parent_id'=>$id,'doc_file_short_code'=>DocFileCode::S_CERT])->first();

                $byteCode = base64_encode(file_get_contents($certificateFile->getRealPath()));
                $fileExt = $certificateFile->getMimeType();
                $fileName = $certificateFile->getClientOriginalName();



                if (!empty($cerFileInfo)){
                    $cerFileInfo->parent_table = TableName::STUDENTS_TABLE;
                    $cerFileInfo->parent_id = $id;
                    $cerFileInfo->doc_file_name =$fileName;
                    $cerFileInfo->doc_file_type = $fileExt;
                    $cerFileInfo->doc_file = $byteCode;
                    $cerFileInfo->doc_file_short_code = DocFileCode::S_CERT;
                    $cerFileInfo->thumbnail_yn = YesNoFlag::NO;

                    $cerFileInfo->save();
                } else {
                    $this->file2 = new SelfDevelopmentFile();
                    $this->file2->parent_table = TableName::STUDENTS_TABLE;
                    $this->file2->parent_id = $id;
                    $this->file2->doc_file_name = $fileName;
                    $this->file2->doc_file_type = $fileExt;
                    $this->file2->doc_file = $byteCode;
                    $this->file2->doc_file_short_code =  DocFileCode::S_CERT;
                    $this->file2->thumbnail_yn = YesNoFlag::NO;

                    $this->file2->save();
                }
            }

            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Student Information Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }
}