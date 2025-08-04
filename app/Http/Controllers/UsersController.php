<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class UsersController extends Controller
{
    public function index(Request $request)
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

        if ($request->has('status_id') && $request->status_id != '') {
            $query->where('status_id', $request->status_id);
        }

        if ($request->has('role_id') && $request->role_id != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('role_id', $request->role_id);
            });
        }

        $users = $query->latest()->paginate(10);

        $roles = Role::all();
        $statuses = Status::all();

        return view('admin.usersManage', compact('users', 'roles', 'statuses'));
    }

    public function create()
    {
        $roles = Role::all();
        $statuses = Status::all();

        return view('admin.createUser', compact('roles', 'statuses'));
    }


    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('Create User Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
            'education_level' => 'nullable|in:SMP/Sederajat,SMA/SMK/Sederajat,Diploma 3 (D3),Sarjana (S1),Lainnya',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
            'notes' => 'nullable|string|max:1000',
            'status_id' => 'required|exists:statuses,id',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'status_id.required' => 'Status user wajib dipilih.',
            'status_id.exists' => 'Status yang dipilih tidak valid.',
            'roles.required' => 'Minimal satu role harus dipilih.',
            'roles.min' => 'Minimal satu role harus dipilih.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran gambar maksimal 5MB.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan pada form. Silakan periksa kembali.');
        }

        try {
            DB::beginTransaction();

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                try {
                    $photo = $request->file('photo');
                    
                    // Pastikan direktori ada
                    if (!Storage::disk('public')->exists('photos')) {
                        Storage::disk('public')->makeDirectory('photos');
                    }
                    
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photoPath = $photo->storeAs('photos', $filename, 'public');
                    
                    \Log::info('Photo uploaded successfully:', ['path' => $photoPath]);
                } catch (\Exception $e) {
                    \Log::error('Photo upload failed:', ['error' => $e->getMessage()]);
                    throw new \Exception('Gagal mengupload foto: ' . $e->getMessage());
                }
            }

            // Prepare user data
            $userData = [
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'education_level' => $request->education_level,
                'photo' => $photoPath,
                'notes' => $request->notes,
                'status_id' => $request->status_id,
                // 'email_verified_at' => $request->boolean('is_verified') ? now() : null,
            ];

            \Log::info('User data to be inserted:', $userData);

            // Create user
            $user = User::create($userData);
            
            if (!$user) {
                throw new \Exception('Gagal membuat user baru');
            }

            \Log::info('User created with ID:', ['user_id' => $user->id]);

            // Assign roles
            if (!empty($request->roles)) {
                $user->roles()->sync($request->roles);
                \Log::info('Roles assigned:', ['user_id' => $user->id, 'roles' => $request->roles]);
            }

            DB::commit();
            
            \Log::info('User Berhasil Ditambahkan:', ['user_id' => $user->id]);
            
            return redirect()->route('admin.usersManage')
                ->with('success', 'User berhasil ditambahkan dengan ID: ' . $user->id);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('User creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Delete uploaded photo if exists
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
                \Log::info('Cleanup: Photo deleted due to error');
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat user: ' . $e->getMessage());
        }
    }


    public function show(User $user)
    {
        $user->load(['roles', 'status']);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }

        return view('admin.usersManage.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load(['roles', 'status']);
        $roles = Role::all();
        $statuses = Status::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'roles' => $roles,
                    'statuses' => $statuses,
                    'userRoles' => $userRoles
                ]
            ]);
        }

        return view('admin.editUser', compact('user', 'roles', 'statuses', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'education_level' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'notes' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

       

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $updateData = $request->only([
                'name', 'email', 'phone_number', 'gender', 'birth_place', 'birth_date',
                'address', 'education_level', 'photo', 'notes', 'status_id',
            ]);


            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($user->photo_url && \Storage::disk('public')->exists($user->photo_url)) {
                    \Storage::disk('public')->delete($user->photo_url);
                }

                // Simpan foto baru
                $photoPath = $request->file('photo')->store('uploads/photos', 'public');
                $updateData['photo'] = $photoPath;
            }

            $user->update($updateData);
            $user->roles()->sync($request->roles);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diperbarui',
                    'data' => $user->load(['roles', 'status'])
                ]);
            }

            return redirect()->route('admin.usersManage')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data'
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->roles()->detach();
            $user->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.usersManage')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data'
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    // Method tambahan untuk mendapatkan data user dalam format JSON
    public function getData(Request $request)
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

        if ($request->has('status_id') && $request->status_id != '') {
            $query->where('status_id', $request->status_id);
        }

        if ($request->has('role_id') && $request->role_id != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('role_id', $request->role_id);
            });
        }

        $users = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
}