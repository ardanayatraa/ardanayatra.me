<x-layouts.admin>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold">Visitors</h1>
            <div class="text-sm text-gray-600">Total: {{ $visitors->total() }}</div>
        </div>

        @if(session('success'))
            <div id="successMessage" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="document.getElementById('successMessage').remove()" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button onclick="switchTab('count')" id="countTab" class="tab-button border-b-2 border-black text-black py-4 px-1 text-sm font-medium">
                    Count
                </button>
                <button onclick="switchTab('analytics')" id="analyticsTab" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                    Analytics
                </button>
            </nav>
        </div>

        <!-- Count Tab -->
        <div id="countContent" class="tab-content">
            <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visit Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visited At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($visitors as $visitor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900">{{ $visitor->name }}</span>
                                    @if(strtoupper($visitor->name) === 'MDY')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            ADMIN
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $visitor->ip_address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ $visitor->visit_count }}x
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $visitor->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('admin.visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No visitors yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

            <div class="mt-4">
                {{ $visitors->links() }}
            </div>
        </div>

        <!-- Analytics Tab -->
        <div id="analyticsContent" class="tab-content hidden">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Visitors</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalVisitors }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Visits</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalVisits }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Unique IPs</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $uniqueIPs }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Visitors Last 7 Days</h3>
                <canvas id="visitorsChart" height="80"></canvas>
            </div>

            <!-- Top Visitors -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Top Visitors</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visit Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($topVisitors as $index => $visitor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : ($index === 2 ? 'bg-orange-100 text-orange-800' : 'bg-gray-50 text-gray-600')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900">{{ $visitor->name }}</span>
                                        @if(strtoupper($visitor->name) === 'MDY')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ADMIN
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $visitor->ip_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        {{ $visitor->visit_count }}x
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('admin.visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No visitors yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartInstance = null;
        let chartInitialized = false;

        // Tab switching
        function switchTab(tab) {
            const countTab = document.getElementById('countTab');
            const analyticsTab = document.getElementById('analyticsTab');
            const countContent = document.getElementById('countContent');
            const analyticsContent = document.getElementById('analyticsContent');

            if (tab === 'count') {
                countTab.classList.add('border-black', 'text-black');
                countTab.classList.remove('border-transparent', 'text-gray-500');
                analyticsTab.classList.remove('border-black', 'text-black');
                analyticsTab.classList.add('border-transparent', 'text-gray-500');
                countContent.classList.remove('hidden');
                analyticsContent.classList.add('hidden');
            } else {
                analyticsTab.classList.add('border-black', 'text-black');
                analyticsTab.classList.remove('border-transparent', 'text-gray-500');
                countTab.classList.remove('border-black', 'text-black');
                countTab.classList.add('border-transparent', 'text-gray-500');
                analyticsContent.classList.remove('hidden');
                countContent.classList.add('hidden');
                
                // Initialize chart when analytics tab is opened
                if (!chartInitialized) {
                    initChart();
                    chartInitialized = true;
                }
            }
        }

        // Initialize Chart
        function initChart() {
            const dailyData = @json($dailyVisitors);
            const labels = dailyData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });
            const data = dailyData.map(item => item.count);

            const ctx = document.getElementById('visitorsChart');
            if (ctx) {
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'New Visitors',
                            data: data,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        }

        // Auto-hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 0.5s';
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</x-layouts.admin>
