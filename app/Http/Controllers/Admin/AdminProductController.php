<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Models\ProductTag;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Models\Option;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddProduct;
use App\Http\Requests\Admin\ValidateEditProduct;
use App\Exports\ExcelExportsDatabase;
use App\Exports\ExcelExportsDatabaseProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;
use App\Models\Attribute;
use App\Models\ProductAttributeChild;

class AdminProductController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $product;
    private $categoryProduct;
    private $htmlselect;
    // private $productImage;
    private $tag;
    // private $productTag;
    private $city;
    // private $supplier;
    private $donvi;
    // private $huongnha;
    private $option;
    private $attribute;
    // private $categoryProductOrigin;
    public function __construct(
        Product $product,
        CategoryProduct $categoryProduct,
        ProductImage $productImage,
        City $city,
        District $district,
        Commune $commune,
        // Tag $tag,
        // ProductTag $productTag,
        Option $option,
        // Supplier $supplier,
        Attribute $attribute
    ) {
        $this->product = $product;
        $this->attribute = $attribute;
        $this->categoryProduct = $categoryProduct;
        $this->productImage = $productImage;
        // $this->tag = $tag;
        // $this->commune = $commune;
        $this->city = $city;
        $this->district = $district;
        // $this->productTag = $productTag;
        $this->option = $option;
        // $this->supplier = $supplier;
        // $this->huongnha = config('web_default.huongnha');
        $this->donvi = config('web_default.donvi');
        // $this->categoryProductOrigin = config('web_default.frontend.categoryProductOrigin');
    }
    //
    public function index(Request $request)
    {
        $data = $this->product;

        if ($request->input('category')) {
            $categoryProductId = $request->input('category');
            $idCategorySearch = $this->categoryProduct->getALlCategoryChildren($categoryProductId);
            $idCategorySearch[] = (int)($categoryProductId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryProduct->getHtmlOption($categoryProductId);
        } else {
            $htmlselect = $this->categoryProduct->getHtmlOption();
        }

        if ($request->input('keyword')) {
            $data = $data->where(function ($query) use ($request) {
                return $query->where('masp', 'like', '%' . $request->input('keyword') . '%')
                    ->orWhere('type_car', 'like', '%' . $request->input('keyword') . '%');
            });
        }
        if ($request->has('start') && $request->input('start')) {
            $data = $data->where('time_buy', '>=', $request->input('start'));
        }
        if ($request->has('end') && $request->input('end')) {
            $data = $data->where('time_buy', '<=', $request->input('end'));
        }
        if ($request->has('city_id') && $request->input('city_id')) {
            $data = $data->where('city_id', $request->input('city_id'));
        }

        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['time_buy'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        }

        $totalProduct  = $data->count();

        if ($request->has('btnExcel') && $request->input('btnExcel') == 1) {
            return Excel::download(new ExcelExportsDatabaseProduct($data->get()), 'xpel.xlsx');
        }

        $data = $data->orderBy('id', 'desc')->paginate(15);

        $cities = $this->city->orderby('name')->get();

        //dd($totalProduct);
        return view(
            "admin.pages.product.list",
            [
                'data' => $data,
                'cities' => $cities,
                'option' => $htmlselect,
                'totalProduct' => $totalProduct,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'start' => $request->input('start') ? $request->input('start') : "",
                'end' => $request->input('end') ? $request->input('end') : "",
            ]
        );
    }

    public function loadActive($id)
    {
        $product   =  $this->product->find($id);
        $active = $product->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $product->update([
            'active' => $activeUpdate,
        ]);
        // dd($updateResult);
        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $product, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadBanchay($id)
    {
        $product   =  $this->product->find($id);
        $ban_chay = $product->ban_chay;
        if ($ban_chay) {
            $ban_chayUpdate = 0;
        } else {
            $ban_chayUpdate = 1;
        }
        $updateResult =  $product->update([
            'ban_chay' => $ban_chayUpdate,
        ]);
        // dd($updateResult);
        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-ban-chay', ['data' => $product, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadHot($id)
    {
        $product   =  $this->product->find($id);
        $hot = $product->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $product->update([
            'hot' => $hotUpdate,
        ]);

        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $product, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $address = new AddressHelper();
        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);

        $attributes = Attribute::where('parent_id', 0)->get();
        // $supplier = $this->supplier->where('active', 1)->orderby('order')->latest()->get();
        $htmlselect = $this->categoryProduct->getHtmlOption();

        if ($request->ajax()) {
            $view = view('admin.components.load-checkbox-date-time', [
                'type' => $request->type,
                'time_buy' => $request->time_buy,
                'time_expires' => $request->time_expires,
                'addYear' => $request->addYear,
            ])->render();

            return response()->json([
                'code' => 200,
                'html' => $view,
                'messange' => 'success'
            ], 200);
        }

        return view(
            "admin.pages.product.add",
            [
                'option' => $htmlselect,
                'attributes' => $attributes,
                'cities' => $cities,
                'request' => $request,
                'donvi' => $this->donvi,
                // 'huongnha' => $this->huongnha,
                // 'supplier' => $supplier
            ]
        );
    }
    public function store(ValidateAddProduct $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                "masp" => $request->input('masp'),
                "name_chunha" => $request->input('name_chunha'),
                "phone_chunha" => $request->input('phone_chunha'),
                "type_car" => $request->input('type_car'),
                "bienkiemsoat" => $request->input('bienkiemsoat'),
                "donvithicong" => $request->input('donvithicong'),
                "city_id" => $request->input('city_id'),
                "district_id" => $request->input('district_id'),
                "address_chunha" => $request->input('address_chunha'),
                "time_buy" => $request->input('time_buy') ?? null,
                "time_expires" => $request->input('time_expires') ?? null,
                "time_buy1" => $request->input('time_buy1') ?? null,
                "time_expires1" => $request->input('time_expires1') ?? null,
                "time_buy2" => $request->input('time_buy2') ?? null,
                "time_expires2" => $request->input('time_expires2') ?? null,
                "description" => $request->input('description') ?? null,
                "content" => $request->input('content'),
                "active" => $request->input('active'),

                "check_btn" => $request->input('check_btn') ?? 0,
                "check_btn2" => $request->input('check_btn2') ?? 0,
                "check_btn3" => $request->input('check_btn3') ?? 0,
                "order" => $request->input('order') ?? 0,

                "category_id" => $request->input('category_id') == 0 ? 1 : $request->input('category_id'),
                "admin_id" => auth()->guard('web')->id(),
            ];

            // dd($dataProductCreate);

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // dd($dataProductCreate);
            // insert database in product table
            $product = $this->product->create($dataProductCreate);

            // // insert database to product_images table
            // if ($request->hasFile("image")) {
            //     $dataProductImageCreate = [];
            //     foreach ($request->file('image') as $fileItem) {
            //         $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
            //         $dataProductImageCreate[] = [
            //             "name" => $dataProductImageDetail["file_name"],
            //             "image_path" => $dataProductImageDetail["file_path"]
            //         ];
            //     }
            //     // insert database in product_images table by createMany
            //     $product->images()->createMany($dataProductImageCreate);
            // }

            // insert attribute to product
            if ($request->has("attribute")) {
                $attribute_ids = [];
                foreach ($request->input('attribute') as $attributeItem) {
                    if ($attributeItem) {
                        $attributeInstance = Attribute::find($attributeItem);
                        $attribute_ids[] = $attributeInstance->id;
                    }
                }

                $attribute = $product->attributes()->attach($attribute_ids);
            }

            if ($request->has('attribute_child_id')) {
                $attributeChildId = $request->attribute_child_id;

                foreach ($attributeChildId as $attribute) {
                    $attributeArr = explode('|', $attribute);

                    // dd($attributeArr);
                    if (count($attributeArr) == 4) {
                        $attributeId = $attributeArr[0];
                        $attributeValueId = $attributeArr[1];
                        $attributeName = $attributeArr[2];
                        $attributeValue = $attributeArr[3];

                        ProductAttributeChild::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_product_id' => $attributeValueId,
                            'name' => $attributeName,
                            'value' => $attributeValue,
                        ]);
                    }
                }
            }

            // // insert database to product_tags table
            // if ($request->has("tags")) {
            //     foreach ($request->tags as $tagItem) {
            //         $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
            //         $tag_ids[] = $tagInstance->id;
            //         // $this->productTag->create([
            //         //   "product_id"=> $product->id,
            //         //   "tag_id"=>$tagInstance->id,
            //         // ]);
            //     }
            //     $product->tags()->attach($tag_ids);
            // }

            // if ($request->has("supplier_idOption")) {
            //     //
            //     $dataProductOptionCreate = [];
            //     foreach ($request->input('supplier_idOption') as $key => $value) {
            //         if ($value || $request->input('slugOption')[$key]) {
            //             $dataProductOptionCreate[] = [
            //                 //  "name" => $request->input('nameOption')[$key],
            //                 "supplier_id" => $request->input('supplier_idOption')[$key],
            //                 "slug" =>  $request->input('slugOption')[$key],
            //                 "price" =>  $request->input('priceOption')[$key],
            //             ];
            //         }
            //     }
            //     //   dd($dataProductAnswerCreate);
            //     // insert database in product_images table by createMany
            //     $product->options()->createMany($dataProductOptionCreate);
            // }

            DB::commit();
            return redirect()->route('admin.product.index')->with("alert", "Thêm sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.index')->with("error", "Thêm sản phẩm không thành công");
        }
    }

    public function storeProductService(ValidateAddProduct $request)
    {
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                "masp" => $request->input('masp'),
                "name_chunha" => $request->input('name_chunha'),
                "phone_chunha" => $request->input('phone_chunha'),
                "type_car" => $request->input('type_car'),
                "bienkiemsoat" => $request->input('bienkiemsoat'),
                "donvithicong" => $request->input('donvithicong'),
                "city_id" => $request->input('city_id'),
                "district_id" => $request->input('district_id'),
                "address_chunha" => $request->input('address_chunha'),
                "time_buy" => $request->input('time_buy'),
                "time_expires" => $request->input('time_expires'),
                "time_buy1" => $request->input('time_buy1'),
                "time_expires1" => $request->input('time_expires1'),
                "time_buy2" => $request->input('time_buy2'),
                "time_expires2" => $request->input('time_expires2'),
                "description" => $request->input('description') ?? '',
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id') == 0 ? 1 : $request->input('category_id'),
                "admin_id" => auth()->guard('web')->id(),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in product table
            $product = $this->product->create($dataProductCreate);

            // insert attribute to product
            if ($request->has("attribute")) {

                $attribute_ids = [];
                foreach ($request->input('attribute') as $attributeItem) {
                    if ($attributeItem) {
                        $attributeInstance = Attribute::find($attributeItem);
                        $attribute_ids[] = $attributeInstance->id;
                    }
                }

                $attribute = $product->attributes()->attach($attribute_ids);
            }

            if ($request->has('attribute_child_id')) {
                $attributeChildId = $request->attribute_child_id;

                foreach ($attributeChildId as $attribute) {
                    $attributeArr = explode('|', $attribute);

                    if (count($attributeArr) == 4) {
                        $attributeId = $attributeArr[0];
                        $attributeValueId = $attributeArr[1];
                        $attributeName = $attributeArr[2];
                        $attributeValue = $attributeArr[3];

                        ProductAttributeChild::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_product_id' => $attributeValueId,
                            'name' => $attributeName,
                            'value' => $attributeValue,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => 'Thêm bảo hành thành công',
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            // dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                'html' => 'Thêm bảo hành không thành công',
                "message" => "fail"
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {

            $view = view('admin.components.load-checkbox-date-time', [
                'type' => $request->type,
                'time_buy' => $request->time_buy,
                'time_expires' => $request->time_expires,
                'addYear' => $request->addYear,
            ])->render();

            return response()->json([
                'code' => 200,
                'html' => $view,
                'messange' => 'success'
            ], 200);
        }

        $data = $this->product->with('attributeChilds', 'attributes')->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOption($category_id);
        $attributes = Attribute::with('childs', 'options', 'translations')->where('parent_id', 0)->orderBy('order')->get();

        $cities = $this->city->orderby('name')->get();
        // $supplier = $this->supplier->where('active', 1)->orderby('order')->latest()->get();


        return view("admin.pages.product.edit", [
            'option' => $htmlselect,
            'attributes' => $attributes,
            'data' => $data,
            'cities' => $cities,
            'donvi' => $this->donvi,
            // 'huongnha' => $this->huongnha,
            // 'supplier' => $supplier
        ]);
    }

    public function loadProductService($id)
    {
        $data = $this->product->with('attributeChilds', 'attributes')->find($id);
        $attributes = Attribute::with('childs', 'options', 'translations')->where('parent_id', 0)->orderBy('order')->get();
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOption($category_id);
        $cities = $this->city->orderby('name')->get();

        return response()->json([
            'code' => 200,
            'htmlLoadProductService' => view('admin.components.load-product-service', [
                'data' => $data,
                'attributes' => $attributes,
                'option' => $htmlselect,
                'cities' => $cities,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }


    public function update(ValidateEditProduct $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                "masp" => $request->input('masp'),
                "name_chunha" => $request->input('name_chunha'),
                "phone_chunha" => $request->input('phone_chunha'),
                "type_car" => $request->input('type_car'),
                "bienkiemsoat" => $request->input('bienkiemsoat'),
                "donvithicong" => $request->input('donvithicong'),
                "city_id" => $request->input('city_id'),
                "district_id" => $request->input('district_id'),
                "address_chunha" => $request->input('address_chunha'),
                "time_buy" => $request->input('time_buy') ?? null,
                "time_expires" => $request->input('time_expires') ?? null,
                "time_buy1" => $request->input('time_buy1') ?? null,
                "time_expires1" => $request->input('time_expires1') ?? null,
                "time_buy2" => $request->input('time_buy2') ?? null,
                "time_expires2" => $request->input('time_expires2') ?? null,
                "description" => $request->input('description') ?? null,
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "check_btn" => $request->input('check_btn') ?? 0,
                "check_btn2" => $request->input('check_btn2') ?? 0,
                "check_btn3" => $request->input('check_btn3') ?? 0,
                "order" => $request->input('order') ?? 0,
                "category_id" => $request->input('category_id') == 0 ? 1 : $request->input('category_id'),
                "admin_id" => auth()->guard('web')->id(),
            ];

            // dd($dataProductUpdate);

            // if($request->input('price')&&$request->has('price')){
            //     $dataProductUpdate['price']=transMoneyToStore($request->input('price'),$request->input('donvi'));
            //     $dataProductUpdate['donvi'] = $request->input('donvi');
            // }else{
            //     $dataProductUpdate['price']=0;
            //     $dataProductUpdate['donvi'] =1;
            // }

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $path = $this->product->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProductUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in product table
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);
            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                // $product->images()->where("product_id", $id)->delete();
                $dataProductImageUpdate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
                    $dataProductImageUpdate[] = [
                        "name" => $dataProductImageDetail["file_name"],
                        "image_path" => $dataProductImageDetail["file_path"]
                    ];
                }
                // insert database in product_images table by createMany
                $product->images()->createMany($dataProductImageUpdate);
            }

            // insert attribute to product
            if ($request->has("attribute")) {
                $attribute_ids = [];
                foreach ($request->input('attribute') as $attributeItem) {
                    if ($attributeItem) {
                        $attributeInstance = $this->attribute->find($attributeItem);
                        $attribute_ids[] = $attributeInstance->id;
                    }
                }
                $attribute = $product->attributes()->sync($attribute_ids);
            }

            if (!$request->has('attribute_child_id')) {
                ProductAttributeChild::where('product_id', $id)
                    ->delete();
            } else {
                $attributeChildId = $request->attribute_child_id;
                //delete old data
                ProductAttributeChild::where('product_id', $id)
                    ->delete();

                foreach ($attributeChildId as $attribute) {
                    $attributeArr = explode('|', $attribute);
                    if (count($attributeArr) == 4) {
                        $attributeId = $attributeArr[0];
                        $attributeValueId = $attributeArr[1];
                        $attributeName = $attributeArr[2];
                        $attributeValue = $attributeArr[3];

                        ProductAttributeChild::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_product_id' => $attributeValueId,
                            'name' => $attributeName,
                            'value' => $attributeValue,
                        ]);
                    }
                }
            }


            // insert database to product_tags table
            // if ($request->has("tags")) {
            //     foreach ($request->tags as $tagItem) {
            //         $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
            //         $tag_ids[] = $tagInstance->id;
            //         // $this->productTag->create([
            //         //   "product_id"=> $product->id,
            //         //   "tag_id"=>$tagInstance->id,
            //         // ]);
            //     }
            //     // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
            //     $product->tags()->sync($tag_ids);
            // }


            // if ($request->has("supplier_idOption")) {
            //     //
            //     $dataProductOptionCreate = [];
            //     foreach ($request->input('supplier_idOption') as $key => $value) {
            //         $dataProductOptionCreate[] = [
            //             //  "name" => $request->input('nameOption')[$key],
            //             "supplier_id" => $request->input('supplier_idOption')[$key],
            //             "slug" =>  $request->input('slugOption')[$key],
            //             "price" =>  $request->input('priceOption')[$key],
            //         ];
            //     }
            //     //   dd($dataProductAnswerCreate);
            //     // insert database in product_images table by createMany
            //     $product->options()->createMany($dataProductOptionCreate);
            // }
            // if ($request->has("idOption")) {
            //     //
            //     foreach ($request->input('idOption') as $key => $value) {
            //         $option = $this->option->find($value);
            //         if ($option) {
            //             $dataProductOptionUpdate = [
            //                 "supplier_id" => $request->input('supplier_idOptionOld')[$key],
            //                 "slug" =>  $request->input('slugOptionOld')[$key],
            //                 "price" =>  $request->input('priceOptionOld')[$key],
            //             ];
            //             $option->update($dataProductOptionUpdate);
            //         }
            //     }
            // }
            DB::commit();
            return redirect()->route('admin.product.index')->with("alert", "Sửa sản phẩm thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.index')->with("error", "Sửa sản phẩm không thành công");
        }
    }

    public function detail(Request $request, $id)
    {
        $data = $this->product->with('attributeChilds', 'attributes')->find($id);
        $attributes = Attribute::with('childs', 'options', 'translations')->where('parent_id', 0)->orderBy('order')->get();
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOption($category_id);
        $cities = $this->city->orderby('name')->get();

        return response()->json([
            'code' => 200,
            'htmlLoadProductService' => view('admin.components.product-detail', [
                'data' => $data,
                'attributes' => $attributes,
                'option' => $htmlselect,
                'cities' => $cities,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function loadAttributes(Request $request)
    {
        $attributeId = $request->attributeId;
        $id = $request->id;

        if ($attributeId) {
            $dataParent = Attribute::with('translations')->find($id);

            $dataParentOption = Attribute::where('active', 1)->find($attributeId);

            $data = $dataParentOption->options()->get();

            $html = view('admin.components.load-attribute', compact(
                'data',
                'attributeId',
                'dataParent'
            ))->render();

            return response()->json([
                'data' => $html
            ]);
        }
    }


    public function destroy($id)
    {
        return $this->deleteTrait($this->product, $id);
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.product')), config('excel_database.product.excelfile'));
    }

    public function excelImportDatabase(Request $request)
    {
        try {
            // $this->validate($request, [
            //     'csv_file'  => 'required|mimes:xls,xlsx'
            // ]);
            $path = request()->file('fileExcel')->getRealPath();

            $dataExcel = Excel::import(new ExcelImportsDatabase, $request->file('fileExcel'));

            return redirect()->route('admin.product.index')->with("alert", "Import excel thành công");
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            dd($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
        // $path = request()->file('fileExcel')->getRealPath();
        // Excel::import(new ExcelImportsDatabase(config('excel_database.product')), $path);
    }

    public function loadOptionProduct(Request $request)
    {

        $supplier = $this->supplier->where('active', 1)->orderby('order')->latest()->get();
        $dataView = [
            'i' => $request->i,
            'supplier' => $supplier
        ];
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.load-option-product', $dataView)->render(),
            "message" => "success"
        ], 200);
    }


    public function destroyOptionProduct($id)
    {
        return $this->deleteTrait($this->option, $id);
    }
    public function destroyProductImage($id)
    {
        return $this->deleteImageTrait($this->productImage, $id);
    }
}
