<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Models\M3Result;

class BookController extends Controller
{
   public function getCategoryByParentId($parent_id){
   	
   	$categorys = Category::where('parent_id', $parent_id)->get();
   	// 返回的结果自动转换为json数据,但是ajax用的是自定义的模版所以还的用tojson返回
   	 $m3_result = new M3Result;
   	 $m3_result->status = 0;
   	 $m3_result->message = '返回成功';
   	 $m3_result->categorys = $categorys;

   	
    return $m3_result->toJson();
   }


}
