import ApexCharts from 'apexcharts';

let chartInstance = null;
let lastPeriod = null;

let renderRetryCount = 0;
const maxRenderRetries = 3;

let currentChartElement = null;
let currentChartPeriod = null;

async function renderChart() {
    const chartElement = document.querySelector("#registrationTrendsChart");

    if (!chartElement) {
        console.log('Chart element not found in renderChart');
        return;
    }

    // Get data from the data attribute
    let chartData = [];
    try {
        const dataAttr = chartElement.getAttribute('data-trends');
        if (dataAttr) {
            chartData = JSON.parse(dataAttr);
        }
    } catch (e) {
        console.error('Error parsing chart data:', e);
        return;
    }

    const selectedPeriod = chartElement.getAttribute('data-period') || '30';

    // Check if period changed or if chart doesn't exist
    const periodChanged = lastPeriod !== selectedPeriod;
    
    if (!periodChanged && chartInstance) {
        // Period hasn't changed, but update the data if chart exists
        if (chartData.length > 0) {
            try {
                const dates = chartData.map(item => item.date);
                const counts = chartData.map(item => item.count);
                
                chartInstance.updateOptions({
                    series: [{
                        data: counts,
                    }],
                    xaxis: {
                        categories: dates,
                    },
                });
            } catch (e) {
                console.error('Error updating chart:', e);
            }
        }
        return;
    }

    // Period changed or chart doesn't exist - need to re-render
    if (periodChanged && chartInstance) {
        console.log(`Period changed from ${lastPeriod} to ${selectedPeriod}, re-rendering chart...`);
        // Destroy existing chart first
        try {
            chartInstance.destroy();
        } catch (e) {
            console.error('Error destroying chart on period change:', e);
        }
        chartInstance = null;
    }

    lastPeriod = selectedPeriod;

    if (chartData.length === 0) {
        // Don't clear if we're showing a message already
        if (!chartElement.querySelector('.dashboard-chart1')) {
            chartElement.innerHTML = '<p class="text-slate-400 text-center">No registration data available for the selected period.</p>';
        }
        return;
    }

    // Extract dates and counts before clearing
    const dates = chartData.map(item => item.date);
    const counts = chartData.map(item => item.count);

    // Clear any previous content but ensure element still exists
    if (!chartElement || !document.body.contains(chartElement)) {
        console.error('Chart element not in DOM before clearing');
        return;
    }

    // Chart instance should already be destroyed if period changed (handled above)
    // But destroy it here too if it still exists (for safety)
    if (chartInstance) {
        try {
            chartInstance.destroy();
        } catch (e) {
            console.error('Error destroying chart:', e);
        }
        chartInstance = null;
        // Wait for cleanup to complete
        await new Promise(resolve => setTimeout(resolve, 100));
    }
    
    // Verify element still exists after cleanup
    const verifyElement = document.querySelector("#registrationTrendsChart");
    if (!verifyElement || !document.body.contains(verifyElement)) {
        console.error('Chart element not in DOM after cleanup');
        return;
    }
    
    // Use the verified element
    const finalChartElement = verifyElement;

    // Update global references for current chart element and period
    currentChartElement = finalChartElement;
    currentChartPeriod = selectedPeriod;

    // Clear ONLY if there's old content (error messages, etc.) but NOT if there's an existing ApexCharts SVG
    // ApexCharts will handle its own container clearing during render
    if (finalChartElement.innerHTML && !finalChartElement.querySelector('svg')) {
        finalChartElement.innerHTML = '';
        // Brief wait for DOM to settle
        await new Promise(resolve => setTimeout(resolve, 50));
    }

    // Ensure minimum dimensions are set (they should be set in CSS, but ensure here too)
    if (!finalChartElement.style.minHeight) {
        finalChartElement.style.minHeight = '350px';
    }
    if (!finalChartElement.style.width && !finalChartElement.style.minWidth) {
        finalChartElement.style.width = '100%';
    }

    // Don't check dimensions - ApexCharts can handle rendering even if dimensions are calculated later
    // The element is in the DOM and has dimensions set via CSS, so proceed with rendering
    // ApexCharts will handle responsive sizing and will adjust when dimensions become available

    const options = {
        series: [
            {
                name: "Registrations",
                data: counts,
            },
        ],
        legend: {
            show: false,
            position: "top",
            horizontalAlign: "left",
        },
        colors: ["#3C50E0"],
        chart: {
            fontFamily: "Satoshi, sans-serif",
            height: 350,
            type: "area",
            dropShadow: {
                enabled: true,
                color: "#623CEA14",
                top: 10,
                blur: 4,
                left: 0,
                opacity: 0.1,
            },
            toolbar: {
                show: false,
            },
        },
        responsive: [
            {
                breakpoint: 1024,
                options: {
                    chart: {
                        height: 300,
                    },
                },
            },
            {
                breakpoint: 1366,
                options: {
                    chart: {
                        height: 350,
                    },
                },
            },
        ],
        stroke: {
            width: [2],
            curve: "smooth",
        },
        markers: {
            size: 4,
            colors: "#fff",
            strokeColors: ["#3C50E0"],
            strokeWidth: 3,
            strokeOpacity: 0.9,
            strokeDashArray: 0,
            fillOpacity: 1,
            discrete: [],
            hover: {
                size: undefined,
                sizeOffset: 5,
            },
        },
        grid: {
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            type: "category",
            categories: dates,
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            title: {
                text: "Number of Registrations",
                style: {
                    fontSize: "12px",
                    color: "#64748b",
                },
            },
            min: 0,
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " registrations";
                },
            },
        },
    };

    // Final verification before creating chart - use the verified element
    if (!finalChartElement || !document.body.contains(finalChartElement)) {
        console.error('Chart element not in DOM before creating chart');
        return;
    }

    try {
        // Create chart with the verified element reference - same simple pattern as programme dashboard
        chartInstance = new ApexCharts(finalChartElement, options);
        chartInstance.render();
        console.log('Chart rendered successfully');
    } catch (e) {
        console.error('Error creating/rendering chart:', e);
        // Clean up on error
        if (chartInstance) {
            try {
                chartInstance.destroy();
            } catch (destroyError) {
                console.error('Error destroying chart on error:', destroyError);
            }
            chartInstance = null;
        }
    }
}

