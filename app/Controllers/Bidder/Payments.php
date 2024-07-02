// app/Controllers/PaymentController.php
<?php
namespace App\Controllers;

use App\Models\PaymentModel;
use CodeIgniter\Controller;

class Payment extends Controller
{
    public function index()
    {
        $paymentModel = new PaymentModel();
        $data['payments'] = $paymentModel->where('status', 'approved')->findAll();
        return view('payments/index', $data);
    }

    public function makePayment($id)
    {
        $paymentModel = new PaymentModel();
        $paymentModel->update($id, ['status' => 'paid']);
        return redirect()->to('/payment')->with('message', 'Thank you for your purchase');
    }
}
