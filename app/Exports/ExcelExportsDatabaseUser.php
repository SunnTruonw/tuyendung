<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExcelExportsDatabaseUser implements FromArray,WithHeadings
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

        $nameModel ='\App\Models\User';
        $this->model= new $nameModel;
        $this->selectField="*";
        $this->title=true;
        $this->data=$data;
        $this->titleField= [
            "id" => "ID",
            "username"=>  "Tài khoản",
            "name" => "Họ tên",
            "phone"=> "Số điện thoại",
            "email"=> "Email",
            "type"=> "Loại tài khoản",
            'city_id'=>"Thành phố",
            'district_id'=>"Quận huyện",
            'tai_chinh'=>"Tài chính",
        ];
    }
    public function array(): array
    {
        $data=[];
       // dd($this->start,$this->end);
       // $pay=$this->model->whereBetween('created_at',[$this->start,$this->end])->where(['status'=>1])->select($this->selectField)->get();
       if($this->data->count()>0){
        foreach ($this->data as $value) {
            $item=[];
            $item['id']=$value->id;
            $item['username']=$value->username?$value->username:'Chưa cập nhập';
            $item['name']=$value->name?$value->name:'Chưa cập nhập';
            $item['phone']=$value->phone?$value->phone:'Chưa cập nhập';
            $item['email']=$value->email?$value->email:'Chưa cập nhập';
            if($value->type==4){
                $item['type']='Nhân viên công ty';
            }else if($value->type==1||$value->type==2||$value->type==3){
                $item['type']=config('web_default.typeUser')[$value->type]['name'];
            }else{
                $item['type']='Chưa cập nhập';
            }

            if($value->type==1){
                $item['city_id']=optional($value->city)->name?optional($value->city)->name:'Chưa cập nhập';
                $item['district_id']=optional($value->district)->name?optional($value->district)->name:'Chưa cập nhập';
                $item['tai_chinh']=$value->tai_chinh?$value->tai_chinh:'Chưa cập nhập';
            }
            array_push($data,$item);
        }
       }

       // dd($data);
        return $data;
    }
    // add title for file export
     public function headings(): array
     {
         if($this->title){
             return $this->titleField;
         }
         else{
             return [];
         }
     }
}
