<?php
namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource with search functionality.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%");
            });
        }

        // Filter by specific fields
        if ($request->has('class') && $request->class) {
            $query->where('class', $request->class);
        }

        if ($request->has('nis') && $request->nis) {
            $query->where('nis', $request->nis);
        }

        if ($request->has('nisn') && $request->nisn) {
            $query->where('nisn', $request->nisn);
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nis' => 'required|string|max:255|unique:users',
            'class' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'class' => $request->class,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Generate a new login token for the specified user.
     */
    public function generateToken(User $user)
    {
        $token = $this->generateShortToken();
        $user->update([
            'login_token' => $token,
            'login_token_generated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Login token generated successfully.');
    }

    /**
     * Generate password tokens for all users in one click.
     */
    public function generateTokensForAll()
    {
        $users = User::all();
        $generatedCount = 0;

        foreach ($users as $user) {
            $token = $this->generateShortToken();
            $user->update([
                'login_token' => $token,
                'login_token_generated_at' => Carbon::now(),
            ]);
            $generatedCount++;
        }

        return redirect()->route('admin.users.index')->with('success', "Generated login tokens for {$generatedCount} users successfully.");
    }

    /**
     * Generate a shorter, more user-friendly token.
     */
    private function generateShortToken()
    {
        // Generate a shorter token (8 characters) using uppercase letters and numbers
        return strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8));
    }
}
