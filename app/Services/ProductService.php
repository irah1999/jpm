<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class ProductService
{
    protected $productModel;
    protected $categoryModel;

    public function __construct(ProductModel $productModel, CategoryModel $categoryModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    public function getCategories()
    {
        return $this->categoryModel->where('status', 1)->findAll();
    }

    public function saveProduct(array $data, ?UploadedFile $imageFile = null): bool
    {
        $imageName = null;

        if ($imageFile && $imageFile->isValid()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/', $imageName);

            \Config\Services::image()
                ->withFile('uploads/' . $imageName)
                ->resize(500, 500, true, 'width')
                ->save('uploads/' . $imageName);
        }

        $data['image'] = $imageName;

        return $this->productModel->save($data);
    }

    public function updateProduct($id, array $data, ?UploadedFile $imageFile = null): bool
    {
        $product = $this->productModel->find($id);
        if (!$product) return false;

        $imageName = $product['image'];

        if ($imageFile && $imageFile->isValid()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/', $imageName);

            \Config\Services::image()
                ->withFile('uploads/' . $imageName)
                ->resize(500, 500, true, 'width')
                ->save('uploads/' . $imageName);

            if (file_exists('uploads/' . $product['image'])) {
                unlink('uploads/' . $product['image']);
            }
        }

        $data['image'] = $imageName;

        return $this->productModel->update($id, $data);
    }

    public function deleteProduct($id): bool
    {
        $product = $this->productModel->find($id);
        if (!$product) return false;

        if ($product['image'] && file_exists('uploads/' . $product['image'])) {
            unlink('uploads/' . $product['image']);
        }

        return $this->productModel->delete($id);
    }

    public function getDatatables($postData)
    {
        return $this->productModel->getDatatables($postData);
    }

    public function findProduct($id)
    {
        return $this->productModel->find($id);
    }
}
