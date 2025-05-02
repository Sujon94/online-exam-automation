<?php


namespace App\Manager\backend;


use App\Contract\backend\PageSetupContract;
use App\Entities\backend\PageSetup;
use App\Entities\backend\PageSetupDetail;
use App\Entities\backend\PageSetupMaster;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\ParentTable;
use App\Enums\YesNoFlag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageSetupManager implements PageSetupContract
{
    protected PageSetup $pageSetup;
    protected SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct()
    {
        $this->pageSetup = new PageSetup();
    }

    public function store(Request $request)
    {//dd($request->all());
        try {
            $serial = PageSetup::where('page_id',$request->post('page_id'))
                ->where('content_id',$request->post('content_id'))
                ->where('content_serial',$request->post('content_serial'))->first();
            if($serial){
                return ["status" => 'error', "message" => 'Please Change Content Serial'];
            }else{
                DB::beginTransaction();
                $this->pageSetup = new PageSetup();
                $this->pageSetup->page_id = $request->post('page_id');
                $this->pageSetup->content_id = $request->post('content_id');
                $this->pageSetup->content_title = $request->post('content_title');
                $this->pageSetup->content_serial = $request->post('content_serial');
                $this->pageSetup->content = $request->post('content');
                $this->pageSetup->link = $request->post('link');
                $this->pageSetup->icon = $request->post('icon');
                $this->pageSetup->active_yn = $request->post('active_yn');
                $this->pageSetup->extra_field_1 = $request->post('extra_field_1');
                $this->pageSetup->extra_field_2 = $request->post('extra_field_2');
                $this->pageSetup->extra_field_3 = $request->post('extra_field_3');

                $this->pageSetup->save();

                $setup_mst_id = $this->pageSetup->id;

                if($setup_mst_id){
                    if ($request->file()) {
                        $this->file = new SelfDevelopmentFile();

                        $image = $request->file('course_thumbnail');
                        if (isset($image)) {
                            $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                            $fileExt = $image->getMimeType();
                            $fileName = $image->getClientOriginalName();

                            $this->file->doc_file_name = $fileName;
                            $this->file->doc_file_type = $fileExt;
                            //$this->file->doc_file = $byteCode;
                            //$this->file->doc_img_alt_tag = $request->post('doc_img_alt_tag');
                            $this->file->thumbnail_yn = YesNoFlag::YES;

                        }

                        if (isset($image)) {
                            $this->file->parent_table = "page_setup";
                            $this->file->parent_id = $setup_mst_id;
                        }

                        $imageName = time() . '.' . $image->extension();
                        $this->file->social_file_name = $imageName;
                        $image->move(public_path('frontend/assets/image'), $imageName);
                        $this->file->save();
                    }
                }
                DB::commit();
                return ["status" => 'success', "message" => 'Page Content Created'];
            }


        } catch (\Exception $e) {
            //dd($e);
            DB::rollBack();
            return ["status" => 'error', "message" => $e];
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $pageSetup = $this->pageSetup->find($id);

            $pageSetup->content_title = htmlspecialchars($request->post('content_title'));
            $pageSetup->content_serial = $request->post('content_serial');
            $pageSetup->content = $request->post('content');
            $pageSetup->link = $request->post('link');
            $pageSetup->icon = $request->post('icon');
            $pageSetup->active_yn = $request->post('active_yn');
            $pageSetup->extra_field_1 = $request->post('extra_field_1');
            $pageSetup->extra_field_2 = $request->post('extra_field_2');
            $pageSetup->extra_field_3 = $request->post('extra_field_3');

            $pageSetup->save();

            if($id){
                if ($request->file()) {
                    $chkIfExist = SelfDevelopmentFile::where(['parent_table' => 'page_setup', 'parent_id' => htmlspecialchars($id)])->first();
                    if($chkIfExist){
                        $this->file = SelfDevelopmentFile::where(['parent_table' => 'page_setup', 'parent_id' => htmlspecialchars($id)])->first();
                        //$this->file = new SelfDevelopmentFile();

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

                        if (isset($image)) {
                            $this->file->parent_table = "page_setup";
                            $this->file->parent_id = $id;
                        }
                        $imageName = time() . '.' . $image->extension();
                        $this->file->social_file_name = $imageName;
                        $image->move(public_path('frontend/assets/image'), $imageName);
                        $this->file->save();
                    }else{
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

                        if (isset($image)) {
                            $this->file->parent_table = "page_setup";
                            $this->file->parent_id = $id;
                        }

                        $imageName = time() . '.' . $image->extension();
                        $this->file->social_file_name = $imageName;
                        $image->move(public_path('frontend/assets/image'), $imageName);
                        $this->file->save();
                    }

                }
            }
            DB::commit();
            return ["status" => 'success', "message" => 'Page Content Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }

    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->courseType->where('id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Course Type Removed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }
}