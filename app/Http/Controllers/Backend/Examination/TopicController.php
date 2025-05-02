<?php
namespace App\Http\Controllers\Backend\Examination;

use App\Entities\backend\exam_system\ETopic;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = ETopic::all();
        return view('backend.examination.topic.index',compact('topics'));
    }

    public function topicStore(Request $request, $id=null)
    {
        try {
            $topic = new ETopic();
            if (isset($id)){
                $topic = $topic->find($id);
            }
            $topic->name = $request->post('topic_name');
            $topic->active_yn = $request->post('in_active','Y');
            $topic->save();

            if (isset($id)){
                return ["success","topic Updated."];
            }
            return redirect()->back()->with('success', 'Topic created.',$request);

        }catch (\Exception $e){
            if (isset($id)){
                return ["error",'Exception Occurred' . $e->getMessage()];
            }
            return redirect()->back()->with('error', 'Exception Occurred' . $e->getMessage(),$request);
        }
    }


    public function editTopic($id)
    {
       $insertedData = ETopic::where(["id"=>$id])->first();
        $topics = ETopic::all();
        return view('backend.examination.topic.index',compact('topics','insertedData'));
    }

    public function update(Request $request,$id)
    {
       $response = $this->topicStore($request, $id);
       return redirect()->back()->with($response, $request);
    }

    public function delete_topic()
    {
        //TODO: write delete logic
    }
}