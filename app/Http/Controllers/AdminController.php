<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index(Request $request)
    {
        $searchQuery = $request->get('search');

        $users = User::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
            $query->orWhere('email', 'like', "%{$searchQuery}%");
        })
        ->orderBy('role', 'asc')
        ->latest()
        ->paginate(8);
        
        return view('admin.user.index', compact('searchQuery', 'users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        return view('admin.users.store');
    }

    public function show($id)
    {
        return view('admin.users.show');
    }

    public function edit($id)
    {
        return view('admin.users.edit');
    }

    public function update(Request $request, $id)
    {
        return view('admin.users.update');
    }
} 