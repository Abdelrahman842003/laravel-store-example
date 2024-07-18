<?php

    namespace App\Http\Controllers\Dashboard;

    use App\Http\Controllers\Controller;
    use App\Http\Interfaces\Dashboard\ProductsInterface;
    use App\Http\Requests\ProductRequest;
    use App\Models\Product;
    use Illuminate\Http\Request;


    class ProductsController extends Controller
    {
        public $ProductsInterface;

        public function __construct(ProductsInterface $ProductsInterface)
        {
            $this->ProductsInterface = $ProductsInterface;
        }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            return $this->ProductsInterface->index($request);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return $this->ProductsInterface->create();
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(ProductRequest $request)
        {
            return $this->ProductsInterface->store($request);
        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */


        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            return $this->ProductsInterface->edit($id);
            }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(ProductRequest $request, Product $product)
        {
            return $this->ProductsInterface->update($request, $product);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product)
        {
            return $this->ProductsInterface->destroy($product);
        }

        protected function uploadImgae(ProductRequest $request)
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
            return $this->ProductsInterface->trash();

        }

        public function restore($id)
        {
            return $this->ProductsInterface->restore($id);
        }

        public function forceDelete($id)
        {
            return $this->ProductsInterface->forceDelete($id);
        }

    }
