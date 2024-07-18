<?php

namespace App\Http\Repository\Dashboard;


use App\Http\Interfaces\Dashboard\ProductsInterface;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsRepository implements ProductsInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($request)
    {
        $data_search = $request->query();
        $products = Product::with(['category', 'store'])->filter($data_search)->paginate();
        // SELECT * FROM products
        // SELECT * FROM categories WHERE id IN (..)
        // SELECT * FROM stores WHERE id IN (..)

        return view('Dashboard.products.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($request)
    {
//        dd($request);
        //
        // Request merge
        $request->merge(['slug' => Str::slug($request->post('name'))]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImgae($request);
        Product::create($data);
        return redirect()->route('Dashboard.products.index')->with('success', 'Product created!');

    }

    protected function uploadImgae($request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads_Products', ['disk' => 'public']);
        return $path;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $product = new Product();
        $tags = new Tag();

        return view('Dashboard.products.create', compact('product', 'tags'));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('Dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update($request, $product)
    {
        $product->update($request->except('tags'));


        $tags = json_decode($request->post('tags'));
        $tag_ids = [];

        $saved_tags = Tag::all();

        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create(['name' => $item->value, 'slug' => $slug,]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        return redirect()->route('Dashboard.products.index')->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($product)
    {
        //
        $product->delete();


        return Redirect::route('Dashboard.products.index')->with('danger', 'Category deleted!');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate();
        return view('Dashboard.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('Dashboard.products.trash')->with('info', 'Product restored!');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        // حذف الصورة من storage إذا كانت موجودة
        if (Storage::disk('public')) {
            Storage::disk('public')->delete($product->image);
        }

        // حذف المنتج بشكل نهائي
        $product->forceDelete();

        return redirect()->route('Dashboard.products.trash')->with('danger', 'Product deleted forever!');
    }


}
