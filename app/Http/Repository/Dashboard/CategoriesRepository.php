<?php

namespace App\Http\Repository\Dashboard;

use App\Http\Interfaces\Dashboard\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesRepository implements CategoryInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $request = request();

        $categories = Category::with('parent')->withCount(['products as products_number' => function ($query) {
            $query->where('status', '=', 'active');
        }])->filter($request->query())->orderBy('categories.name')->paginate();

        return view('Dashboard.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Response
     */
    public function store($request)
    {
        $request->merge(['slug' => Str::slug($request->post('name'))]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        Category::create($data);

        return Redirect::route('Dashboard.categories.index')->with('success', 'Category created!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        return $file->store('uploads_Categories', ['disk' => 'public']);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('Dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit($category)
    {
        $parents = Category::where('id', '<>', $category->id)->where(function ($query) use ($category) {
            $query->whereNull('parent_id')->orWhere('parent_id', '<>', $category->id);
        })->get();

        return view('Dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Response
     */
    public function update($request, $category)
    {
        $old_image = $category->image;

        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route('Dashboard.categories.index')->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy($category)
    {
        $category = Category::findOrFail($category);

        $category->delete();

        return Redirect::route('Dashboard.categories.index')->with('danger', 'Category deleted!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('Dashboard.categories.trash', compact('categories'));
    }

    /**
     * Restore the specified trashed resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function restore( $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('Dashboard.categories.trash')->with('success', 'Category restored!');
    }

    /**
     * Permanently delete the specified trashed resource.
     *
     * @param int $id
     * @return Response
     */
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('Dashboard.categories.trash')->with('danger', 'Category deleted forever!');
    }
}
