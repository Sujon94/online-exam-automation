<?php


namespace App\Http\Controllers\Backend\Examination;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = [];
        return view('backend.examination.certificate.index', compact('certificates'));
    }

    public function certificateStore(Request $request, $id = null)
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

    public function editCertificate($id)
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

}