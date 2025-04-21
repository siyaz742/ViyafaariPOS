<x-app-layout>
    <div class="container mx-auto px-6 py-8">


        <div class="relative">
            @if (session('error'))
                <div id="error-message" class="absolute top-3 left-1/2 transform -translate-x-1/2 text-center px-8 py-2 bg-rose-50  text-rose-800 border border-rose-300 rounded-xl text-sm font-medium opacity-0 invisible transition-opacity duration-500 ease-in-out z-50">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-2">
                <h1 class="text-5xl font-extrabold text-main-dark italic mb-1">Dashboard</h1>

            </div>
            <div class="mb-0 flex items-center space-x-4">
                <select id="filter" class="pl-4 pr-10 py-2 bg-white bg-opacity-70 shadow-md border text-main-dark
                                border-main-light rounded-lg focus:outline-none focus:border-main-light focus:ring-1 focus:ring-main-light">
                    <option value="day">Today: </option>
                    <option value="month">This Month: </option>
                    <option value="year">This Year: </option>
                </select>
            </div>
        </div>

        <div class="mt-4 mb-0">
            <div class="flex items-center space-x-2">
                <h1 class="text-lg font-semibold text-main-dark italic">
                    Current Date and Time:
                </h1>
                <span class="font-normal text-main-dark" id="currentTime">{{ now() }}</span>
            </div>
        </div>

        <div class="py-32">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="flex space-x-6">

                    <!-- Sales Chart -->
                    <div class="bg-white bg-opacity-70 overflow-hidden shadow-sm sm:rounded-lg mb-6 flex-1">
                        <div class="p-6 text-gray-900">
                            <h2 class="text-2xl font-bold text-main-dark mb-4">Sales Trend</h2>
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Revenue Chart -->
                    <div class="bg-white bg-opacity-70 overflow-hidden shadow-sm sm:rounded-lg mb-6 flex-1">
                        <div class="p-6 text-gray-900">
                            <h2 class="text-2xl font-bold text-main-dark mb-4">Revenue Trend</h2>
                            <canvas id="revenueChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            let salesChart;
            let revenueChart;

            function fetchSalesData(filter) {
                fetch(`/dashboard/sales-data?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.label);
                        const sales = data.map(item => item.sales);

                        if (salesChart) salesChart.destroy();

                        const gradient = salesCtx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(54, 162, 235, 0.6)');
                        gradient.addColorStop(1, 'rgba(54, 162, 235, 0.1)');

                        salesChart = new Chart(salesCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: '# of Sales',
                                    data: sales,
                                    backgroundColor: gradient,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.8)'
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 1000,
                                    easing: 'easeInOutQuad'
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 14
                                            }
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: {
                                            size: 16
                                        },
                                        bodyFont: {
                                            size: 14
                                        },
                                        borderColor: 'rgba(255, 255, 255, 0.2)',
                                        borderWidth: 1
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of Sales',
                                            font: {
                                                size: 16
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(200, 200, 200, 0.3)'
                                        }
                                    }
                                }
                            }
                        });
                    });
            }

            function fetchRevenueData(filter) {
                fetch(`/dashboard/revenue-data?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.label);
                        const revenue = data.map(item => item.revenue);

                        if (revenueChart) revenueChart.destroy();

                        const gradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(75, 192, 192, 0.4)');
                        gradient.addColorStop(1, 'rgba(75, 192, 192, 0.1)');

                        revenueChart = new Chart(revenueCtx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Revenue',
                                    data: revenue,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: gradient,
                                    borderWidth: 2,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: 'rgba(75, 192, 192, 1)'
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 1000,
                                    easing: 'easeInOutQuad'
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 14
                                            }
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: {
                                            size: 16
                                        },
                                        bodyFont: {
                                            size: 14
                                        },
                                        borderColor: 'rgba(255, 255, 255, 0.2)',
                                        borderWidth: 1
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Revenue',
                                            font: {
                                                size: 16
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(200, 200, 200, 0.3)'
                                        }
                                    }
                                }
                            }
                        });
                    });
            }


            // Initialize with default filter
            fetchSalesData('day');
            fetchRevenueData('day');

            // Handle filter change
            document.getElementById('filter').addEventListener('change', function () {
                const filter = this.value;
                fetchSalesData(filter);
                fetchRevenueData(filter);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                // Show the error message with fade-in effect
                setTimeout(() => {
                    errorMessage.classList.remove('opacity-0', 'invisible');
                    errorMessage.classList.add('opacity-100', 'visible');
                }, 100); // Slight delay for smooth appearance

                // Hide the error message
                setTimeout(() => {
                    errorMessage.classList.remove('opacity-100', 'visible');
                    errorMessage.classList.add('opacity-0', 'invisible');
                }, 2750);
            }
        });
    </script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const dateString = now.toLocaleString(); // Customize the format if needed
            document.getElementById('currentTime').textContent = dateString;
        }

        // Update time every second
        setInterval(updateDateTime, 1000);

        // Initial call to set the time when the page loads
        updateDateTime();
    </script>

    <script>
        // Get the current date, month, and year
        const currentDate = new Date();
        const day = currentDate.getDate();  // Get current day
        const month = currentDate.toLocaleString('default', { month: 'long' });  // Get current month (full name)
        const year = currentDate.getFullYear();  // Get current year

        // Format the day and month as "9 - December"
        const formattedDate = `${day} - ${month}`;

        // Get the select element
        const select = document.getElementById('filter');

        // Update the options based on current day, month, and year
        select.options[0].textContent = `Today: ${formattedDate}`;
        select.options[1].textContent = `This Month: ${month}`;
        select.options[2].textContent = `This Year: ${year}`;

    </script>
</x-app-layout>
