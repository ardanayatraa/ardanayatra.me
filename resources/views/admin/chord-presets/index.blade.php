<x-layouts.admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">FretBubblePNG - Chord Presets</h2>
                        <a href="{{ route('admin.chord-presets.create') }}" 
                           class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                            Add New Chord
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filters -->
                    <form method="GET" class="mb-6 flex gap-4">
                        <select name="family" class="border-2 border-gray-300 rounded px-3 py-2">
                            <option value="">All Families</option>
                            @foreach($families as $family)
                                <option value="{{ $family }}" {{ request('family') == $family ? 'selected' : '' }}>
                                    {{ $family }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="difficulty" class="border-2 border-gray-300 rounded px-3 py-2">
                            <option value="">All Difficulties</option>
                            <option value="simple" {{ request('difficulty') == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.chord-presets.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                            Reset
                        </a>
                    </form>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Family</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Difficulty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frets</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($chords as $chord)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $chord->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $chord->family }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $chord->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded {{ $chord->difficulty == 'simple' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($chord->difficulty) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $chord->num_frets }} frets, {{ $chord->num_strings }} strings</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('admin.chord-presets.edit', $chord) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <form action="{{ route('admin.chord-presets.destroy', $chord) }}" 
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No chord presets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $chords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
