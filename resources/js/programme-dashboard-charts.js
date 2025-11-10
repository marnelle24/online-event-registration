import ApexCharts from 'apexcharts';

const charts = {};

const defaultOptions = {
    chart: {
        fontFamily: 'Satoshi, sans-serif',
        height: 320,
        type: 'area',
        toolbar: { show: false },
        animations: { enabled: true },
    },
    dataLabels: { enabled: false },
    stroke: {
        width: 2,
        curve: 'smooth',
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.45,
            opacityTo: 0.05,
            stops: [20, 100],
        },
    },
    markers: {
        size: 4,
        strokeWidth: 2,
    },
    grid: {
        strokeDashArray: 4,
    },
    xaxis: {
        type: 'category',
        axisTicks: { show: false },
        axisBorder: { show: false },
    },
    yaxis: {
        labels: {
            formatter: (value) => value,
        },
    },
    tooltip: {
        shared: true,
        intersect: false,
    },
};

const ensureChart = (chartId, overrides) => {
    const element = document.getElementById(chartId);
    if (!element) {
        return null;
    }

    if (charts[chartId]) {
        charts[chartId].updateOptions(overrides);
        return charts[chartId];
    }

    const options = {
        ...defaultOptions,
        ...overrides,
    };

    const chart = new ApexCharts(element, options);
    charts[chartId] = chart;
    chart.render();
    return chart;
};

window.addEventListener('programme-registration-trend-data', (event) => {
    const { chartId, series, categories } = event.detail || {};
    if (!chartId) {
        return;
    }

    ensureChart(chartId, {
        series,
        colors: ['#3C50E0'],
        xaxis: {
            ...defaultOptions.xaxis,
            categories,
        },
        yaxis: {
            ...defaultOptions.yaxis,
            labels: {
                formatter: (value) => Math.round(value),
            },
        },
    });
});

window.addEventListener('programme-revenue-trend-data', (event) => {
    const { chartId, series, categories } = event.detail || {};
    if (!chartId) {
        return;
    }

    ensureChart(chartId, {
        series,
        colors: ['#16A34A'],
        xaxis: {
            ...defaultOptions.xaxis,
            categories,
        },
        yaxis: {
            ...defaultOptions.yaxis,
            labels: {
                formatter: (value) => `$${Number(value).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`,
            },
        },
        tooltip: {
            y: {
                formatter: (value) => `$${Number(value).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`,
            },
        },
    });
});

