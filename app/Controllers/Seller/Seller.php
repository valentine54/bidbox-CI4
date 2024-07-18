<!-- Controllers/Seller.php -->
<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Seller extends BaseController
{
    public function products()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->where('seller_id', session()->get('seller_id'))->findAll();
        return view('seller_dashboard', $data);
    }

    public function addProduct()
    {
        $productModel = new ProductModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'current_price' => $this->request->getPost('current_price'),
            'product_image' => $this->request->getFile('product_image')->store(), // Handle file upload
            'seller_id' => session()->get('seller_id') // Assume seller_id is stored in session
        ];

        $productModel->save($data);
        return redirect()->to(base_url('seller/products'));
    }

    public function editProduct($productId)
    {
        // Fetch product details and show edit form
        $productModel = new ProductModel();
        $data['product'] = $productModel->find($productId);
        return view('edit_product', $data);
    }

    public function updateProduct($productId)
    {
        // Update product details
        $productModel = new ProductModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'current_price' => $this->request->getPost('current_price')
        ];

        // Handle file upload
        if ($this->request->getFile('product_image')->isValid()) {
            $data['product_image'] = $this->request->getFile('product_image')->store();
        }

        $productModel->update($productId, $data);
        return redirect()->to(base_url('seller/products'));
    }

    public function deleteProduct($productId)
    {
        $productModel = new ProductModel();
        $productModel->delete($productId);
        return redirect()->to(base_url('seller/products'));
    }

    public function searchProducts()
    {
        $query = $this->request->getGet('query');
        $productModel = new ProductModel();

        $data['products'] = $productModel->like('name', $query)
                                         ->where('seller_id', session()->get('seller_id'))
                                         ->findAll();
        return view('seller_dashboard', $data);
    }
    public function soldProducts()
    {
        $seller_id = session()->get('seller_id');

        // Assume you have a method to get all sold products for the seller.
        $productModel = new ProductModel();
        $bidModel = new BidModel();

        // Fetch products that have been sold (bidded and won)
        $soldProducts = $productModel->getSoldProductsBySeller($seller_id);

        return view('seller_sold_products', [
            'soldProducts' => $soldProducts
        ]);
    }
}
