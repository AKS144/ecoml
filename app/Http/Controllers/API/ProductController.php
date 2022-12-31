<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',
            'meta_title' => 'required:max:191',
            'brand' => 'required|max:20',
            'selling_price'=> 'required|max:20',
            'original_price'=> 'required|max:20',
            'quantity' => 'required|max:20',
            'image'=> 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' =>422,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->slug = $request->slug;
            $product->name = $request->name;
            $product->description = $request->description;

            $product->meta_title = $request->meta_title;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_desc = $request->meta_desc;

            $product->brand = $request->brand;
            $product->selling_price = $request->selling_price;
            $product->original_price = $request->original_price;
            $product->quantity = $request->quantity;

            // if($request->hasFile('image'))
            // {
            //     $file = $request->file('image');
            //     $extension = $file->getClientOriginalExtension();
            //     $filename = time().'.'.$extension;
            //     $file->move('uploads/product/',$filename);                             
            // }

            if($request->hasfile('image'))
            {
                $image_file = $request->file('image');
                $img_extension = $image_file->getClientOriginalExtension(); // getting image extension
                $img_filename = time() . '.' . $img_extension;
                $image_file->move('uploads/product/', $img_filename);
                $product->image = $img_filename;
            }
            //$product->image = $filename;
            $product->featured = $request->input('featured') == true ? '1':'0';
            $product->status = $request->input('status') == true ? '1':'0';           
            $product->popular = $request->input('popular') == true ? '1':'0';           
           
            $product->save();

            return response()->json([
                'status' =>200,
                'message' => 'Product Added successfully',
            ]);
        }
    }
}
