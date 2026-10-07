<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $banners = Banner::latest()->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'image'         => 'required|image|max:4096',
            'mobile_image'  => 'nullable|image|max:4096',
            'is_active'     => 'nullable|boolean',
        ]);

        // Desktop Image
        if ($request->hasFile('image')) {

            $data['image'] = $this->imageService->store(
                $request->file('image'),
                'banners'
            );
        }

        // Mobile Image
        if ($request->hasFile('mobile_image')) {

            $data['mobile_image'] = $this->imageService->store(
                $request->file('mobile_image'),
                'banners'
            );
        }

        // Status
        $data['is_active'] = $request->has('is_active');

        Banner::create($data);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.create', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'image'         => 'nullable|image|max:4096',
            'mobile_image'  => 'nullable|image|max:4096',
            'is_active'     => 'nullable|boolean',
        ]);

        // Desktop Image
        if ($request->hasFile('image')) {

            $this->imageService->delete($banner->image);

            $data['image'] = $this->imageService->store(
                $request->file('image'),
                'banners'
            );
        }

        // Mobile Image
        if ($request->hasFile('mobile_image')) {

            $this->imageService->delete($banner->mobile_image);

            $data['mobile_image'] = $this->imageService->store(
                $request->file('mobile_image'),
                'banners'
            );
        }

        // Status
        $data['is_active'] = $request->has('is_active');

        $banner->update($data);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $this->imageService->delete($banner->image);
        $banner->delete();
        return back()->with('success', 'Banner deleted.');
    }
}
