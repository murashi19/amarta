<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function filter(Request $request)
    {
        // Ambil input filter
        $search = $request->input('search');
        $role   = $request->input('role');
        $status = $request->input('status');

        // Query dasar
        $query = User::query();

        // Filter pencarian (nama atau email)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if (!empty($role)) {
            $query->where('role', $role);
        }

        // Filter status
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Ambil data (misalnya paginated)
        $users = $query->orderBy('name', 'asc')->paginate(10);

        // Return JSON
        return response()->json([
            'success' => true,
            'data'    => $users
        ]);
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

        return view('admin.userDetail', compact('user'));
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

   public function deleteUser(User $user)
    {
        try {
            // Cek apakah user ditemukan
            if (!$user) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan.'
                    ], 404);
                }
                
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }

            // Store user name for success message
            $userName = $user->name;

            // Detach role jika ada
            if ($user->roles()->exists()) {
                $user->roles()->detach();
            }

            // Hapus foto jika ada
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }

            // Hapus user
            $user->delete();

            // Respon untuk AJAX atau JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "User '{$userName}' berhasil dihapus."
                ]);
            }

            // Respon redirect untuk request biasa
            return redirect()->route('admin.usersManage')->with('success', "User '{$userName}' berhasil dihapus.");
            
        } catch (\Throwable $e) {
            // Logging untuk debugging
            \Log::error('Gagal hapus user: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            // Respon untuk AJAX atau JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
                ], 500);
            }

            // Respon redirect untuk request biasa
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
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


    // Profile User
    public function profile()
    {
        $user = auth()->user()->load(['roles', 'status']);

        // Ambil semua transaksi + cicilannya
        $transactions = Transaction::with('feePayments')
            ->where('user_id', $user->id)
            ->get();

        // Filter sesuai aturan
        $filtered = $transactions->filter(function($trx) use ($user) {
            if ($trx->status === 'Completed') return true;
            if ($trx->type === 'dp') return true;

            switch ($user->status->name) {
                case 'Registered':
                    return $trx->type === 'booking';
                case 'Meeting Joined':
                case 'Active':
                    return $trx->type === 'dp';
                case 'Pemantapan':
                    return $trx->type === 'pemantapan';
                case 'Pemberangkatan':
                    return $trx->type === 'pemberangkatan';
                default:
                    return false;
            }
        });

        // 👉 Tambahin ambil meeting terbaru user
        $meeting = Meeting::where('user_id', $user->id)
            ->latest('schedule_at')
            ->first();

        return view('users.profile', [
            'user' => $user,
            'transactions' => $filtered,
            'meeting' => $meeting // <--- kirim ke blade
        ]);
    }


    // Tampilkan form edit profil
    public function editProfile()
    {
        $user = Auth::user();
        return view('users.editprofile', compact('user'));
    }

     public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number'    => 'nullable|string|max:20',
            'gender'          => 'nullable|in:Laki-laki,Perempuan',
            'birth_place'     => 'nullable|string|max:100',
            'birth_date'      => 'nullable|date',
            'education_level' => 'nullable|string|max:50',
            'address'         => 'nullable|string|max:500',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('photo')) {
            try {
                $photo = $request->file('photo');

                // Pastikan direktori ada
                if (!Storage::disk('public')->exists('photos')) {
                    Storage::disk('public')->makeDirectory('photos');
                }

                // Hapus foto lama jika ada
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                // Buat nama file unik
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

                // Simpan file
                $photoPath = $photo->storeAs('photos', $filename, 'public');

                // Simpan path untuk database (TANPA "storage/")
                $validated['photo'] = $photoPath;

                Log::info('Photo uploaded successfully:', ['path' => $photoPath]);
            } catch (\Exception $e) {
                Log::error('Photo upload failed:', ['error' => $e->getMessage()]);
                return back()->withErrors(['photo' => 'Gagal mengupload foto: ' . $e->getMessage()]);
            }
        }

        // Update data user
        $user->update($validated);

        return redirect()->route('users.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function adminProfile()
    {
        // Ambil data admin beserta role dan status
        $admin = auth()->user()->load(['roles', 'status']);

        // Pastikan hanya admin yang bisa akses
        if (!$admin->roles->contains('name', 'Admin')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('admin.profile', compact('admin'));
    }

    public function editAdminProfile()
    {
        $admin = Auth::user();

        if (!$admin->roles->contains('name', 'Admin')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('admin.editprofile', compact('admin'));
    }

    public function updateAdminProfile(Request $request)
    {
        $admin = Auth::user();

        if (!$admin->roles->contains('name', 'Admin')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Validasi data
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($admin->id),
            ],
            'phone_number'    => 'nullable|string|max:20',
            'gender'          => [
                'nullable',
                Rule::in(['Laki-laki', 'Perempuan']), // sesuai enum DB
            ],
            'birth_place'     => 'nullable|string|max:100',
            'birth_date'      => 'nullable|date',
            'education_level' => [
                'nullable',
                Rule::in(['SMP/Sederajat','SMA/SMK/Sederajat','Diploma 3 (D3)','Sarjana (S1)','Lainnya']), // sesuai enum DB
            ],
            'address'         => 'nullable|string|max:500',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            try {
                $photo = $request->file('photo');

                // Pastikan folder photos ada
                if (!Storage::disk('public')->exists('photos')) {
                    Storage::disk('public')->makeDirectory('photos');
                }

                // Hapus foto lama jika ada
                if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                    Storage::disk('public')->delete($admin->photo);
                }

                // Simpan foto baru dengan nama unik
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('photos', $filename, 'public');

                $validated['photo'] = $photoPath;

                Log::info('Admin photo uploaded successfully', ['path' => $photoPath]);
            } catch (\Exception $e) {
                Log::error('Admin photo upload failed', ['error' => $e->getMessage()]);
                return back()->withErrors(['photo' => 'Gagal mengupload foto: ' . $e->getMessage()]);
            }
        }

        // Update data admin
        $admin->update($validated);

        return redirect()->route('admin.profile')->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Password saat ini salah!'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Password berhasil diubah!']);
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status_id' => 'required|in:1,2,3,4,5,6,7',
        ]);

        // Cari user
        $user = User::findOrFail($id);

        // Update status
        $user->status_id = $request->status_id;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Status user berhasil diperbarui.');
    }

}