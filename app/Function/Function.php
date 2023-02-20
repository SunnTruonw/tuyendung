<?php
// tạo link
function makeLink($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'category_products':
            $route = route("product.productByCategory", ["slug" => $slug]);
            break;
        case 'category_posts':
            $route = route("post.postByCategory", ["slug" => $slug]);
            break;
        case 'post':
            $route = route("post.detail", ["slug" => $slug]);
            break;
        case 'post_all':
            $route = route("post.index");
            break;
        case 'product':
            $route = route("product.detail", ["slug" => $slug, "id" => $id]);
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
        case 'bao-gia':
            $route = route("bao-gia");
            break;
        case 'tuyen-dung':
            $route = route("tuyen-dung");
            break;
        case 'contact':
            $route = route("contact.index");
            break;
        case 'search':
            $route = route("home.search", $request);
            break;
        case 'register':
            $route = route("register");
            break;
        case 'login':
            $route = route("login");
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}
// make link product
function makeLinkProduct($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("product.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("product.productByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'product':
            if ($slug) {
                $route = route("product.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
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
    $data = $model->select(['id', 'name', 'slug'])->where('active', 1)->find($id)->setAppends(['slug_full']);
    $item = $data->toArray();
    // dd($item);
    $childs =  $data->childs()->where('active', 1)->select(['id', 'name', 'slug'])->get();
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
function moneyToPoint($money)
{
    $money = (int)$money;
    return $money / config('point.pointToMoney');
}
function pointToMoney($point)
{
    return (float)$point * config('point.pointToMoney');
}
function makeCodeTransaction($transaction)
{
    $code = date('ymdhsm');
    //  dd($code);
    while ($transaction->where([
        'code' => $code,
    ])->exists()) {
        $code =  date('Ymdhsm') . rand(1, 10);
    }
    return $code;
}
function makeGroupTransaction($transaction)
{
    $group = $transaction->get()->max('group');
    return $group + 1;
}
function transMoneyToView($money, $type)
{
    // $donvi=config('web_default.donvi');
    // return $money/$donvi[$type]['trans'];
    return $money;
}

function transMoneyToStore($money, $type)
{
    $donvi = config('web_default.donvi');
    return $money * $donvi[$type]['trans'];
}

function transMoneyToPoint($money)
{
    $tyle = config('point.trans');
    return $money / $tyle;
}

function makeCodeReview($reviewM)
{
    $code = bin2hex(random_bytes(20));
    //  dd($code);
    while ($reviewM->where([
        'code' => $code,
    ])->exists()) {
        $code = bin2hex(random_bytes(20));
    }
    return $code;
}

function makeCodeUser($user)
{
    $code =   bin2hex(random_bytes(10));
    // dd($code);
    while ($user->where([
        'code' => $code,
    ])->exists()) {
        $code =  bin2hex(random_bytes(10));
    }
    return $code;
}

function checkRouteLanguage($slug, $data)
{
    if ($slug != $data->slug) {
        $name = Route::currentRouteName();
        return redirect()->route($name, ['slug' => $data->slug]);
    } else {
        return false;
    }
}

function checkRouteLanguage2($slug = null)
{
    $name = Route::currentRouteName();
    //  dd($name);
    $lang = App::getLocale();
    $langConfig = array_keys(config('languages.supported'));
    //  dd($langConfig);
    $langDefault = config('languages.default');
    //   dd($langDefault);

    // dd($lang!=$langDefault);
    $slice = '';
    $langCurrentOfRoute = '';
    foreach ($langConfig as $value) {
        if (Str::endsWith($name, '.' . $value)) {
            $slice = Str::before($name, '.' . $value);
            $langCurrentOfRoute = $value;
            break;
        }
    }
    if ($slice == '' && $langCurrentOfRoute == '') {
        $slice = $name;
        $langCurrentOfRoute = $langDefault;
    }
    if ($langCurrentOfRoute != $lang) {
        if ($lang == $langDefault) {

            return redirect()->route($slice, ['slug' => $slug]);
        } else {
            return redirect()->route($slice . '.' . $lang, ['slug' => $slug]);
        }
    } else {
        return false;
    }
}
