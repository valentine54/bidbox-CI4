<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'products';

    public function getTotalProducts()
    {
        return $this->db->table('products')->countAll();
    }

    public function getTotalCategories()
    {
        return $this->db->table('categories')->countAll();
    }

    public function getCategoriesWithBids()
    {
        $query = $this->db->query("
            SELECT c.name AS category_name, COUNT(b.id) AS bids_count 
            FROM categories c
            JOIN products p ON c.id = p.category_id
            JOIN bids b ON p.id = b.product_id
            GROUP BY c.name
        ");
        return $query->getResultArray();
    }
}
