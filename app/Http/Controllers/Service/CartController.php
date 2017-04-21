<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;
use Illuminate\http\Request;
use App\Models\M3Result;

class CartController extends Controller
{
   public function addCart(Request $request , $product_id){
   	// cookie里是否有购物车的信息(取出cookie)
   	$bk_cart = $request->cookie('bk_cart');
   	//return $bk_cart;
   	// 判断是否有cookies,如果有把字符串转化为数组
   	$bk_cart_arr = ($bk_cart != null? explode(',', $bk_cart) : array());

   	$count = 1;
   	// 循环购物车数组
   	foreach ($bk_cart_arr as &$value) { // 更改里面的元素,基本类型必须用引用,对象就不用
   		// 分拆键值对
   		$index = strpos($value, ':');
   		if(substr($value, 0 , $index) == $product_id){
   			$count = ((int)substr($value, $index+1))+1;
   			$value = $product_id . ":" . $count;
   			break;
   		}
   	}

   	if ($count ==1) {
   		array_push($bk_cart_arr, $product_id . ':' . $count);
   	}

   	$m3_result = new M3Result;
   	$m3_result->status = 0;
   	$m3_result->message = '添加成功';
   	
    return response($m3_result->toJson())->withCookie('bk_cart',implode(',', $bk_cart_arr));

   }


}
