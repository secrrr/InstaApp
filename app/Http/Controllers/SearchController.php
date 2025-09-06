<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $users = User::where('name', 'like', "%{$keyword}%")
                     ->take(5) // batasi 5 hasil
                     ->get(['id','name']);
        return response()->json($users);
    }
}

