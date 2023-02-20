<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostSeeder::class);
    }
}

class PostSeeder extends Seeder
{
    public function run()
    {

        // DB::table('posts')->update([
        //     'updated_at' => Carbon::now(),
        // ]);

        for ($i = 10000; $i < 100000; $i++) {
            DB::table('posts')->insert([
                'name' => 'Cùng khám phá vườn quốc gia Tam Đảodsf' . $i,
                'slug' => 'cung-kham-pha-vuon-quoc-gia-tam-dao2fds' . $i,
                'description' => 'Vườn quốc gia Tam Đảo là điểm du lịch yêu thích của những bạn trẻ ưa khám phá Tam Đảo. Còn gì tuyệt hơn việc cùng bạn bè,
                  người thân tận hưởng bầu không khí trong lành, khám phá rừng múi và chiêm ngưỡng
                  thảm thực vật phong phú của Việt Nam.',
                "content" => "'<div id=\"tab-62\" class=\"content-menu\">\r\n<h2>1. Tổng quan về vườn quốc gia
                 Tam Đảo</h2>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<div>Vườn quốc gia
                 Tam Đảo nằm trọn tr&ecirc;n d&atilde;y n&uacute;i Tam Đảo, d&agrave;i tr&ecirc;n 80km,
                  rộng 10km - 15km chạy theo hướng T&acirc;y Bắc - Đ&ocirc;ng Nam. Vườn trải rộng tr&ecirc;n
                   ba tỉnh Vĩnh Ph&uacute;c (huyện Tam Đảo), Th&aacute;i Nguy&ecirc;n (huyện Đại Từ) v&agrave;
                    Tuy&ecirc;n Quang (huyện Sơn Dương), c&aacute;ch H&agrave; Nội khoảng 75km về ph&iacute;a
                    Bắc.<br />&nbsp;</div>\r\n<div>Tổng diện t&iacute;ch Vườn quốc gia Tam Đảo l&agrave; 34.995ha,
                    ranh giới từ độ cao 100m trở l&ecirc;n so với mực nước biển, v&agrave; được chia th&agrave;nh 3
                     ph&acirc;n khu ch&iacute;nh: Ph&acirc;n khu bảo vệ nghi&ecirc;m ngặt (17.295ha), ph&acirc;n
                     khu phục hồi sinh th&aacute;i (15.398ha), ph&acirc;n khu h&agrave;nh ch&iacute;nh v&agrave;
                     dịch vụ du lịch (2.302ha).<br />&nbsp;</div>\r\n<div style=\"text-align: center;\"><img style=\"width: 800px;\" src=\"/upload/images/vuon-quoc-gia-tam-dao-vinh-phuc.jpg\" alt=\"\" /></div>\r\n<div><br />
                     Hệ thực vật đa dạng với nhiều chủng lo&agrave;i, trong đ&oacute; c&oacute; c&aacute;c lo&agrave;i
                     nổi bật như: lan h&agrave;i Tam Đảo, ho&agrave;ng thảo Tam Đảo, tr&agrave; hoa đỏ, tr&agrave; hoa
                     v&agrave;ng, tr&agrave; Camellia, đỗ quy&ecirc;n, lan Kim Tuyền, dẻ t&ugrave;ng sọc trắng, kim giao,
                     r&acirc;u h&ugrave;m, b&aacute;t gi&aacute;c li&ecirc;n, c&acirc;y bảy l&aacute; một hoa, c&acirc;y hoa
                     ti&ecirc;n, d&oacute; đất...<br />&nbsp;</div>\r\n<div style=\"text-align: center;\">
                     <img style=\"width: 800px;\" src=\"/upload/images/cay-muc.jpg\" alt=\"cầy mực tam đảo\" /><br />
                     <em>Cầy mực tại vườn quốc gia Tam Đảo</em></div>\r\n<div><br />Hệ động vật phong ph&uacute;, đ&ocirc;ng
                     đ&uacute;c l&agrave; lớp c&ocirc;n tr&ugrave;ng với 651 lo&agrave;i, v&agrave; lớp chim c&oacute; 239
                     lo&agrave;i... C&oacute; thể kể t&ecirc;n một số lo&agrave;i qu&yacute; hiếm như: bướm kiếm Tam Đảo, c
                     him h&uacute;t mật Tam Đảo, c&aacute; c&oacute;c Tam Đảo, rắn s&atilde;i, dơi l&aacute; mũi nhỏ, cầy
                     hương, s&oacute;c đen, khỉ mặt đỏ, culi nhỏ, gấu ngựa...<br />&nbsp;</div>\r\n<div style=\"text-align: center;\"><img style=\"width: 800px;\" src=\"/upload/images/chim-tri-do.jpg\" alt=\"chim trĩ đỏ\" /><br />
                     <em>Chim trĩ đỏ tại vườn quốc gia Tam Đảo</em></div>\r\n<p>&nbsp;</p>\r\n</div>'",
                "avatar_path" => '/storage/post/1/Y2gTU8aWL9NNIP8gHfXV.jpg',
                "description_seo" => 'Đây là description_seo',
                "title_seo" => 'Đây là titelseo',
                "view" => 1,
                "hot" => 1,
                "active" => 1,
                "category_id" => 9,
                "admin_id" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