// Make function globally available for Alpine.js
window.renderRegistrationChart = renderChart;

// Initialize chart when DOM is ready
let isInitializing = false;
let retryCount = 0;
const maxRetries = 5;

function initializeChart() {
    // Prevent multiple simultaneous initializations
    if (isInitializing) {
        return;
    }

    const chartElement = document.querySelector("#registrationTrendsChart");
    
    if (!chartElement) {
        retryCount++;
        if (retryCount < maxRetries) {
            console.log(`Chart element not found, retrying... (${retryCount}/${maxRetries})`);
            setTimeout(initializeChart, 500);
        } else {
            console.error('Chart element not found after max retries');
            retryCount = 0;
        }
        return;
    }

    // Reset retry count on success
    retryCount = 0;
    isInitializing = true;
    console.log('Initializing chart...');

    currentChartElement = chartElement;
    currentChartPeriod = chartElement.getAttribute('data-period');
    
    try {
        renderChart();
    } catch (e) {
        console.error('Error in initializeChart:', e);
    } finally {
        isInitializing = false;
    }
    
    // Setup observer on the chart element
    setupObserver(chartElement);

    // Also observe parent container for when Livewire replaces the element
    const parentContainer = chartElement.parentElement;
    if (parentContainer) {
        const parentObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    const newChartElement = document.querySelector("#registrationTrendsChart");
                    if (newChartElement) {
                        // Check if it's a different element (new instance) by comparing
                        // We can check if the data-period changed or if it's truly a new element
                        const newPeriod = newChartElement.getAttribute('data-period');
                        const oldPeriod = currentChartPeriod;
                        
                        if (newChartElement !== currentChartElement || (newPeriod && newPeriod !== oldPeriod)) {
                            console.log('Chart element replaced/updated by Livewire, rendering...');
                            // Reset chart instance since element is new or period changed
                            if (chartInstance) {
                                try {
                                    chartInstance.destroy();
                                } catch (e) {
                                    console.error('Error destroying old chart:', e);
                                }
                                chartInstance = null;
                            }
                            lastPeriod = null; // Reset period to force re-render
                            currentChartElement = newChartElement;
                            currentChartPeriod = newPeriod;
                            setTimeout(() => {
                                renderChart();
                                // Re-setup observer on new element
                                setupObserver(newChartElement);
                            }, 400);
                        }
                    }
                }
            });
        });
        
        parentObserver.observe(parentContainer, {
            childList: true,
            subtree: true
        });
    }
}

// Setup observer function that can be called on new elements
let currentObserver = null;
function setupObserver(chartElement) {
    if (!chartElement) return;
    
    // Disconnect previous observer if it exists
    if (currentObserver) {
        currentObserver.disconnect();
    }

    currentChartElement = chartElement;
    currentChartPeriod = chartElement.getAttribute('data-period');
    
    // Use MutationObserver to watch for Livewire updates
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes') {
                if (mutation.attributeName === 'data-trends' || mutation.attributeName === 'data-period') {
                    console.log('Chart data attribute changed, re-rendering...');
                    setTimeout(() => {
                        // Reset lastPeriod to force re-render
                        lastPeriod = null;
                        // Destroy existing chart before re-rendering
                        if (chartInstance) {
                            try {
                                chartInstance.destroy();
                            } catch (e) {
                                console.error('Error destroying chart on attribute change:', e);
                            }
                            chartInstance = null;
                        }
                        renderChart();
                    }, 200);
                }
            }
        });
    });

    // Observe the chart element for changes
    observer.observe(chartElement, {
        attributes: true,
        attributeFilter: ['data-trends', 'data-period'],
        childList: true,
        subtree: true
    });
    
    currentObserver = observer;
}

// Debug: Check if script is loaded
console.log('admin-dashboard-registration-trends.js loaded!');

// Wait until DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing chart...');
    initializeChart();
});

// Listen for Livewire updates
document.addEventListener('livewire:load', () => {
    console.log('Livewire loaded, rendering chart...');
    setTimeout(initializeChart, 100);
});

document.addEventListener('livewire:update', () => {
    console.log('Livewire updated, checking for chart...');
    // Wait longer for Livewire to finish updating the DOM
    setTimeout(() => {
        const chartElement = document.querySelector("#registrationTrendsChart");
        if (chartElement && document.body.contains(chartElement)) {
            console.log('Chart element found after update, re-rendering...');
            // Reset lastPeriod to force re-render with new data
            lastPeriod = null;
            // Destroy existing chart first
            if (chartInstance) {
                try {
                    chartInstance.destroy();
                } catch (e) {
                    console.error('Error destroying chart on update:', e);
                }
                chartInstance = null;
            }
            // Re-render with new data
            renderChart();
            // Re-setup observer in case element was replaced
            setupObserver(chartElement);
        }
    }, 700);
});

// Try to initialize when window loads (fallback) - but only if not already initialized
let hasInitialized = false;
window.addEventListener('load', () => {
    if (!hasInitialized) {
        console.log('Window loaded, checking chart...');
        setTimeout(() => {
            initializeChart();
            hasInitialized = true;
        }, 200);
    }
});

