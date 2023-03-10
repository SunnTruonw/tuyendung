<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddAttribute;
use App\Http\Requests\Admin\ValidateEditAttribute;
use App\Models\AttributeImage;
use Illuminate\Support\Facades\Storage;

class AdminAttributeController extends Controller
{
    //
    use DeleteRecordTrait, StorageImageTrait;
    private $attribute;
    private $langConfig;
    private $langDefault;

    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index(Request $request)
    {
        $parentBr = null;
        if ($request->has('parent_id')) {
            $data = $this->attribute->where('parent_id', $request->input('parent_id'))->orderBy('order')->orderBy("created_at", "desc")->paginate(15);
            if ($request->input('parent_id')) {
                $parentBr = $this->attribute->find($request->input('parent_id'));
            }
        } else {
            $data = $this->attribute->where('parent_id', 0)->orderBy('order')->orderBy("created_at", "desc")->paginate(15);
        }
        return view(
            "admin.pages.attribute.list",
            [
                'data' => $data,
                'parentBr' => $parentBr,
            ]
        );
    }
    public function create(Request $request)
    {
        if ($request->has("parent_id")) {
            $htmlselect = $this->attribute->getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->attribute->getHtmlOption();
        }
        return view(
            "admin.pages.attribute.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddAttribute $request)
    {
        // dd($request->all());

        try {
            DB::beginTransaction();
            $dataAttributeCreate = [
                "active" => $request->active,
                'order' => $request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $attribute = $this->attribute->create($dataAttributeCreate);
            // dd($attribute);

            // insert data product lang
            $dataAttributeTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemAttributeTranslation = [];
                $itemAttributeTranslation['name'] = $request->input('name_' . $key);
                $itemAttributeTranslation['value'] = $request->input('value_' . $key);
                $itemAttributeTranslation['language'] = $key;
                $dataAttributeTranslation[] = $itemAttributeTranslation;
            }
            //  dd($attribute->translations());
            $attributeTranslation =   $attribute->translations()->createMany($dataAttributeTranslation);

            if ($request->has("nameOption")) {
                //
                $dataChildAttributeCreate = [];
                foreach ($request->input('nameOption') as $key => $value) {
                    if ($value || $request->input('valueOption')[$key]) {

                        $dataChildAttributeCreate[] = [
                            "name" => $request->input('nameOption')[$key],
                            "value" => $request->input('valueOption')[$key],
                            "order" => $request->input('orderOption')[$key],
                        ];
                    }
                }
                $attribute->options()->createMany($dataChildAttributeCreate);
            }


            //  dd($attributeTranslation);
            DB::commit();
            return redirect()->route("admin.attribute.index", ['parent_id' => $request->parent_id])->with("alert", "Th??m attribute th??nh c??ng");
        } catch (\Exception $exception) {
            DB::rollBack();
            // dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.attribute.index', ['parent_id' => $request->parent_id])->with("error", "Th??m attribute kh??ng th??nh c??ng");
        }
    }
    public function edit($id)
    {
        $data = $this->attribute->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Attribute::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.attribute.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditAttribute $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataAttributeUpdate = [
                "active" => $request->active,
                'order' => $request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataAttributeUpdate);
            $this->attribute->find($id)->update($dataAttributeUpdate);
            $attribute = $this->attribute->find($id);
            //  dd($attribute);
            $dataAttributeTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemAttributeTranslationUpdate = [];
                $itemAttributeTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemAttributeTranslationUpdate['value'] = $request->input('value_' . $key) ?? '';
                $itemAttributeTranslationUpdate['language'] = $key;
                if ($attribute->translationsLanguage($key)->first()) {
                    $attribute->translationsLanguage($key)->first()->update($itemAttributeTranslationUpdate);
                } else {
                    $attribute->translationsLanguage($key)->create($itemAttributeTranslationUpdate);
                }
            }

            if ($request->has("nameOption")) {
                //
                $dataChildAttributeCreate = [];
                foreach ($request->input('nameOption') as $key => $value) {
                    if ($value || $request->input('valueOption')[$key]) {

                        $dataChildAttributeCreate[] = [
                            "name" => $request->input('nameOption')[$key],
                            "value" =>  $request->input('valueOption')[$key],
                            "order" =>  $request->input('orderOption')[$key],
                        ];
                    }
                }
                $attribute->options()->createMany($dataChildAttributeCreate);
            }

            if ($request->has("idOption")) {
                //
                foreach ($request->input('idOption') as $key => $value) {
                    if ($value && ($request->input('nameOptionOld')[$key] || $request->input('valueOptionOld')[$key])) {
                        $option = AttributeImage::find($value);
                        if ($option) {

                            $dataChildAttributeOptionUpdate = [
                                "name" => $request->input('nameOptionOld')[$key],
                                "value" =>  $request->input('valueOptionOld')[$key] ?? '',
                                "order" =>  $request->input('orderOptionOld')[$key] ?? 0,
                            ];
                            $option->update($dataChildAttributeOptionUpdate);
                        }
                    }
                }
            }


            DB::commit();
            return redirect()->route("admin.attribute.index", ['parent_id' => $request->parent_id])->with("alert", "S???a attribute th??nh c??ng");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            // dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.attribute.index', ['parent_id' => $request->parent_id])->with("error", "S???a attribute kh??ng th??nh c??ng");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->attribute, $id);
    }

    public function loadChildAttribute(Request $request)
    {
        $dataView = ['i' => $request->i];
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.load-child-attribute', $dataView)->render(),
            "message" => "success"
        ], 200);
    }

    public function destroyOptionAttribute(Request $request, $id)
    {
        $attributeOption = new AttributeImage;
        return $this->deleteTrait($attributeOption, $id);
    }
}
