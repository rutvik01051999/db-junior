<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use Illuminate\Http\Request;

class FrontCmsPageController extends Controller
{
    /**
     * Display the specified CMS page.
     */
    public function show($slug)
    {
        $cmsPage = CmsPage::getBySlug($slug);
        
        if (!$cmsPage) {
            abort(404, 'Page not found');
        }

        return view('front.cms-page', compact('cmsPage'));
    }
}
