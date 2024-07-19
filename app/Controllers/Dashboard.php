<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $dashboardModel = new DashboardModel();

        $data = [
            'totalProducts' => $dashboardModel->getTotalProducts(),
            'totalCategories' => $dashboardModel->getTotalCategories(),
            'categoriesWithBids' => $dashboardModel->getCategoriesWithBids()
        ];

        return view('dashboard', $data);
    }
}
