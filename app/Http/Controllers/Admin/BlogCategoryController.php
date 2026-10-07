<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->paginate(10);
        return view('admin.blogs.categories', compact('categories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'slug' => 'nullable|string|unique:blog_categories']);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        BlogCategory::create($data);
        return redirect()->route('admin.blog-categories.index')->with('success', 'Category created.');
    }

    public function create()
    {
        return view('admin.blogs.cat-blog-create');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blogs.cat-blog-create', compact('blogCategory'));
    }
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'slug' => 'nullable|string|unique:blog_categories,slug,'.$blogCategory->id]);
        $blogCategory->update($data);
        return redirect()->route('admin.blog-categories.index')->with('success', 'Category updated.');
    }
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
