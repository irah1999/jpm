<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        return view('categories/index');
    }

    public function datatables()
    {
        $request = service('request');
        $data = $this->categoryService->getDatatables($request);

        return $this->response->setJSON($data);
    }

    public function create()
    {
        return view('categories/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'status' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(', ', $this->validator->getErrors()));
        }

        $this->categoryService->create($this->request->getPost());

        return redirect()->to(route_to('categories.index'))->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $id = decryption($id);
        $category = $this->categoryService->find($id);
        if (!$category) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Category not found');
        }

        return view('categories/edit', compact('category'));
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required',
            'status' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(', ', $this->validator->getErrors()));
        }

        $this->categoryService->update($id, $this->request->getPost());

        return redirect()->to(route_to('categories.index'))->with('success', 'Category updated successfully!');
    }

    public function delete()
    {
        $id     = $this->request->getPost('id');
        return $this->categoryService->delete(decryption($id));
    }
}
