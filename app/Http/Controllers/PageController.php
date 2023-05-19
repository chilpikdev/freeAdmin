<?php

namespace App\Http\Controllers;

use App\Models\Admin\FaqCategory;
use App\Models\Admin\PaymentPlan;
use App\Models\Admin\Review;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * get Home Page
     */
    public function homePage()
    {
        return view('welcome');
    }
}
