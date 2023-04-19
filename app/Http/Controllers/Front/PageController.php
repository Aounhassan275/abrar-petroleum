<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Information;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function home()
    {
        $information =Information::find(1);
        return view('front.home.index',compact('information'));
    }
    public function services()
    {
        $services = Service::paginate(5);
        return view('front.service.index',compact('services'));
    }
    public function showServiceNext($title)
    {
        $service = Service::where('title',str_replace('_', ' ',$title))->first();
        return view('front.service.show',compact('service'));
    }
    public function showCategoryDetail($name)
    {
        $category = Category::where('name',str_replace('_', ' ',$name))->first();
        return view('front.category.show',compact('category'));
    }
}
