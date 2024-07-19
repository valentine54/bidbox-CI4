<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class ProductBids extends Controller
{
    public function index()
    {
        $searchModel = $this->request->getVar('search');

        $productModel = new ProductModel();
        $products = $productModel->getProductsWithApprovedBids($searchModel);

        $data['products'] = $products;

        return view('product_bids', $data);
    }
}
