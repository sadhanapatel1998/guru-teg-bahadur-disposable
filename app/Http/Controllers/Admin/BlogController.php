<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $blogs = Blog::with(['blogCategory','admin'])->latest()->paginate(20);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

  public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|unique:blogs',
            'excerpt'          => 'nullable|string',
            'body'             => 'required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'thumbnail'        => 'nullable|image|max:2048',
            'status'           => 'required|in:draft,published',
            'meta_title'       => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:300',
            'published_at'     => 'nullable|date',
            'tags'             => 'nullable|string',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $data['admin_id'] = Auth::guard('admin')->id();

        // TAGS ARRAY
        $data['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        if ($request->hasFile('thumbnail')) {

            $data['thumbnail'] = $this->imageService
                ->store($request->file('thumbnail'), 'blogs');
        }

        Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog post created.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        // dd($request->all());
        // exit;
        
    
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|unique:blogs,slug,' . $blog->id,
            'excerpt'          => 'nullable|string',
            'body'             => 'required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'thumbnail'        => 'nullable|image|max:2048',
            'status'           => 'required|in:draft,published',
            'meta_title'       => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:300',
            'published_at'     => 'nullable|date',
            'tags'             => 'nullable|string',
        ]);

     

        // TAGS ARRAY
        $data['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        if ($request->hasFile('thumbnail')) {

            $this->imageService->delete($blog->thumbnail);

            $data['thumbnail'] = $this->imageService
                ->store($request->file('thumbnail'), 'blogs');
        }

        $blog->update($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog post updated.');
    }
    
    


    public function destroy(Blog $blog)
    {
        $this->imageService->delete($blog->thumbnail);
        $blog->delete();
        return back()->with('success', 'Blog deleted.');
    }
}
