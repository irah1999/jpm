<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name', 'description', 'price', 'category_id', 'image'
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
                ->groupEnd();
        }
    
        // Total count
        $totalRecords = $builder->countAllResults(false);
    
        // Order
        $order = $request->getGet('order')[0];
        $columns = ['products.id', 'products.name', 'categories.name', 'products.price', 'products.description', 'products.image'];
        $builder->orderBy($columns[$order['column']], $order['dir']);
    
        // Limit and Offset
        $length = (int) $request->getGet('length');
        $start = (int) $request->getGet('start');
        $builder->limit($length, $start);
    
        // Get paginated data
        $data = $builder->get()->getResultArray();

        foreach ($data as &$row) {
            $encryptedId = encryption($row['id']);

            $editUrl = route_to('products.edit', $encryptedId);
            $deleteUrl = route_to('products.delete');
        
            $row['action'] = '
                <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                <form action="'.$deleteUrl.'" method="post" class="d-inline">
                    <input type="hidden" name="id" value="'.$encryptedId.'">
                    <input type="hidden" name="' . csrf_token() . '" value="' . csrf_hash() . '">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            ';
        }
    
        return [
            'totalRecords' => $totalRecords,
            'data' => $data,
        ];
    }
}
