<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportsDatabase implements ToModel, WithHeadingRow
{
    // set the preferred date format
    private $date_format = 'd-m-Y';

    // set the columns to be formatted as dates
    private $date_columns = ['ngay_bat_dau', 'ngay_ket_thuc'];

    // bind date formats to column defined above
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), $this->date_columns)) {
            $cell->setValueExplicit(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format($this->date_format), DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function model(array $row)
    {
        return new Product([
            "masp" => $row['so_khung'] ?? '',
            "type_car" => $row['loai_xe'] ?? '',
            "name_chunha" =>  $row['ten'] ?? '',
            "phone_chunha" => $row['dien_thoai'] ?? '',
            "donvithicong" => $row['dia_chi'] ?? '',
            "content" => $row['noi_dung'] ?? '',
            "time_buy" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['ngay_bat_dau']))->format('d/m/Y') ?? '',
            'time_expires' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['ngay_ket_thuc']))->format('d/m/Y') ?? '',
            'remaining_time' => $row['thoi_gian_con_lai'] ?? '',
        ]);

        // dd($data);
    }
}
