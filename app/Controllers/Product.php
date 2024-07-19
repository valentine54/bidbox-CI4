<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary models and libraries
        $this->load->model('Product_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        // Fetch all products
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('products/index', $data);
    }

    public function create() {
        // Form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            // If validation fails, load the form again with validation errors
            $this->load->view('products/create');
        } else {
            // If validation passes, insert the product into the database
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price')
                // Add more fields as needed
            );

            // Insert product
            $this->Product_model->insert_product($data);

            // Redirect to product listing page
            redirect('product/index');
        }
    }

    public function edit($id) {
        // Fetch product details
        $data['product'] = $this->Product_model->get_product_by_id($id);

        if (empty($data['product'])) {
            show_404(); // Product not found
        }

        // Form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            // If validation fails, load the edit form with existing data
            $this->load->view('products/edit', $data);
        } else {
            // If validation passes, update the product in the database
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price')
                // Add more fields as needed
            );

            // Update product
            $this->Product_model->update_product($id, $data);

            // Redirect to product listing page
            redirect('product/index');
        }
    }

    public function delete($id) {
        // Delete product
        $this->ProductModel->delete_product($id);

        // Redirect to product listing page
        redirect('product/index');
    }

}
?>
