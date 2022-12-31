<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    //list all category 
    public function allcategory()
    {
        $category = Category::where('status','0')->get();
        return response()->json([
            'status' =>200,
            'category' =>$category,
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'meta_title' => 'required|max:191',
            'slug' =>'required|max:191',
            'name' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $category                 =   new Category();
            $category->meta_title     =   $request->meta_title;
            $category->meta_keyword   =   $request->meta_keyword;
            $category->meta_desc      =   $request->meta_desc;
            $category->slug           =   $request->slug;
            $category->name           =   $request->name;
            $category->description    =   $request->description;
            $category->status         =   $request->input('status') == true ? '1':'0';
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category added Successfully',
            ]);
        }
    }


    public function edit($id)
    {
        $category = Category::find($id);
        if($category)
        {
            return response()->json([
                'status' =>200,
                'category' => $category,
            ]);
        }
        else
        {
            return response()->json([
                'status' =>200,
                'message' => 'No category found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'meta_title' => 'required|max:191',
            'slug' =>'required|max:191',
            'name' => 'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $category  =  Category::find($id);

            if($category)
            {
                $category->meta_title     =   $request->meta_title;
                $category->meta_keyword   =   $request->meta_keyword;
                $category->meta_desc      =   $request->meta_desc;
                $category->slug           =   $request->slug;
                $category->name           =   $request->name;
                $category->description    =   $request->description;
                $category->status         =   $request->input('status') == true ? '1':'0';
                $category->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Category added Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'No category Id Found',
                ]);
            }
        }
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if($category)
        {
            $category->delete();            
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

}
