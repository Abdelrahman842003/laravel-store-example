<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Dashboard\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CategoriesController extends Controller
{
    public $CategoryInterface;

    public function __construct(CategoryInterface $CategoryInterface)
    {
        $this->CategoryInterface = $CategoryInterface;
    }

    public function index()
    {
        return $this->CategoryInterface->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->CategoryInterface->create();

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Category $category)
    {
        return $this->CategoryInterface->edit($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        return $this->CategoryInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->CategoryInterface->destroy($id);
    }

    public function trash()
    {
        return $this->CategoryInterface->trash();
    }

    public function restore( $id)
    {
        return $this->CategoryInterface->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->CategoryInterface->forceDelete($id);
    }

    protected function uploadImgae(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads_Categories', ['disk' => 'public']);
        return $path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        return $this->CategoryInterface->store($request);
    }
}
