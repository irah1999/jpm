<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\RequestInterface;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        helper('call_helper'); // for app/Helpers/my_helper.php
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Product list page
    public function index()
    {
        return view('products/index');
    }

    // DataTables ajax
    public function getProducts()
    {
        $request = service('request');
        $postData = $request->getPost();

        $products = $this->productModel->getDatatables($postData);
        return $this->response->setJSON($products);
    }

    // Show create form
    public function create()
    {
        $data['categories'] = $this->categoryModel->where('status', 1)->findAll();

        return view('products/create', $data);
    }

    // Save new product
    public function store()
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|decimal',
            'category_id' => [
                'label' => 'Category',
                'rules' => 'required|integer|is_not_unique[categories.id]',
                'errors' => [
                    'is_not_unique' => 'Selected category does not exist.',
                ]
            ],
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]', // 2MB max
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', implode(', ', $this->validator->getErrors()));
        }

        $imageName = null;
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/', $imageName);

            // Resize using CodeIgniter Image Manipulation
            \Config\Services::image()
                ->withFile('uploads/' . $imageName)
                ->resize(500, 500, true, 'width')
                ->save('uploads/' . $imageName);
        }

        $this->productModel->save([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
            'image'       => $imageName,
        ]);

        return redirect()->to(route_to('products.index'))->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $id = decryption($id);
        
        $data['product'] = $this->productModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();

        if (!$data['product']) {
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }
        // echo "<pre>";
        // print_r($data);die;
        return view('products/edit', $data);
    }

    // Update product
    public function update()
    {
        try {

            $id = $this->request->getPost('id');
    
            $id = decryption($id);
            $product = $this->productModel->find($id);
            if (!$product) {
                return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
            }
    
            $rules = [
                'name'        => 'required',
                'description' => 'required',
                'price'       => 'required|decimal',
                'category_id' => [
                    'label' => 'Category',
                    'rules' => 'required|integer|is_not_unique[categories.id]',
                    'errors' => [
                        'is_not_unique' => 'Selected category does not exist.',
                    ]
                ],
                'image'       => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]', // 2MB max
            ];
    
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', implode(', ', $this->validator->getErrors()));
            }
    
            $imageName = $product['image'];
            $imageFile = $this->request->getFile('image');
    
            if ($imageFile && $imageFile->isValid()) {
                $imageName = $imageFile->getRandomName();
                $imageFile->move('uploads/', $imageName);
    
                \Config\Services::image()
                    ->withFile('uploads/' . $imageName)
                    ->resize(500, 500, true, 'width')
                    ->save('uploads/' . $imageName);
    
                // Delete old image
                if (file_exists('uploads/' . $product['image'])) {
                    unlink('uploads/' . $product['image']);
                }
            }
    
            $this->productModel->update($id, [
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price'       => $this->request->getPost('price'),
                'category_id' => $this->request->getPost('category_id'),
                'image'       => $imageName,
            ]);
    
            return redirect()->to(route_to('products.index'))->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->to(route_to('products.index'))->with('error', $e->getMessage());
        }
    }

    // Delete product
    public function delete()
    {
        $id = $this->request->getPost('id');
        $id = decryption($id);
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }

        if ($product['image'] && file_exists('uploads/' . $product['image'])) {
            unlink('uploads/' . $product['image']);
        }

        $this->productModel->delete($id);

        return redirect()->to(route_to('products.index'))->with('success', 'Product deleted successfully!');
    }


    public function datatables()
    {
        $request = service('request');
        $productModel = new ProductModel();
        $data = $productModel->getDatatables($request);
    
        return $this->response->setJSON([
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $data['totalRecords'],
            'recordsFiltered' => $data['totalRecords'],
            'data' => $data['data'],
        ]);
    }

}
