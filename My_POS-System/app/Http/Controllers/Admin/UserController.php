<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'role' => 'required|in:admin,manager,cashier',
            'password' => ['required', 'confirmed', Password::min(8)],
            'status' => 'required|in:active,inactive',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        // Load relationships for statistics
        $user->loadCount(['sales', 'purchases']);
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'role' => 'required|in:admin,manager,cashier',
            'status' => 'required|in:active,inactive',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }
        
        // Check if user has sales or purchases
        if ($user->sales()->count() > 0 || $user->purchases()->count() > 0) {
            return back()->with('error', 'Cannot delete user with existing sales or purchases!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
    
    /**
     * Change password form
     */
    public function changePasswordForm(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }
    
    /**
     * Update password
     */
    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Password changed successfully!');
    }
}