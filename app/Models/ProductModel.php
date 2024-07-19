<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    public function getProductsByCategory($category_id)
    {
        return $this->where('category_id', $category_id)->findAll();
    }
    public function get_all_products() {
        return $this->findAll();
    }

    public function get_product_by_id($id) {
        return $this->find($id);
    }

    public function insert_product($data) {
        return $this->insert($data);
    }

    public function update_product($id, $data) {
        return $this->update($id, $data);
    }

    public function delete_product($id) {
        return $this->delete($id);
    }

    public function getProductsWithApprovedBids($searchTerm = '')
    {
        $builder = $this->db->table('products p');
        $builder->select('p.id AS product_id, p.name AS product_name, p.description AS product_description, p.minimum_price AS minimum_price, p.picture AS product_picture, b.id AS bid_id, b.amount AS bid_amount, b.status AS bid_status');
        $builder->join('bids b', 'p.id = b.product_id');
        $builder->where('b.status', 'approved');

        if (!empty($searchTerm)) {
            $builder->like('p.name', $searchTerm);
            $builder->orLike('p.description', $searchTerm);
        }

        return $builder->get()->getResultArray();
    }

}
