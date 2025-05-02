<?php

namespace App\Http\Controllers\Backend\Examination;

use App\Entities\backend\exam_system\ESubject;
use App\Entities\backend\exam_system\ESubjectTopic;
use App\Entities\backend\exam_system\ETopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = ESubject::with('topics')->get();
        $topics = ETopic::all();
        return view('backend.examination.subject.index', compact('subjects', 'topics'));
    }

    public function subjectStore(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $subject = new ESubject();
            if (isset($id)) {
                $subject = $subject->find($id);
            }
            $subject->name = $request->post('subject_name');
            $subject->active_yn = $request->post('in_active', 'Y');
            $subject->save();

            $dTopics = [];
            ESubjectTopic::where('subject_id', $subject->id)->delete();
            $topics = $request->post('topic');
            foreach ($topics as $topic) {
                $dTopics[] =
                    [
                        "subject_id" => $subject->id,
                        "topic_id" => $topic
                    ];
            }
            ESubjectTopic::insert($dTopics);
            DB::commit();
            if (isset($id)) {
                return ["success", "Subject Updated."];
            }
            return redirect()->back()->with('success', 'Subject created.', $request);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($id)) {
                return ["error", 'Exception Occurred' . $e->getMessage()];
            }
            return redirect()->back()->with('error', 'Exception Occurred' . $e->getMessage(), $request);
        }
    }


    public function editSubject($id)
    {
        $insertedData = ESubject::with('topics')->where(["id" => $id])->first();
        $subjects = ESubject::all();
        $topics = ETopic::all();
        foreach ($topics as $topic) {
            if (!empty($insertedData->topics)) {
                foreach ($insertedData->topics as $iTopic) {
                    if ($topic->id == $iTopic->topic_id) {
                        $topic->selected = "selected";
                    }
                }

            }
        }

        return view('backend.examination.subject.index', compact('subjects', 'topics', 'insertedData'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->subjectStore($request, $id);
        return redirect()->back()->with($response, $request);
    }

    public function delete_group()
    {
        //Todo:Write delete logic
    }
}