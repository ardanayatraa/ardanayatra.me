<x-layouts.admin>
    <div class="max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4" class="w-full border-gray-300 rounded-lg">{{ old('bio', $profile->bio) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Avatar URL</label>
                <input type="url" name="avatar" value="{{ old('avatar', $profile->avatar) }}" class="w-full border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                <input type="url" name="website" value="{{ old('website', $profile->website) }}" class="w-full border-gray-300 rounded-lg">
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Profile
            </button>
        </form>
    </div>
</x-layouts.admin>
