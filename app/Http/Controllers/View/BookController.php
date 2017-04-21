<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use Illuminate\http\Request;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\PdtImages;

class BookController extends Controller
{
   public function toCategory($value=''){
   	// whereNull查询给定列的值为null,即查询以及类别
   	$categorys = Category::whereNull('parent_id')->get();
   	//var_dump($categorys);
    return view('category')->with('categorys', $categorys);
   }

   public function toProduct($category_id){
   	
   	$products = Product::where('category_id', $category_id)->get();
    return view('product')->with('products', $products);
   }

    public function toPdtContent(Request $request , $product_id){
   	
   	$product = Product::find($product_id);
   	$pdt_content = PdtContent::where('product_id', $product_id)->first();
   	$pdt_images = PdtImages::where('product_id', $product_id)->get();

    // cookie里是否有购物车的信息(取出cookie)
    $bk_cart = $request->cookie('bk_cart');
    //return $bk_cart;
    // 判断是否有cookies,如果有把字符串转化为数组
    $bk_cart_arr = ($bk_cart != null? explode(',', $bk_cart) : array());

    $count = 0;
    // 循环购物车数组
    foreach ($bk_cart_arr as $value) { // 更改里面的元素,基本类型必须用引用,对象就不用
      // 分拆键值对
      $index = strpos($value, ':');
      if(substr($value, 0 , $index) == $product_id){
        $count = ((int)substr($value, $index+1));
        break;
      }
    }


    return view('pdt_content')->with('product', $product)
    						  ->with('pdt_content', $pdt_content)
                  ->with('pdt_images', $pdt_images)
    						  ->with('count', $count);
   }

}
