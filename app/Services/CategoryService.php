<?php

namespace App\Services;

use App\Models\CategoryModel;

class CategoryService
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function getAll()
    {
        return $this->categoryModel->findAll();
    }

    public function create(array $data)
    {
        return $this->categoryModel->insert($data);
    }

    public function find($id)
    {
        return $this->categoryModel->find($id);
    }

    public function update($id, array $data)
    {
        return $this->categoryModel->update($id, $data);
    }

    public function delete($id)
    {
        $id = (int) $id;
    
        if (!$this->categoryModel->find($id)) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $this->categoryModel->delete($id);
    
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function getDatatables($request)
    {
        $builder = $this->categoryModel->select('id, name, status, updated_at');

        $searchValue = $request->getGet('search')['value'] ?? '';
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        $order = $request->getGet('order');
        $columns = ['id', 'name', 'status'];
        if (isset($order[0]['column']) && isset($columns[$order[0]['column']])) {
            $columnIndex = (int) $order[0]['column'];
            $dir = in_array(strtolower($order[0]['dir']), ['asc', 'desc']) ? $order[0]['dir'] : 'desc';
            $builder->orderBy($columns[$columnIndex], $dir);
        } else {
            // Default ordering by id DESC
            $builder->orderBy('updated_at', 'desc');
        }

        $length = $request->getGet('length') ?? 10;
        $start = $request->getGet('start') ?? 0;

        $data = $builder->findAll($length, $start);

        $total = $this->categoryModel->countAll();

        return [
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => array_map(function ($row) {
                $id = encryption($row['id']);
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'status' => $row['status'] ? 'Active' : 'Inactive',
                    'updated_at' => date('d-m-Y h.i A', strtotime($row['updated_at'])),
                    'action' => view('categories/_actions', ['id' => $id])
                ];
            }, $data),
        ];
    }
}
