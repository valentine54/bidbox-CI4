<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    public function index($category_id = 'all')
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        if ($category_id == 'all') {
            $products = $productModel->findAll();
        } else {
            $products = $productModel->where('category_id', $category_id)->findAll();
        }

        $categories = $categoryModel->findAll();

        return view('home', [
            'products' => $products,
            'categories' => $categories,
            'current_category' => $category_id
        ]);
    }
}


