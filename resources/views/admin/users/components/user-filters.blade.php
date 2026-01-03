<div class="bg-white rounded-lg shadow p-4 border border-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
            <div class="relative">
                <input type="text" placeholder="Search by name, email..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="restricted">Restricted</option>
            </select>
        </div>

        <!-- University Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">University</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Universities</option>
                <option value="um">Universiti Malaya</option>
                <option value="utm">Universiti Teknologi Malaysia</option>
                <option value="ukm">Universiti Kebangsaan Malaysia</option>
            </select>
        </div>
    </div>

    <!-- Advanced Filters Toggle -->
    <div class="mt-4 pt-4 border-t border-gray-200">
        <button class="text-sm text-primary hover:text-purple-700 font-medium flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            Advanced Filters
        </button>
    </div>
</div>
