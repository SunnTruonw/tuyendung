<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Components\Recusive;
/**
 *
 */
trait DeleteRecordTrait
{
    public function deleteTrait($model, $id)
    {
        try {
            $model->find($id)->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function deleteCategoryRecusiveTrait($model,$id){

        try {
            $recusive= new Recusive();
            $data=$model->get();
            $arrId= $recusive->categoryRecusiveAllChild($data,$id);
            array_push($arrId,$id);
            $model->destroy($arrId);
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
