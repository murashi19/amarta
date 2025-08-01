<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\MasterStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'status']);

        // Cari berdasarkan nama, email, atau nomor telepon
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status_id') && $request->status_id != '') {
            $query->where('status_id', $request->status_id);
        }

        // Filter by role
        if ($request->has('role_id') && $request->role_id != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('role_id', $request->role_id);
            });
        }

        // Filter by Japanese level
        if ($request->has('japanese_level') && $request->japanese_level != '') {
            $query->where('japanese_level', $request->japanese_level);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        }

        $roles = Role::all();
        $statuses = MasterStatus::all();

        return view('admin.usersManage', compact('users', 'roles', 'statuses'));
    }

    public function create()
    {
        $roles = Role::all();
        $statuses = MasterStatus::all();
        
        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'japanese_level' => 'nullable|in:N5,N4,N3,N2,N1,none',
            'motivation' => 'nullable|string',
            'status_id' => 'required|exists:master_statuses,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'education' => $request->education,
            'japanese_level' => $request->japanese_level,
            'motivation' => $request->motivation,
            'status_id' => $request->status_id,
        ]);

        // Attach roles
        $user->roles()->attach($request->roles);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'data' => $user->load(['roles', 'status'])
            ]);
        }

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'status', 'transactions', 'events']);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $statuses = MasterStatus::all();
        $userRoles = $user->roles->pluck('id');
        
        return view('admin.users.edit', compact('user', 'roles', 'statuses', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'japanese_level' => 'nullable|in:N5,N4,N3,N2,N1,none',
            'motivation' => 'nullable|string',
            'status_id' => 'required|exists:master_statuses,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'education' => $request->education,
            'japanese_level' => $request->japanese_level,
            'motivation' => $request->motivation,
            'status_id' => $request->status_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Sync roles
        $user->roles()->sync($request->roles);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => $user->load(['roles', 'status'])
            ]);
        }

        return redirect()->route('admin.users')
                        ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        try {
            $user->roles()->detach();
            $user->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.users.index')
                            ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users.index')
                            ->with('error', 'Gagal menghapus user');
        }
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            User::whereIn('id', $request->ids)->each(function($user) {
                $user->roles()->detach();
                $user->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Users berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus users: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $query = User::with(['roles', 'status']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Address', 'Birth Date', 
                'Education', 'Japanese Level', 'Status', 'Roles', 'Created At'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone_number,
                    $user->address,
                    $user->birth_date,
                    $user->education,
                    $user->getJapaneseLevelText(),
                    $user->status->name ?? '',
                    $user->roles->pluck('name')->implode(', '),
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}