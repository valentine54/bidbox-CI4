<?php

namespace App\Controllers;

use App\Models\CartModel;

class Cart extends BaseController
{
    public function addToCart()
    {
        $cartModel = new CartModel();
        $data = [
            'bidder_id' => session()->get('bidder_id'),
            'product_id' => $this->request->getPost('product_id')
        ];
        $cartModel->save($data);

        $cartCount = $cartModel->where('bidder_id', session()->get('bidder_id'))->countAllResults();
        session()->set('cart_count', $cartCount);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Product added to cart.', 'cart_count' => $cartCount]);
    }

    public function viewCart()
    {
        $cartModel = new CartModel();
        $data['products'] = $cartModel->select('products.*')
            ->join('products', 'products.id = cart.product_id')
            ->where('cart.bidder_id', session()->get('bidder_id'))
            ->findAll();

        return view('cart', $data);
    }
}
