<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GetResponseJson;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use GetResponseJson;

    // store Category
    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => 'string|required|unique:categories|max:100|min:2'
        ]);
        Category::create($category);
        return $this->setData($category, 'The category id Created', 201);
    }


    // Categories
    public function index()
    {
        $categories = Category::with('subcategories')->get();

        if (empty($categories->toArray())) {
            return $this->setErrorMessage('Categories Not Fount', [], 404);
        }
        return $this->setData($categories, 'All categories');
    }


    // Show Category
    public function show($category)
    {
        $category = Category::with('subcategories')->find($category);
        if (!$category) {
            return $this->setErrorMessage('The category Not Fount', [], 404);
        }
        
        return $this->setData($category, 'Success');
    }

    // Edit Category
    public function edit($category)
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->setErrorMessage('The category Not Fount', [], 404);
        }
        return $this->setData($category, 'Success');
    }


    // Update Category
    public function update(Request $request, $category)
    {
        $request->validate([
            'name' => 'string|required|max:100|min:2|unique:categories',
        ]);

        $category = Category::find($category);
        // Check Category
        if (!$category) {
            return $this->setErrorMessage('The Category Not Fount', [], 404);
        }
        // update Category
        $category->name = $request->name;
        $category->save();

        return $this->setData($category, 'All categories');
    }


    // delete Category
    public function destroy($category)
    {
        $category = Category::find($category);
        // Check Category
        if (!$category) {
            return $this->setErrorMessage('The Category Not Fount', [], 404);
        }
        // delete Category
        $category->delete();
        return $this->setSuccessMessage('the Category is Deleted');
    }

   
}
