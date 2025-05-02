<?php
/**
 *Created by PhpStorm
 *Created at ২৮/১০/২১ ২:৪২ PM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\MessageContract;
use App\Entities\backend\Contact;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public $messageManager;
    public function __construct(MessageContract $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    public function messageList()
    {
        return view('backend.message.new_message_list');
    }

    public function dataList()
    {
        $data = Contact::orderBy('created_at', 'desc')->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('received_on',function ($data){
                return HelperClass::dateConvert($data->created_at);
            })
            ->editColumn('action', function ($data){
                return '<a href="#" onClick="removeMessage(this,'.$data->contact_id.')"><i class="fa fa-trash"></i></a>';
            })
            ->make(true);
    }

    public function deleteMessage(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->messageManager->delete($request->post('id'));

        return response()->json(['status_code'=>$response['status'],'status_message'=>$response['message']]);
    }
}