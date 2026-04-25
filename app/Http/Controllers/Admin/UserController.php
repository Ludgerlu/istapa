<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * List all users, with optional role filter.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'admins'   => User::where('role', 'admin')->count(),
            'active'   => User::where('status', 'active')->count(),
        ];

        return view('users.index', compact('users', 'stats'));
    }

    /**
     * Show the create user form.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $base = [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:20',
            'role'       => 'required|in:student,teacher,admin',
            'status'     => 'required|in:active,inactive',
        ];

        $roleRules = match ($request->role) {
            'student' => [
                'class_id'      => 'required|exists:classes,id',
                'date_of_birth' => 'required|date',
            ],
            'teacher' => [
                'subject'    => 'required|string|max:100',
                'department' => 'required|string|max:100',
            ],
            'admin' => [
                'title' => 'required|string|max:100',
            ],
            default => [],
        };

        $validated = $request->validate(array_merge($base, $roleRules));

        $validated['name']     = $validated['first_name'] . ' ' . $validated['last_name'];
        $validated['password'] = Hash::make('school@' . date('Y')); // default password

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show a single user's profile.
     */
    public function show(User $user)
    {
        $user->load('attendances', 'fees');
        return view('users.show', compact('user'));
    }

    /**
     * Show the edit form.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update user details.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'      => 'nullable|string|max:20',
            'status'     => 'required|in:active,inactive',
            'class_id'   => 'nullable|exists:classes,id',
            'subject'    => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'title'      => 'nullable|string|max:100',
        ]);

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Soft-delete (deactivate) a user.
     */
    public function destroy(User $user)
    {
        $user->update(['status' => 'inactive']);

        return redirect()->route('users.index')
            ->with('success', 'User deactivated.');
    }
}
