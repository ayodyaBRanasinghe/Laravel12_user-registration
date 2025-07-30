<?php

namespace App\Services;
use App\Repositories\ProductRepository;


class ProductService {

    protected $productRepository;
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data){

        $product =  $this->productRepository->create($data);

        return $product;
    }
}