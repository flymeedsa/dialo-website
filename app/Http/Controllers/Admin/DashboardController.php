<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Faq;
use App\Models\HelpArticle;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', ['counts' => [
            'posts' => BlogPost::count(), 'articles' => HelpArticle::count(),
            'faqs' => Faq::count(), 'inquiries' => ContactSubmission::where('status', 'new')->count(),
        ]]);
    }
}
