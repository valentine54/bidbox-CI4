// app/Controllers/ProductController.php
<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BidModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        return view('products/index', $data);
    }

    public function bid($id)
    {
        $productModel = new ProductModel();
        $data['product'] = $productModel->find($id);
        return view('products/bid', $data);
    }

    public function placeBid()
    {
        $bidModel = new BidModel();
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'bidder_id' => $this->request->getPost('bidder_id'),
            'amount' => $this->request->getPost('amount'),
            'status' => 'awaiting approval'
        ];
        $bidModel->save($data);
        return redirect()->to('/product/bid/' . $data['product_id'])->with('message', 'Bid placed successfully');
    }
}
