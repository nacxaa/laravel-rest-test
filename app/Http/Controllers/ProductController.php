<?php

namespace App\Http\Controllers;
use App\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productType' => 'required',
            'size' => 'required',
            'color' => 'required',
            'title' => 'required',
            'price' => 'required',
        ]);

        $validator->after(function($validator) use ($request) {
            if (Product::where('size', $request->size)->where('productType', $request->productType)->where('color', $request->color)->get()->count()) {
                $validator->errors()->add('size+color+type', 'Product with such size, color and type already exists');
            }
          });

        $validator->validate();

        $prod = Product::create($request->all());

        return ''; // $prod
    }
}