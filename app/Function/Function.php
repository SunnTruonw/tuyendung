<?php
// tạo link
function makeLink($type, $id = null, $slug = null,$request=[])
{
    $route = "";
    switch ($type) {
        case 'category_products':
            $route = route("product.productByCategory", ["id" => $id, "slug" => $slug]);
            break;
        case 'category_posts':
            $route = route("post.postByCategory", ["id" => $id, "slug" => $slug]);
            break;
        case 'post':
            $route = route("post.detail", ["id" => $id, "slug" => $slug]);
            break;
        case 'post_all':
            $route = route("post.index");
            break;
        case 'product':
            $route = route("product.detail", ["id" => $id, "slug" => $slug]);
            break;
        case 'product_all':
            $route = route("product.index");
            break;
        case 'home':
            $route = route("home.index");
            break;
        case 'about-us':
            $route = route("about-us");
            break;
        case 'contact':
            $route = route("contact.index");
            break;
        case 'search':
            $route = route("home.search",$request);
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}


function menuRecusive($model, $id, $result = array(), $i = 0)
{
    //  global $result;
    $i++;
    $data = $model->select(['id', 'name', 'slug'])->find($id)->setAppends(['slug_full']);
    $item = $data->toArray();
    // dd($item);
    $childs =  $data->childs()->select(['id', 'name', 'slug'])->get();
    foreach ($childs as $child) {
        //  $res  = $child->setAppends(['slug'])->toArray();

        $res =  menuRecusive($model, $child->id, []);
        // dd( $res );
        $item['childs'][] = $res;
        //   dd($item);
    }
    //  dd($result);
    // array_push($result, $item);
    return $item;
}

// quy đổi tiền sang điểm
function moneyToPoint($money){
    $money=(int)$money;
    return $money/config('point.pointToMoney');
}
function pointToMoney($point){
    return (float)$point*config('point.pointToMoney');
}
