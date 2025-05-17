<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Traits\GetResponseJson;
use App\Traits\Media;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use Media,GetResponseJson;

    // Store Product
    public function store(ProductRequest $request)
    {
        $photoName=$this->uploadPhoto($request->image,'images/products');
        $data=$request->except('image');
        $data['image'] = $photoName;
        Product::create($data);
        
        return $this->setData($data, 'Success', 201);
    }

    // All Products
    public function index(){
        $products = Product::with('brand','subcategory')->get();

        if(empty($products)){
            return $this->setErrorMessage('Products are Empty. You must add Products');
        }

        return $this->setData($products,'Success');
    }


    // show Product
    public function show($product){

        $product= Product::with('brand','subcategory')->find($product);
        if(!$product){
            return $this->setErrorMessage('Product Not found.');
        }

        return $this->setData($product,'Success');
    }


     // edit Product
     public function edit($product){

        $product= Product::find($product);
        if(!$product){
            return $this->setErrorMessage('Product Not found.');
        }
        return $this->setData($product,'Success');
    }


    // update Product
    public function update(UpdateProductRequest $request ,$product){
        $product= Product::find($product);
        if(!$product){
            return $this->setErrorMessage('Product Not found.');
        }
        
        $data = $request->except('image');
        if($request->hasFile('image')){
           
            //delete Product image
            $this->deletePhoto(($product->image));
            
            //save new image
            $image = $this->uploadPhoto($request->image,'images/products');
            $data['image']= $image;
        }
        $product->update($data);
        return $this->setSuccessMessage('the Product Updated',$product);
    }

    
    // delete
    public function destroy($product){

        $product= Product::find($product);
        if(!$product){
            return $this->setErrorMessage('Product Not found.');
        }
        
        $product->delete();
        return $this->setSuccessMessage('the Product Deleted');

    }
}
