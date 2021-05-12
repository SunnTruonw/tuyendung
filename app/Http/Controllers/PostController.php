<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;

class PostController extends Controller
{
    //
    private $post;
    private $categoryProduct;
    private $unit = 'đ';
    private $categoryPost;
    private $limitPost = 9;
    private $limitPostRelate = 5;
    private $idCategoryPostRoot = 21;
    private $breadcrumbFirst = [];
    public function __construct(Post $post, CategoryPost $categoryPost, CategoryProduct $categoryProduct)
    {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
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
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->post->whereIn('category_id', $listIdChildren)->paginate($this->limitPost);
                $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($this->idCategoryPostRoot)->toArray();
            }
        }

      //  dd($category);
        return view('frontend.pages.post', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'post_all',
            'category'=>$category,
            'seo' => [
                'title' =>  $category->title_seo?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);

        // $breadcrumbs = [];
        // $data = [];
        // // get category
        // $categorys = $this->categoryPost->whereIn(
        //     'id', [13,20]
        // )->get();
        // if ($categorys) {
        //     if ($categorys->count()) {
        //         $listIdChildren=[];
        //         foreach ($categorys as $category) {
        //             $categoryId = $category->id;
        //             $listIdChild = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
        //             array_push($listIdChildren,...$listIdChild);
        //         }
        //         $data =  $this->post->whereIn('category_id', $listIdChildren)->paginate($this->limitPost);
        //     }
        // }

        // if ($this->breadcrumbFirst) {
        //     array_unshift($breadcrumbs, $this->breadcrumbFirst);
        // }


        // return view('frontend.pages.post', [
        //     'data' => $data,
        //     'unit' => $this->unit,
        //     'breadcrumbs' => $breadcrumbs,
        //     'typeBreadcrumb'=>'post_all',
        //     'title'=>"Tin tức"
        // ]);
    }

    public function detail($id, $slug)
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

        foreach ($listIdParent as $parent ) {
            $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
        }

        return view('frontend.pages.post-detail', [
            'data' => $data,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'title' => $data ? $data->name : "",
            'category'=>$data->category??null,
            'seo' => [
                'title' =>  $data->title_seo?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    // danh sách product theo category
    public function postByCategory($id, $slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->post->whereIn('category_id', $listIdChildren)->paginate($this->limitPost);
                $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
                foreach ($listIdParent as $parent ) {
                    $breadcrumbs[]=$this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
                }
            }
        }



        return view('frontend.pages.post', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'category'=>$category,
            'seo' => [
                'title' =>  $category->title_seo?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }
}
