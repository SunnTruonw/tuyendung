<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ExcelExportsDatabaseProduct implements FromArray, WithHeadings,  WithStyles, WithColumnWidths, WithColumnFormatting
{
    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    private $start;
    private $end;
    private $data;
    public function __construct($data)
    {

        $nameModel = '\App\Models\Product';
        $this->model = new $nameModel;
        $this->selectField = "*";
        $this->title = true;
        $this->data = $data;
        $this->titleField = [
            "id" => "STT",
            "masp" => "Số khung/Biển số",
            "name_chunha" =>  "Họ và tên",
            "phone_chunha" => "Số điện thoại",
            "donvithicong" => "Đơn vị thi công",
            "type_car" => "Dòng xe",
            "service_pack" => "Gói dịch vụ",
            "info_pack" => "Thông tin gói",
            "time_buy" => "Ngày mua",
            'time_expires' => "Ngày hêt bảo hành",
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 35,
            'F' => 30,
            'G' => 25,
            'H' => 50,
            'I' => 25,
            'J' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '0.00',
        ];
    }


    public function array(): array
    {
        $data = [];
        if ($this->data->count() > 0) {
            foreach ($this->data as $key => $value) {

                // tên gói
                $service_pack = [];
                if (isset($value->attributes)) {
                    foreach ($value->attributes as $w) {
                        $service_pack[] = $w->name;
                    }
                }
                $value->service_pack = !empty($service_pack) ? implode(", ", $service_pack) : '';

                //info gói
                $info_pack = [];
                if (isset($value->attributeChilds)) {
                    foreach ($value->attributeChilds as $w) {
                        $info_pack[] = $w->name;
                    }
                }
                $value->info_pack = !empty($info_pack) ? implode(", ", $info_pack) : '';

                $item = [];
                $item['id'] = $key + 1;
                $item['masp'] = !empty($value->masp) ? $value->masp : '';
                $item['name_chunha'] = !empty($value->name_chunha) ? $value->name_chunha : '';
                $item['phone_chunha'] = !empty($value->phone_chunha) ? $value->phone_chunha : '';
                $item['donvithicong'] = !empty($value->city) ? $value->donvithicong . ',' . optional($value->city)->name : $value->donvithicong;
                $item['type_car'] = !empty($value->attributes) ? $value->type_car : '';

                $item['service_pack'] = $value->service_pack ?? '';
                $item['info_pack'] = $value->info_pack ?? '';


                $item['time_buy'] = !empty($value->time_buy) ? $value->time_buy : '';
                $item['time_expires'] = !empty($value->time_expires) ? $value->time_expires : '';

                array_push($data, $item);
            }
        }
        return $data;
    }

    // add title for file export
    public function headings(): array
    {
        if ($this->title) {
            return $this->titleField;
        } else {
            return [];
        }
    }
}
