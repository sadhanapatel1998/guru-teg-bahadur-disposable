<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()    { return view('frontend.pages.about'); }
    public function profile()    { return view('frontend.pages.profile'); }
    public function faq()      { return view('frontend.pages.faq'); }
    // public function privacy()  { return view('frontend.pages.privacy'); }
    // public function terms()    { return view('frontend.pages.terms'); }
    // public function refund()   { return view('frontend.pages.refund'); }

    public function contact()  { return view('frontend.pages.contact'); }

  public function submitContact(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'phone'   => 'nullable|string|max:15',
        'subject' => 'nullable|string|max:200',
        'message' => 'required|string|max:2000',
    ]);


    Mail::send([], [], function ($message) use ($data) {

        $message->to('codersvox@gmail.com')
                ->subject('New Contact Inquiry')
                ->html("
                <!DOCTYPE html>
                <html>
                <head>
                <meta charset='UTF-8'>
                </head>
                <body style='margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;'>

                <div style='max-width:650px;margin:30px auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;'>

                    <div style='background:#28486C;padding:25px;text-align:center;'>
                        <h1 style='margin:0;color:#fff;font-size:24px;'>
                            New Contact Inquiry
                        </h1>
                    </div>

                    <div style='padding:30px;'>

                        <p style='margin-top:0;color:#6b7280;font-size:14px;'>
                            A new contact form submission has been received from your website.
                        </p>

                        <table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>

                            <tr>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;width:140px;'>
                                    <strong>Name</strong>
                                </td>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    {$data['name']}
                                </td>
                            </tr>

                            <tr>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    <strong>Email</strong>
                                </td>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    <a href='mailto:{$data['email']}' style='color:#28486C;text-decoration:none;'>
                                        {$data['email']}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    <strong>Phone</strong>
                                </td>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    ".($data['phone'] ?? 'N/A')."
                                </td>
                            </tr>

                            <tr>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    <strong>Subject</strong>
                                </td>
                                <td style='padding:12px 0;border-bottom:1px solid #eee;'>
                                    ".($data['subject'] ?? 'General Inquiry')."
                                </td>
                            </tr>

                        </table>

                        <div style='margin-top:25px;'>
                            <h3 style='margin-bottom:10px;color:#111827;'>
                                Message
                            </h3>

                            <div style='background:#f8fafc;border-left:4px solid #28486C;padding:15px;border-radius:6px;color:#374151;line-height:1.7;'>
                                ".nl2br(e($data['message']))."
                            </div>
                        </div>

                    </div>

                </div>

                </body>
                </html>
                ");
    });

    return back()->with(
        'success',
        'Your message has been sent. We\'ll get back to you shortly!'
    );
}
    public function newsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        \App\Models\NewsletterSubscriber::firstOrCreate(['email' => $request->email]);
        return back()->with('success', 'Subscribed successfully!');
    }

    public function sitemap()
    {
        $products   = \App\Models\Product::active()->get(['slug','updated_at']);
        $categories = \App\Models\Category::active()->get(['slug','updated_at']);
        $blogs      = \App\Models\Blog::published()->get(['slug','updated_at']);
        return response()->view('frontend.pages.sitemap', compact('products','categories','blogs'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nSitemap: " . url('/sitemap.xml');
        return response($content)->header('Content-Type', 'text/plain');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.page', compact('page'));
    }
}
