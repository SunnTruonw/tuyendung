<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddSupplier;
use App\Http\Requests\Admin\ValidateEditSupplier;
use Illuminate\Support\Facades\Storage;
class AdminSupplierController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $supplier;
    private $langConfig;
    private $langDefault;
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index(Request $request)
    {

        $data = $this->supplier->orderBy("created_at", "desc")->paginate(15);

        return view("admin.pages.supplier.list",
            [
                'data' => $data
            ]
        );

    }
    public function create(Request $request )
    {
        return view("admin.pages.supplier.add",
            [
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddSupplier $request)
    {
        try {
            DB::beginTransaction();

            $dataSupplierCreate = [
                "name" => $request->name,
                "fax" => $request->fax,
                "phone" => $request->phone,
                "email" => $request->email,
                "website" => $request->website,
                "active" => $request->active,
                'order'=>$request->order??0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "logo_path", "supplier");
            if (!empty($dataUploadAvatar)) {
                $dataSupplierCreate["logo_path"] = $dataUploadAvatar["file_path"];
            }
          //  dd($dataSupplierCreate);
            $supplier = $this->supplier->create($dataSupplierCreate);
            // dd($supplier);
            // insert data product lang

            DB::commit();
            return redirect()->route("admin.supplier.index")->with("alert", "Th??m nh?? cung c???p th??nh c??ng");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.supplier.index')->with("error", "Th??m nh?? cung c???p kh??ng th??nh c??ng");
        }
    }
    public function edit($id)
    {
        $data = $this->supplier->find($id);
        return view("admin.pages.supplier.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditSupplier $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSupplierUpdate = [
                "name" => $request->name,
                "fax" => $request->fax,
                "phone" => $request->phone,
                "email" => $request->email,
                "website" => $request->website,
                "active" => $request->active,
                'order'=>$request->order,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryPostUpdate);

            $dataUpdateAvatar = $this->storageTraitUpload($request, "logo_path", "supplier");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->supplier->find($id)->image_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataSupplierUpdate["logo_path"] = $dataUpdateAvatar["file_path"];
            }
            // dd($dataSupplierUpdate);
            $this->supplier->find($id)->update($dataSupplierUpdate);

            $supplier = $this->supplier->find($id);
            DB::commit();
            return redirect()->route("admin.supplier.index")->with("alert", "S???a nh?? cung c???p th??nh c??ng");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.supplier.index')->with("error", "S???a nh?? cung c???p kh??ng th??nh c??ng");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->supplier, $id);
    }

    public function loadActive($id)
    {
        $supplier   =  $this->supplier->find($id);
        $active = $supplier->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $supplier->update([
            'active' => $activeUpdate,
        ]);
        $supplier   =  $this->supplier->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $supplier,'type'=>'slider'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
