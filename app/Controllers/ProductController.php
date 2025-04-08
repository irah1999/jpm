<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Services\ProductService;

class ProductController extends BaseController
{
    protected $productService;

    public function __construct()
    {
        helper('call_helper');
        $this->productService = new ProductService(new ProductModel(), new CategoryModel());
    }

    public function index()
    {
        return view('products/index');
    }

    public function getProducts()
    {
        $postData = $this->request->getPost();
        $products = $this->productService->getDatatables($postData);
        return $this->response->setJSON($products);
    }

    public function create()
    {
        $data['categories'] = $this->productService->getCategories();
        return view('products/create', $data);
    }

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
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', implode(', ', $this->validator->getErrors()));
        }

        $data = $this->request->getPost();
        $image = $this->request->getFile('image');

        $this->productService->saveProduct($data, $image);

        return redirect()->to(route_to('products.index'))->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $id = decryption($id);
        $product = $this->productService->findProduct($id);

        if (!$product) {
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }

        $data = [
            'product' => $product,
            'categories' => $this->productService->getCategories(),
        ];

        return view('products/edit', $data);
    }

    public function update()
    {
        try {
            $id = decryption($this->request->getPost('id'));
    
            $rules = [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|decimal',
                'status' => 'required|in_list[0,1]',
                'category_id' => [
                    'label' => 'Category',
                    'rules' => 'required|integer|is_not_unique[categories.id]',
                    'errors' => [
                        'is_not_unique' => 'Selected category does not exist.',
                    ]
                ],
            ];
    
            // Only validate image if a file is uploaded
            $image = $this->request->getFile('image');
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $rules['image'] = 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]';
            }
    
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', implode(', ', $this->validator->getErrors()));
            }
    
            $data = $this->request->getPost();
    
            $this->productService->updateProduct($id, $data, $image);
    
            return redirect()->to(route_to('products.index'))->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->to(route_to('products.index'))->with('error', $e->getMessage());
        }
    }
    

    public function delete()
    {
        $id = decryption($this->request->getPost('id'));

        if (!$this->productService->deleteProduct($id)) {
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }

        return redirect()->to(route_to('products.index'))->with('success', 'Product deleted successfully!');
    }

    public function datatables()
    {
        $request = service('request');
        $data = $this->productService->getDatatables($request);

        return $this->response->setJSON([
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $data['totalRecords'],
            'recordsFiltered' => $data['totalRecords'],
            'data' => $data['data'],
        ]);
    }
}
