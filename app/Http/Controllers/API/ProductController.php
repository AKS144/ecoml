<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'status' =>200,
            'product' =>$products
        ]);
    }


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
            'image'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
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
                $product->image = 'uploads/product/'.$img_filename;
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

    

    public function delete($id)
    {
        $product = Product::find($id);

        if($product)
        {
            $product->delete();            
            return response()->json([
                'status' => 200,
                'message' => "Category deleted successfully",
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No Category ID Found",
            ]);
        }
    }



    public function edit($id)
    {
        $product =Product::find($id);
        if($product)
        {
            return response()->json([
                'status' =>200,
                'product'=>$product
            ]);
        }
        else
        {
            return response()->json([
                'status' =>404,
                'message'=>'N Product Found',
            ]);
        }
    }


    public function update(Request $request, $id)
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
            //'image'=> 'required',
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
            $product = Product::find($id);
            if($product)
            {
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
                    $path = $product->image;
                    if(File::exists($path))
                    {
                        File::delete();
                    }
                    $image_file = $request->file('image');
                    $img_extension = $image_file->getClientOriginalExtension(); // getting image extension
                    $img_filename = time() . '.' . $img_extension;
                    $image_file->move('uploads/product/', $img_filename);
                    $product->image = 'uploads/product/'.$img_filename;
                }
                //$product->image = $filename;
                $product->featured = $request->input('featured');
                $product->status = $request->input('status');           
                $product->popular = $request->input('popular');           
               
                $product->update();
    
                return response()->json([
                    'status' =>200,
                    'message' => 'Product Updated successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status' =>404,
                    'message' => 'Product Not Found',
                ]);
            }
        }
    }
}
