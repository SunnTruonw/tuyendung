<div id="side-bar">
    <div class="side-bar">
        @foreach ($categoryProduct as $categoryItem)
        <div class="title-sider-bar">
            {{ $categoryItem->name }}
        </div>
        <div class="list-category">
            {{-- <ul class="menu-side-bar">
                <li class="nav_item"><a href="http://demo11.bivaco.net/trang-diem"><span>Trang điểm</span></a>
                    <ul class="menu-side-bar-leve-2">
                        <li class="nav_item1">
                            <a href="http://demo11.bivaco.net/trang-diem-moi"><span>Trang điểm môi</span></a>
                            <ul class="menu-side-bar-leve-3">
                                <li class="nav_item2">
                                    <a href="http://demo11.bivaco.net/son-ly"><span>Son lỳ</span></a>
                                </li>
                             </ul>
                        </li>
                        <li class="nav_item1">
                            <a href="http://demo11.bivaco.net/dung-cu-trang-diem"><span>Dụng cụ trang điểm</span></a>
                            <ul class="menu-side-bar-leve-3">
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul> --}}
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs()->get(),
                'type'=>"category_products",
            ])
        </div>
        @endforeach
    </div>

    <div class="side-bar">
        @foreach ($categoryPost as $categoryItem)
        <div class="title-sider-bar">
            {{ $categoryItem->name }}
        </div>
        <div class="list-category">
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs,
                'type'=>"category_posts",
            ])
        </div>
        @endforeach
    </div>
</div>
