<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name', 'description', 'price', 'category_id', 'image', 'status'
    ];
    protected $useTimestamps    = true;

    // For DataTables (optional: you can remove if not using)
    public function getDatatables($request)
    {
        helper('call_helper');
        $builder = $this->table('products')
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');
    
        // Search
        $search = $request->getGet('search')['value'] ?? '';
        if (!empty($search)) {
            $builder->groupStart()
                ->like('products.name', $search)
                ->orLike('categories.name', $search)
                ->orLike('products.price', $search)
                ->orLike('products.description', $search)
                ->groupEnd();
        }
    
        // Total count
        $totalRecords = $builder->countAllResults(false);
    
        // Order
        $order = $request->getGet('order');
        $columns = ['products.id', 'products.name', 'categories.name', 'products.price', 'products.description', 'products.image', 'products.updated_at'];
        if (isset($order[0]['column']) && isset($columns[$order[0]['column']])) {
            $columnIndex = (int) $order[0]['column'];
            $dir = in_array(strtolower($order[0]['dir']), ['asc', 'desc']) ? $order[0]['dir'] : 'desc';
            $builder->orderBy($columns[$columnIndex], $dir);
        } else {
            // Default ordering by id DESC
            $builder->orderBy('products.updated_at', 'desc');
        }
    
        // Limit and Offset
        $length = (int) $request->getGet('length');
        $start = (int) $request->getGet('start');
        $builder->limit($length, $start);
    
        // Get paginated data
        $data = $builder->get()->getResultArray();

        foreach ($data as &$row) {
            $encryptedId = encryption($row['id']);
            
            $row['status'] = $row['status'] ? 'Active' : 'Inactive';
            $row['updated_at'] = date('d-m-Y h.i A', strtotime($row['updated_at']));

            $editUrl = route_to('products.edit', $encryptedId);
            $deleteUrl = route_to('products.delete');
        
            $row['action'] = '
                <a href="'.$editUrl.'" class="btn btn-sm btn-warning mb-2">Edit</a>
                <form action="'.$deleteUrl.'" method="post" class="d-inline">
                    <input type="hidden" name="id" value="'.$encryptedId.'">
                    <input type="hidden" name="' . csrf_token() . '" value="' . csrf_hash() . '">
                    <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            ';
        }
    
        return [
            'totalRecords' => $totalRecords,
            'data' => $data,
        ];
    }
}
