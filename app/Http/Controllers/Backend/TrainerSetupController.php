<?php

namespace App\Http\Controllers\Backend;

use App\Contract\backend\TrainerContract;
use App\Entities\backend\lookup\LGender;
use App\Entities\backend\lookup\LReligion;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainerSetupController extends Controller
{

    private TrainerContract $trainerManager;
    private LGender $lGender;
    private LReligion $lReligion;

    public function __construct( TrainerContract $trainerManager)
    {
        $this->trainerManager = $trainerManager;
        $this->lGender = new LGender();
        $this->lReligion = new LReligion();
    }

    public function index()
    {
        return view('backend.trainer.trainer_setup', [
            'lGender' => $this->lGender->all(),
            'lReligion' => $this->lReligion->all(),
        ]);
    }

    public function dataList()
    {
        $data = $this->trainerManager->getAllTrainer();

        return datatables()->of($data)
            ->editColumn('dob', function ($data) {
                return HelperClass::dateConvert($data->dob);
            })
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info" href="' . route("trainer-setup.edit", ["id" => $data->trainer_id]) . '"><i class="bx bx-edit"></i>Edit</a>      
                        <form class="removeTrainer" style="display: inline" action="' . route("trainer-setup.delete", ["id" => $data->trainer_id]) . '" method="POST">' . method_field("DELETE") . csrf_field() . '
                            <button class="btn btn-sm btn-danger" type="submit"><i class="bx bx-trash"></i>Remove</button>
                        </form>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $response = $this->trainerManager->store($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        return view('backend.trainer.trainer_setup', [
            'insertedData' => $this->trainerManager->getTrainerInfo($id),
            'lGender' => $this->lGender->all(),
            'lReligion' => $this->lReligion->all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->trainerManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);    }

    public function delete($id)
    {
        $response = $this->trainerManager->delete($id);
        return redirect()->route('trainer-setup.index')->with($response['status'], $response['message']);
    }


}