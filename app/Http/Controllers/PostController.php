<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\Product;

class PostController extends Controller
{
    //
    private $post;
    private $categoryProduct;
    private $product;
    private $unit = 'đ';
    private $categoryPost;
    private $limitPost = 10;
    private $limitPostRelate = 5;
    private $idCategoryPostRoot = 21;
    private $breadcrumbFirst = [];
    public function __construct(
        Post $post,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        Product $product
    ) {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->product = $product;
        $this->breadcrumbFirst = [
            'name' => 'Tin tức',
            'slug' => makeLink("post_all"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {

        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ['id', $this->idCategoryPostRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                return $this->handleCategory($category);
            }
        }
    }

    public function detail($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $data = $this->post->where([
            ["slug", $slug],
        ])->first();
        if(!$data){
            return;
        }
        $categoryId = $data->category_id;

        $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

        $dataRelate =  $this->post->whereIn('category_id', $listIdChildren)->where([
            ["id", "<>", $data->id],
        ])->limit($this->limitPostRelate)->get();
        $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);

        foreach ($listIdParent as $parent) {
            $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
        }

        $dataProductHot=$this->product->where([
            ['active',1],
            ['hot',1]
        ])->latest()->limit(5)->get();
        $dataNewHot=$this->post->where([
            ['active',1],
            ['hot',1]
        ])->latest()->limit(5)->get();

        return view('frontend.pages.post-detail', [
            'data' => $data,
            'dataProductHot' => $dataProductHot,
            'dataNewHot' => $dataNewHot,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    public function tuyendungDetail($id, $slug)
    {
        $breadcrumbs = [];
        $data = [];
        $data = $this->post->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();
        $categoryId = $data->category_id;

        $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

        $dataRelate =  $this->post->whereIn('category_id', $listIdChildren)->where([
            ["id", "<>", $data->id],
        ])->limit($this->limitPostRelate)->get();
        $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);

        foreach ($listIdParent as $parent) {
            $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
        }


        //Tin noi bat
        $post_hot =  $this->post->where('hot', 1)->orderByDesc('created_at')->limit(4)->get();

        return view('frontend.pages.tuyendung-detail', [
            'data' => $data,
            'post_hot' => $post_hot,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'tuyen-dung',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    // danh sách product theo category
    public function postByCategory($slug)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ["slug", $slug],
        ])->first();
        if ($category) {
            if ($category->count()) {
                return $this->handleCategory($category);
            }
        }
    }


    public function handleCategory($category)
    {
        $categoryId = $category->id;
        $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

        $data =  $this->post->whereIn('category_id', $listIdChildren)->paginate($this->limitPost);
        $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
        foreach ($listIdParent as $parent) {
            $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
        }
        $dataProductHot = $this->product->where([
            ['active', 1],
            ['hot', 1]
        ])->latest()->limit(5)->get();
        $dataNewHot = $this->post->where([
            ['active', 1],
            ['hot', 1]
        ])->latest()->limit(5)->get();
        return view('frontend.pages.post', [
            'data' => $data,
            'dataProductHot' => $dataProductHot,
            'dataNewHot' => $dataNewHot,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'category' => $category,
            'seo' => [
                'title' =>  $category->title_seo ?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }
}
