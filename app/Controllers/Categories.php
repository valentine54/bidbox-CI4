<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class Categories extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        return view('categories', ['categories' => $categories]);
    }

    public function viewProducts()
    {
        $category_id = $this->request->getPost('category_id');
        $productModel = new ProductModel();
        $products = $productModel->getProductsByCategory($category_id);

        $categories = (new CategoryModel())->findAll();

        return view('categories', ['categories' => $categories, 'products' => $products]);
    }
}
