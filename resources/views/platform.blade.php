<x-layouts.app :title="__('Platformss')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">

                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Platform</h2>

                    <form action="{{ route('platforms.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Platform Name</label>
                                <input type="text" name="platform_name" value="{{ old('platform_name') }}"
                                       placeholder="Enter platform name" required
                                       class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                @error('platform_name')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="flex items-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Platform
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Platform List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Platform List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Platform Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($platforms as $platform)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50" id="platform-row-{{ $platform->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="course-name-display">{{ $platform->platform_name }}</span>
                                        </td>
    
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button type="button" onclick='editPlatform({{ $platform->id }}, {!! json_encode($platform->platform_name) !!})'
                                                    class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('platforms.destroy', $platform) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to move this platform to trash?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No platforms found. Add your first platform above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editPlatformModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Platform</h2>

            <form id="editPlatformForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Platform Name</label>
                        <input type="text" id="edit_platform_name" name="platform_name" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditPlatformModal()"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                        Update Platform
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editPlatform(id, platform_name) {
            const modal = document.getElementById('editPlatformModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('editPlatformForm').action = `/platforms/${id}`;
            document.getElementById('edit_platform_name').value = platform_name;
        }

        function closeEditPlatformModal() {
            const modal = document.getElementById('editPlatformModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-layouts.app>