<?php

namespace App\Http\Controllers\Subcategories;

use App\Http\Controllers\Controller;

use App\Http\Requests\Subcategories\StoreSubcategoryRequest;
use App\Http\Requests\Subcategories\UpdateSubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\GetResponseJson;


class SubcategoryController extends Controller
{
    use GetResponseJson;

    // store Category
    public function store(StoreSubcategoryRequest $request)
    {

        $subcategory=Subcategory::create($request->all());
        return $this->setData($subcategory, 'The Subcategory id Created', 201);
    }

    // subcategories
    public function index()
    {
        $subcategories = Subcategory::with('products','category')->get();

        if (empty($subcategories->toArray())) {
            return $this->setErrorMessage('Subcategories Not Fount', [], 404);
        }
        return $this->setData($subcategories, 'All subcategories');
    }


    // show subcategories
    public function show($subcategory)
    {
        $subcategory = Subcategory::with('products','category')->find($subcategory);
        if (!$subcategory) {
            return $this->setErrorMessage('The Subcategory Not Fount', [], 404);
        }


        return $this->setData(compact('subcategory'), 'Success');
    }


    // Edit subcategories
    public function edit($subcategory)
    {
        $subcategory = Subcategory::find($subcategory);
        $categories = Category::all();
        if (!$subcategory) {
            return $this->setErrorMessage('The Subcategory Not Fount', [], 404);
        }
        return $this->setData(compact('subcategory', 'categories'), 'Success');
    }



    // Update Category
    public function update(UpdateSubcategoryRequest $request, $subcategory)
    {
       
        $subcategory = Subcategory::find($subcategory);
        // Check Category
        if (!$subcategory) {
            return $this->setErrorMessage('The Subcategory Not Fount', [], 404);
        }
        // update subcategory
        $subcategory->name = $request->name;
        $subcategory->save();

        return $this->setData($subcategory, 'the Scategories is Updated');
    }



    // delete Category
    public function destroy($subcategory)
    {
        $subcategory = Subcategory::find($subcategory);
        // Check subcategory
        if (!$subcategory) {
            return $this->setErrorMessage('The Subcategory Not Fount', [], 404);
        }
        // delete subcategory
        $subcategory->delete();
        return $this->setSuccessMessage('the Subcategory is Deleted');
    }
}
