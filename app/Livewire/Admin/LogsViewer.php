<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LogsViewer extends Component
{
    public $logs = [];
    public $selectedLevel = 'all';
    public $searchTerm = '';
    public $page = 1;
    public $perPage = 50;
    public $totalLines = 0;
    public $logFile = 'laravel.log';

    protected $logLevels = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];

    public function mount()
    {
        $this->loadLogs();
    }

    public function updatedSelectedLevel()
    {
        $this->page = 1;
        $this->loadLogs();
    }

    public function updatedSearchTerm()
    {
        $this->page = 1;
        $this->loadLogs();
    }

    public function loadLogs()
    {
        $logPath = storage_path('logs/' . $this->logFile);

        if (!File::exists($logPath)) {
            $this->logs = [];
            $this->totalLines = 0;
            return;
        }

        $file = File::get($logPath);
        $lines = explode("\n", $file);
        $this->totalLines = count($lines);

        // Filter logs based on level and search term
        $filteredLines = collect($lines)->filter(function ($line) {
            if (empty(trim($line))) {
                return false;
            }

            // Filter by level
            if ($this->selectedLevel !== 'all') {
                $levelPattern = '/\[' . preg_quote($this->selectedLevel, '/') . '\]/i';
                if (!preg_match($levelPattern, $line)) {
                    return false;
                }
            }

            // Filter by search term
            if (!empty($this->searchTerm)) {
                if (stripos($line, $this->searchTerm) === false) {
                    return false;
                }
            }

            return true;
        })->values();

        // Paginate
        $skip = ($this->page - 1) * $this->perPage;
        $this->logs = $filteredLines->slice($skip, $this->perPage)->toArray();
    }

    public function nextPage()
    {
        if ($this->page < $this->totalPages) {
            $this->page++;
            $this->loadLogs();
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadLogs();
        }
    }

    public function goToPage($page)
    {
        if ($page >= 1 && $page <= $this->totalPages) {
            $this->page = $page;
            $this->loadLogs();
        }
    }

    public function clearLogs()
    {
        $logPath = storage_path('logs/' . $this->logFile);
        if (File::exists($logPath)) {
            File::put($logPath, '');
            $this->loadLogs();
            session()->flash('message', 'Logs cleared successfully!');
        }
    }

    public function refreshLogs()
    {
        $this->loadLogs();
    }

    public function getLogLevelClass($line)
    {
        foreach ($this->logLevels as $level) {
            if (stripos($line, '[' . $level . ']') !== false) {
                return match($level) {
                    'emergency', 'alert', 'critical', 'error' => 'text-red-600 bg-red-50',
                    'warning' => 'text-yellow-600 bg-yellow-50',
                    'notice', 'info' => 'text-blue-600 bg-blue-50',
                    'debug' => 'text-gray-600 bg-gray-50',
                    default => 'text-gray-600 bg-gray-50',
                };
            }
        }
        return 'text-gray-600 bg-gray-50';
    }

    public function getTotalPagesProperty()
    {
        $filteredCount = $this->getFilteredCount();
        return max(1, ceil($filteredCount / $this->perPage));
    }

    private function getFilteredCount()
    {
        $logPath = storage_path('logs/' . $this->logFile);
        if (!File::exists($logPath)) {
            return 0;
        }

        $file = File::get($logPath);
        $lines = explode("\n", $file);

        $filteredLines = collect($lines)->filter(function ($line) {
            if (empty(trim($line))) {
                return false;
            }

            if ($this->selectedLevel !== 'all') {
                $levelPattern = '/\[' . preg_quote($this->selectedLevel, '/') . '\]/i';
                if (!preg_match($levelPattern, $line)) {
                    return false;
                }
            }

            if (!empty($this->searchTerm)) {
                if (stripos($line, $this->searchTerm) === false) {
                    return false;
                }
            }

            return true;
        });

        return $filteredLines->count();
    }

    public function render()
    {
        return view('livewire.admin.logs-viewer');
    }
}

