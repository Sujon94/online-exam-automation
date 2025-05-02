<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\CircularContract;
use App\Entities\backend\lookup\LLocation;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CircularSetupController extends Controller
{

    private CircularContract $circularManager;
    private LLocation $location;

    public function __construct( CircularContract $circularManager)
    {
        $this->circularManager = $circularManager;
        $this->location = new LLocation();
    }

    public function index()
    {
        return view('backend.circular.circular_setup', [
            'circularTypes' => $this->circularManager->getAllCircularTypes(),
            'circularPayTypes' => $this->circularManager->getAllCircularPayTypes(),
            'locations' => $this->location->get(),
        ]);
    }

    public function dataList()
    {
        $data = $this->circularManager->getAllCircular();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('application_deadline', function ($data) {
                return HelperClass::dateConvert($data->application_deadline);
            })
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info" href="' . route("circular-setup.edit", ["id" => $data->circular_id]) . '"><i class="bx bx-edit"></i>Edit</a>
                        <form class="removeCircular" style="display: inline" action="' . route("circular-setup.delete", ["id" => $data->circular_id]) . '" method="POST">' . method_field("DELETE") . csrf_field() . '
                            <button class="btn btn-sm btn-danger" type="submit"><i class="bx bx-trash"></i>Remove</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $response = $this->circularManager->store($request); 
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        return view('backend.circular.circular_setup', [
            'insertedData' => $this->circularManager->getCircularInfo($id),
            'circularTypes' => $this->circularManager->getAllCircularTypes(),
            'circularPayTypes' => $this->circularManager->getAllCircularPayTypes(),
            'locations' => $this->location->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->circularManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);    }

    public function delete($id)
    {
        $response = $this->circularManager->delete($id);
        return redirect()->route('circular-setup.index')->with($response['status'], $response['message']);
    }



}