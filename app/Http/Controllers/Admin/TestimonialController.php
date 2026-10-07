<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\ImageService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'message'     => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
            'avatar'      => 'nullable|image|max:1024',
            'is_active'   => 'boolean',
        ]);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->imageService->store($request->file('avatar'), 'testimonials');
        }
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added.');
    }
    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100', 'designation' => 'nullable|string|max:100',
            'message' => 'required|string', 'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:1024', 'is_active' => 'boolean',
        ]);
        if ($request->hasFile('avatar')) {
            $this->imageService->delete($testimonial->avatar);
            $data['avatar'] = $this->imageService->store($request->file('avatar'), 'testimonials');
        }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }
    public function destroy(Testimonial $testimonial)
    {
        $this->imageService->delete($testimonial->avatar);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}
