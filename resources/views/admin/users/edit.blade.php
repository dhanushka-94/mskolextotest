@extends('admin.layout')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Edit User</h1>
            <p class="text-gray-400 mt-1">Modify {{ $user->name }}'s information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.show', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-eye mr-2"></i>View Profile
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-gray-800 rounded-lg p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-white mb-4">Basic Information</h3>
                </div>

                <!-- Current Avatar -->
                @if($user->avatar)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Current Profile Picture</label>
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-full object-cover">
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('date_of_birth') border-red-500 @enderror">
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-300 mb-2">Gender</label>
                    <select id="gender" name="gender" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500 @error('gender') border-red-500 @enderror">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role *</label>
                    <select id="role" name="role" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500 @error('role') border-red-500 @enderror">
                        <option value="">Select Role</option>
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Settings -->
                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-white mb-4">Account Settings</h3>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-400">Leave blank to keep current password</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-primary-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                    <select id="status" name="status" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary-500 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Avatar -->
                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">New Profile Picture</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600 @error('avatar') border-red-500 @enderror">
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-400">Max size: 2MB. Supported formats: JPG, PNG, GIF</p>
                </div>

                <!-- Account Info -->
                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-white mb-4">Account Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <label class="block text-gray-400">Member Since</label>
                            <p class="text-white">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-400">Last Login</label>
                            <p class="text-white">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-400">Total Orders</label>
                            <p class="text-white">{{ $user->orders->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.users.show', $user) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update User
                </button>
            </div>
        </form>

        <!-- Danger Zone -->
        @if($user->id !== auth()->id())
            <div class="mt-8 border-t border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-red-400 mb-4">Danger Zone</h3>
                <div class="bg-red-900/20 border border-red-800 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="text-red-400 font-medium">Delete User Account</h4>
                            <p class="text-gray-400 text-sm mt-1">Permanently delete this user and all associated data. This action cannot be undone.</p>
                        </div>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                <i class="fas fa-trash mr-2"></i>Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
