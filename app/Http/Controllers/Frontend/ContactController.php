<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\Contact;
use App\Entities\backend\PageSetup;
use App\Enums\LTransactionStatus;
use App\Enums\PageContent;
use App\Enums\PageName;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{
    protected $contactInfo;

    public function __construct()
    {
        $this->contactInfo = new Contact();
    }

    public function index()
    {
        $address = PageSetup::select('*')->where('page_id', PageName::CONTACT)->where('content_id',PageContent::ADDRESS)
            ->orderBy('content_serial', 'asc')->get();
        $contact = PageSetup::select('*')->where('page_id', PageName::CONTACT)->where('content_id',PageContent::CONTACT)
            ->orderBy('content_serial', 'asc')->first();
        $support = PageSetup::select('*')->where('page_id', PageName::CONTACT)->where('content_id',PageContent::SUPPORT)
            ->orderBy('content_serial', 'asc')->first();
        return view('frontend.contact.index', compact('address', 'contact', 'support'));
    }

    public function store(Request $request)
    {
        $response = $this->contact_api_store($request);

        $message = $response['message'];

        if ($response['code'] != '1') {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message)->withInput();
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('contact-us.index');

    }

    private function contact_api_store(Request $request)
    {
        //dd($request);

        try {
            DB::beginTransaction();

            $this->contactInfo->name = $request->post('name');
            $this->contactInfo->email = $request->post('email');
            $this->contactInfo->phone = $request->post('pnumber');
            $this->contactInfo->message = $request->post('message');

            $this->contactInfo->save();

            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Your Message Has Been Successfully Submitted'];
        } catch (\Exception $e) {
            //dd($e);
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

}