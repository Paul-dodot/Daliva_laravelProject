<x-layouts.app :title="__('Games Trash')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    @if(session('success'))
        <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Trashed Games</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $trashedGames->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-red-100 p-3 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trash Management Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Trashed Games</h2>
                    <a href="{{ route('dashboard') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Back to Dashboard
                    </a>
                </div>

                <div class="flex-1 overflow-auto">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Photo</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Release Year</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Developer</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Publisher</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Platform</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($trashedGames as $game)
                                <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($game->photo)
                                            <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->title }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 font-semibold text-sm">
                                                {{ strtoupper(substr($game->title, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $game->title }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $game->release_year }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $game->developer }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $game->publisher }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $game->platform ? $game->platform->platform_name : 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <form action="{{ route('games.restore', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to restore this game?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 transition-colors hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                                Restore
                                            </button>
                                        </form>
                                        <span class="mx-1 text-neutral-400">|</span>
                                        <form action="{{ route('games.force-delete', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this game? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete Forever</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-neutral-500 dark:text-neutral-400">
                                        No trashed games found.
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
</x-layouts.app>