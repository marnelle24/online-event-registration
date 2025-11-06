<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;

class LogsCard extends Component
{
    public array $recentLogs = [];

    public function mount(): void
    {
        $this->loadLogs();
    }

    protected function loadLogs(): void
    {
        $logPath = storage_path('logs/laravel.log');

        if (file_exists($logPath)) {
            $lines = file($logPath);
            $this->recentLogs = array_slice($lines, -20);
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.logs-card');
    }
}


