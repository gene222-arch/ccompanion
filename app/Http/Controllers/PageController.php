<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        $announcements = Announcement::where('enabled', 1)->get();
        $count = $announcements->count();

        for ($i = 1; $i <= $count; $i++) { 
            $indicators[] = $i;
        }

        return view('welcome', [
            'indicators' => $indicators,
            'announcements' => $announcements
        ]);
    }
}
