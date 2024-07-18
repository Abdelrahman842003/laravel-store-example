<?php

    namespace App\Http\Controllers\Dashboard;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use App\Models\Product;
    use App\Models\Tag;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    class ProductsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $data_search = $request->query();
            $products = Product::with(['category', 'store'])->filter($data_search)->paginate();
            // SELECT * FROM products
            // SELECT * FROM categories WHERE id IN (..)
            // SELECT * FROM stores WHERE id IN (..)

            return view('dashboard.products.index', compact('products'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            //
            $product = new Product;
            $tags = new Tag;

            return view('dashboard.products.create', compact('product', 'tags'));

        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //
            // Request merge
            $request->merge([
                'slug' => Str::slug($request->post('name'))
            ]);

            $data = $request->except('image');
            $data['image'] = $this->uploadImgae($request);
            Product::create($data);
            return redirect()->route('dashboard.products.index')
                ->with('success', 'Product created!');

        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $product = Product::findOrFail($id);

            $tags = implode(',', $product->tags()->pluck('name')->toArray());

            return view('dashboard.products.edit', compact('product', 'tags'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Product $product)
        {
            $product->update($request->except('tags'));


            $tags = json_decode($request->post('tags'));
            $tag_ids = [];

            $saved_tags = Tag::all();

            foreach ($tags as $item) {
                $slug = Str::slug($item->value);
                $tag = $saved_tags->where('slug', $slug)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item->value,
                        'slug' => $slug,
                    ]);
                }
                $tag_ids[] = $tag->id;
            }

            $product->tags()->sync($tag_ids);

            return redirect()->route('dashboard.products.index')
                ->with('success', 'Product updated');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product)
        {
            //
            $product->delete();


            return Redirect::route('dashboard.products.index')
                ->with('danger', 'Category deleted!');
        }

        protected function uploadImgae(Request $request)
        {
            if (!$request->hasFile('image')) {
                return;
            }

            $file = $request->file('image'); // UploadedFile Object

            $path = $file->store('uploads_Products', [
                'disk' => 'public'
            ]);
            return $path;
        }

        public function trash()
        {
            $products = Product::onlyTrashed()->paginate();
            return view('dashboard.products.trash', compact('products'));
        }

        public function restore(Request $request, $id)
        {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('dashboard.products.trash')
                ->with('info', 'Product restored!');
        }

        public function forceDelete($id)
        {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->forceDelete();

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            return redirect()->route('dashboard.products.trash')
                ->with('danger', 'Product deleted forever!');
        }

    }
