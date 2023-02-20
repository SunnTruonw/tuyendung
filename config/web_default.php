<?php
    return [
        'frontend'=>[
            'noImage'=>'/frontend/images/noimage.jpg',
            'userNoImage'=>'/frontend/images/usernoimage.png',
            'categoryProductOrigin'=>1,
            'priceSearch' =>[
                1=>[
                    'value'=>1,
                    'start'=>0,
                    'end'=>3000000,
					'name'=>'Dưới 3 triệu'
                ],
                2=>[
                    'value'=>2,
                    'start'=>3000000,
                    'end'=>5000000,
					'name'=>'Từ 3 triệu - 5 triệu'
                ],
                3=>[
                    'value'=>3,
                    'start'=>5000000,
                    'end'=>10000000,
					'name'=>'Từ 5 triệu - 10 triệu'
                ],
                4=>[
                    'value'=>4,
                    'start'=>10000000 ,
                    'end'=>40000000,
					'name'=>'Từ 10 triệu - 40 triệu'
                ],
				5=>[
                    'value'=>5,
                    'start'=>40000000 ,
                    'end'=>70000000,
					'name'=>'Từ 40 triệu - 70 triệu'
                ],
				6=>[
                    'value'=>6,
                    'start'=>70000000 ,
                    'end'=>100000000,
					'name'=>'Từ 70 triệu - 100 triệu'
                ],
				6=>[
                    'value'=>6,
                    'start'=>100000000 ,
                    'end'=>500000000,
					'name'=>'Từ 100 triệu - 500 triệu'
                ],
				7=>[
                    'value'=>7,
                    'start'=>500000000 ,
                    'end'=>800000000,
					'name'=>'Từ 500 triệu - 800 triệu'
                ],
				7=>[
                    'value'=>7,
                    'start'=>800000000 ,
                    'end'=>1000000000,
					'name'=>'Từ 800 triệu - 1 tỷ'
                ],
				8=>[
                    'value'=>8,
                    'start'=>1000000000 ,
                    'end'=>2000000000,
					'name'=>'Từ 1 tỷ - 2 tỷ'
                ],
				9=>[
                    'value'=>9,
                    'start'=>2000000000 ,
                    'end'=>4000000000,
					'name'=>'Từ 2 tỷ - 4 tỷ'
                ],
				10=>[
                    'value'=>10,
                    'start'=>4000000000 ,
                    'end'=>6000000000,
					'name'=>'Từ 4 tỷ - 6 tỷ'
                ],
				11=>[
                    'value'=>11,
                    'start'=>6000000000 ,
                    'end'=>10000000000,
					'name'=>'Từ 6 tỷ - 10 tỷ'
                ],
                12=>[
                    'value'=>12,
                    'start'=>10000000000 ,
                    'end'=>null,
					'name'=>'Trên 10 tỷ'
                ],
            ],
        ],
        'backend'=>[
            'noImage'=>'/admin_asset/images/noimage.png',
            'userNoImage'=>'/admin_asset/images/usernoimage.png',
        ],
        'huongnha'=>[
            1=>[
                'value'=>1,
                'name'=>'Bắc',
            ],
            2=>[
                'value'=>2,
                'name'=>'Đông Bắc',
            ],
            3=>[
                'value'=>3,
                'name'=>'Đông',
            ],
            4=>[
                'value'=>4,
                'name'=>'Đông Nam',
            ],
            5=>[
                'value'=>5,
                'name'=>'Nam',
            ],
            6=>[
                'value'=>6,
                'name'=>'Tây',
            ],
            7=>[
                'value'=>7,
                'name'=>'Tây Bắc',
            ],
            8=>[
                'value'=>8,
                'name'=>'Tây Nam',
            ],
        ],
        'donvi'=>[
            1=>[
                'value'=>1,
                'name'=>'Thỏa thuận',
                'trans'=>1,
            ],
            2=>[
                'value'=>2,
                'name'=>'Triệu',
                'trans'=>1000000,
            ],
            3=>[
                'value'=>3,
                'name'=>'Tỷ',
                'trans'=>1000000000,
            ],
            4=>[
                'value'=>4,
                'name'=>'Ngàn/m2',
                'trans'=>1000,
            ],
            5=>[
                'value'=>5,
                'name'=>'Triệu/m2',
                'trans'=>1000000,
            ],
            6=>[
                'value'=>6,
                'name'=>'Ngàn/tháng',
                'trans'=>1000,
            ],
            7=>[
                'value'=>7,
                'name'=>'Triệu/tháng',
                'trans'=>1000000,
            ],
            8=>[
                'value'=>8,
                'name'=>'Ngàn/m2/tháng',
                'trans'=>1000,
            ],
            9=>[
                'value'=>9,
                'name'=>'Triệu/m2/tháng',
                'trans'=>1000000,
            ],
            10=>[
                'value'=>10,
                'name'=>'Ngàn/chiếc',
                'trans'=>1000,
            ],
            11=>[
                'value'=>11,
                'name'=>'Triệu/chiếc',
                'trans'=>1000000,
            ],
            12=>[
                'value'=>12,
                'name'=>'Ngàn/suất',
                'trans'=>1000,
            ],
            13=>[
                'value'=>13,
                'name'=>'Triệu/suất',
                'trans'=>1000000,
            ],
        ],
        'typeUser'=>[
            1=>[
                'value'=>1,
                'name'=>'Người mua'
            ],
            2=>[
                'value'=>2,
                'name'=>'Người bán'
            ],
            3=>[
                'value'=>3,
                'name'=>'Người môi giới'
            ],
        ],
        'typeContact'=>[
            0=>[
                'value'=>0,
                'name'=>'Đăng ký liên hệ'
            ],
            1=>[
                'value'=>1,
                'name'=>'Đăng ký nhận mã giảm giá'
            ],
        ],
        'priceSearch' =>[
            1=>[
                'value'=>1,
                'start'=>0,
                'end'=>500000,
                'name'=>'Dưới 500 nghìn'
            ],
            2=>[
                'value'=>2,
                'start'=>500000,
                'end'=>1000000,
                'name'=>'Từ 500 nghìn - 1 triệu'
            ],
            3=>[
                'value'=>3,
                'start'=>1000000,
                'end'=>3000000,
                'name'=>'Từ 1 triệu - 3 triệu'
            ],
            4=>[
                'value'=>4,
                'start'=>3000000 ,
                'end'=>5000000,
                'name'=>'Từ 3 triệu - 5 triệu'
            ],
            5=>[
                'value'=>5,
                'start'=>5000000 ,
                'end'=>10000000,
                'name'=>'Từ 5 triệu - 10 triệu'
            ],
            6=>[
                'value'=>6,
                'start'=>10000000 ,
                'end'=>20000000,
                'name'=>'Từ 10 triệu - 20 triệu'
            ],
            7=>[
                'value'=>7,
                'start'=>20000000 ,
                'end'=>50000000,
                'name'=>'Từ 20 triệu - 50 triệu'
            ],
            8=>[
                'value'=>8,
                'start'=>50000000 ,
                'end'=>null,
                'name'=>'Trên 50 triệu'
            ],
        ],
        'statusTransaction'=>[
            1 => [
                'status' => 1,
                'name' => 'Chưa sử lý',
            ],
            2 => [
                'status' => 2,
                'name' => 'Nhận đơn',
            ],
            3 => [
                'status' => 3,
                'name' => 'Đang vận chuyển',
            ],
            4 => [
                'status' => 4,
                'name' => 'Hoàn thành',
            ],
            -1 => [
                'status' => -1,
                'name' => 'Hủy bỏ',
            ],
        ]
    ];
