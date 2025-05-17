<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brands\StoreBrandRequest;
use App\Http\Requests\Brands\UpdateBrandRequest;
use App\Models\Brand;
use App\Traits\GetResponseJson;
use App\Traits\Media;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use GetResponseJson, Media;

    // store Brand
    public function store(StoreBrandRequest $request)
    {
      
        $data = $request->except('logo');
        $logoName = $this->uploadPhoto($request->logo, 'images/brands');
        $data['logo'] = $logoName;
        $brand=Brand::create($data);
        return $this->setData([$brand], 'The Brand is Created', 201);
    }

    // Brands
    public function index()
    {
        $brands = Brand::with('products')->get();
        if (empty($brands->toArray())) {
            return $this->setErrorMessage('Brands Not Fount', [], 404);
        }
        return $this->setData($brands, 'Success');
    }


    // show Brand
    public function show($brand)
    {
        $brand = Brand::with('products')->find($brand);
        if (!$brand) {
            return $this->setErrorMessage('The Brand Not Fount', [], 404);
        }

        
        return $this->setData($brand, 'Success');
    }


    // Edit Brand
    public function edit($brand)
    {
        $brand = Brand::find($brand);
        if (!$brand) {
            return $this->setErrorMessage('The Brand Not Fount', [], 404);
        }
        return $this->setData($brand, 'Success');
    }


    // Update Brands
    public function update(UpdateBrandRequest $request, $brand)
    {

        $brand = Brand::find($brand);
        // Check brand
        if (!$brand) {
            return $this->setErrorMessage('The Brand Not Fount', [], 404);
        }
        // Update Photo
        if ($request->hasFile('logo')) {

            //delete Brand logo 
            $this->deletePhoto($brand->logo);

            $logoName = $this->uploadPhoto($request->logo, 'images/brands');
            $brand->logo = $logoName;
        }
        // update brand
        $brand->name = $request->name;
        $brand->save();

        return $this->setData($brand, 'the Brand is Updated');
    }

    // delete Category
    public function destroy($brand)
    {
        $brand = Brand::find($brand);
        // Check brand
        if (!$brand) {
            return $this->setErrorMessage('The brand Not Fount', [], 404);
        }
        // delete brand
        $brand->delete();
        return $this->setSuccessMessage('the brand is Deleted');
    }
}
