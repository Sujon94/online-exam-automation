<?php


namespace App\Manager\backend;


use App\Contract\backend\CourseContract;
use App\Entities\backend\Batch;
use App\Entities\backend\BatchSchedule;
use App\Entities\backend\Course;
use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\StudentTransaction;
use App\Enums\ImageType;
use App\Enums\ParentTable;
use App\Enums\YesNoFlag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseManager implements CourseContract
{
    /*protected Course $course;
    protected SelfDevelopmentFile $file;*/
    protected $course;
    protected $file;
    protected Batch $batch;
    protected SelfDevelopmentFile $selfDevelopmentFile;
    protected BatchSchedule $batchSchedule;
    protected StudentTransaction $studentTransaction;


    public function __construct()
    {
        $this->course = new Course();
        $this->batch = new Batch();
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
        $this->batchSchedule = new BatchSchedule();
        $this->studentTransaction = new StudentTransaction();

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->course->course_type_id = htmlspecialchars($request->post('course_type'));
            $this->course->course_code = htmlspecialchars($request->post('course_code'));
            $this->course->course_name_en = htmlspecialchars($request->post('course_name_en'));
            $this->course->course_name_bn = htmlspecialchars($request->post('course_name_bn'));
            $this->course->slug = $request->post('slug');
            $this->course->course_summary_en = $request->post('course_summary_en');
            $this->course->course_desc_en = $request->post('course_desc_en');
            $this->course->course_faq = $request->post('course_faq');
            $this->course->course_outline_en = $request->post('course_outline_en');
            $this->course->course_topic = $request->post('course_topics');
            $this->course->course_material_en = $request->post('course_material_en');
            $this->course->course_tag = htmlspecialchars($request->post('course_tag'));
            $this->course->course_medium = htmlspecialchars($request->post('course_medium'));
            $this->course->participant_qualification_en = $request->post('qualification_en');
            $this->course->participant_qualification_bn = $request->post('qualification_bn');
            $this->course->meta_title = $request->post('meta_title');
            $this->course->meta_description = $request->post('meta_description');
            $this->course->active_yn = $request->post('active_yn');

            $this->course->save();

            if ($request->file()) {
                $this->file = new SelfDevelopmentFile();

                $image = $request->file('course_thumbnail');
                if (isset($image)) {
                    $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                    $fileExt = $image->getMimeType();
                    $fileName = $image->getClientOriginalName();

                    $this->file->doc_file_name = $fileName;
                    $this->file->doc_file_type = $fileExt;
                    $this->file->doc_file = $byteCode;
                    $this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag');
                    $this->file->thumbnail_yn = YesNoFlag::YES;
                }

                $certificate = $request->file('course_certificate');
                if (isset($certificate)) {
                    $certByteCode = base64_encode(file_get_contents($certificate->getRealPath()));
                    $certExt = $certificate->getMimeType();
                    $certName = $certificate->getClientOriginalName();

                    $this->file->certificate_name = $certName;
                    $this->file->certificate_type = $certExt;
                    $this->file->certificate_file = $certByteCode;
                    $this->file->cert_img_alt_tag = $request->post('cert_img_alt_tag');
                }

                if (isset($image) || isset($certificate)) {
                    $this->file->parent_table = "courses";
                    $this->file->parent_id = $this->course->course_id;
                    $this->file->save();
                }
            }
            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Course Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function getAllCourse()
    {
        return $this->course->with('course_type')->with(['batch'=>function($e){
            $e->select("course_id","batch_id");
        }])->get();
    }

    public function getAllMstCourse()
    {
        return $this->course->with(['course_type', 'course_by_batch.batch_schedule'])->where('active_yn', '=', YesNoFlag::YES)->where('master_yn', '=', YesNoFlag::YES)->orderBy(DB::raw('RAND()'))->take(15)->get();
    }

    public function getAllActiveCourses()
    {
        return $this->course->with('course_type')->where('active_yn', '=', YesNoFlag::YES)->get();
    }

    public function getACourseInfo($id)
    {
        return $this->course->with('course_type', 'course_file')->where('course_id', '=', $id)->first();
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $course = $this->course->find($id);

            $course->course_type_id = htmlspecialchars($request->post('course_type'));
            $course->course_code = htmlspecialchars($request->post('course_code'));
            $course->course_name_en = htmlspecialchars($request->post('course_name_en'));
            $course->course_name_bn = htmlspecialchars($request->post('course_name_bn'));
            $course->slug = $request->post('slug');
            $course->course_summary_en = $request->post('course_summary_en');
            $course->course_desc_en = $request->post('course_desc_en');
            $course->course_faq = $request->post('course_faq');
            $course->course_outline_en = $request->post('course_outline_en');
            $course->course_topic = $request->post('course_topics');
            $course->course_material_en = $request->post('course_material_en');
            $course->course_tag = htmlspecialchars($request->post('course_tag'));
            $course->course_medium = htmlspecialchars($request->post('course_medium'));
            $course->participant_qualification_en = $request->post('qualification_en');
            $course->participant_qualification_bn = $request->post('qualification_bn');
            $course->meta_title = $request->post('meta_title');
            $course->meta_description = $request->post('meta_description');
            $course->active_yn = $request->post('active_yn');
            $course->save();

            $doc_img_alt_tag = $request->post('doc_img_alt_tag');
            $cert_img_alt_tag = $request->post('cert_img_alt_tag');

            //if ( $request->file() || isset($doc_img_alt_tag) ||  isset($cert_img_alt_tag) ) {
                $this->file = SelfDevelopmentFile::where(['parent_table' => ParentTable::COURSE, 'parent_id' => htmlspecialchars($id)])->first();
                $image = $request->file('course_thumbnail');
                if (isset($image)) {
                    $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                    $fileExt = $image->getMimeType();
                    $fileName = $image->getClientOriginalName();

                    $this->file->doc_file_name = $fileName;
                    $this->file->doc_file_type = $fileExt;
                    $this->file->doc_file = $byteCode;
                    $this->file->thumbnail_yn = YesNoFlag::YES;
                }

                $certificate = $request->file('course_certificate');
                if (isset($certificate)) {
                    $certByteCode = base64_encode(file_get_contents($certificate->getRealPath()));
                    $certExt = $certificate->getMimeType();
                    $certName = $certificate->getClientOriginalName();

                    $this->file->certificate_name = $certName;
                    $this->file->certificate_type = $certExt;
                    $this->file->certificate_file = $certByteCode;
                }

                if ( isset($this->file->doc_file_name) ||  isset($this->file->certificate_name) ) {
                    $this->file->doc_img_alt_tag = $doc_img_alt_tag;
                    $this->file->cert_img_alt_tag = $cert_img_alt_tag;
                    $this->file->save();
                }
            //}

            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Course Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $courseInfo = $this->course->with('batch')->where('course_id', '=', htmlspecialchars($id))->first();

            if ($courseInfo->batch->count() > 0){
                foreach ($courseInfo->batch as $batch){
                    $this->selfDevelopmentFile->where(['parent_table'=>ParentTable::BATCH,'parent_id'=> $batch->batch_id])->delete();
                    $this->delete_file($batch->batch_id);
                    $this->batchSchedule->where('batch_id', '=', $batch->batch_id)->delete();
                    $this->studentTransaction->where('batch_id','=',$batch->batch_id)->delete();
                    $this->batch->where('batch_id', '=', $batch->batch_id)->delete();
                }
            }

            $this->course->where('course_id', '=', $courseInfo->course_id)->delete();
            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Course Removed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred'.$e->getMessage()];
        }
    }

    public function delete_file(int $course_id): bool
    {

        $this->file = new SelfDevelopmentFile();
        $this->file->where(['parent_table' => ParentTable::COURSE, 'parent_id' => $course_id, 'thumbnail_yn' => YesNoFlag::YES])->delete();
        return true;
    }

    public function getTypeWiseCourses($id)
    {
        return $this->course->with(['course_by_batch.batch_schedule', 'course_file'])->where('course_type_id', $id)->get();
    }
    public function getTypeWiseRandomCourses($course_id=null,$id)
    {
        return $this->course->with(['course_by_batch.batch_schedule'])
            ->whereNotIn('course_id', [$course_id])
            ->where('course_type_id', $id)->orderBy(DB::raw('RAND()'))->take(3)->get();
    }

    public function getCourseDetails($id)
    {
        return $this->course->with(['course_type','course_by_batch.batch_file','course_file'])->where('course_id', $id)->first();
    }

    public function updateMasterYN($course_id, $status)
    {
        $course = $this->course->find($course_id);
        if ($status == "true") {
            $course->master_yn = YesNoFlag::YES;
        } else {
            $course->master_yn = YesNoFlag::NO;
        }
        $course->save();
        return ["code" => '1', "status" => 'success', "message" => 'Course Updated', "data" => ['course_name' => $course->course_code . " - " . $course->course_name_en]];
    }
}