<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Registrant;
use App\Models\Programme;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class RegistrantManagement extends Component
{
    use WithPagination;
    
    public $search = '';
    public $programmeFilter = '';
    public $paymentStatusFilter = '';
    public $registrationTypeFilter = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    protected $paginationTheme = 'custom-pagination';

    public function mount()
    {
        // Handle initial state from URL parameters if needed
        $this->sortBy = request('sortBy', 'created_at');
        $this->sortDirection = request('sortDirection', 'desc');
        $this->search = request('search', '');
        $this->programmeFilter = request('programmeFilter', '');
        $this->paymentStatusFilter = request('paymentStatusFilter', '');
        $this->registrationTypeFilter = request('registrationTypeFilter', '');
        $this->perPage = request('perPage', 10);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingProgrammeFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingRegistrationTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function sortByConfirmationCode()
    {
        $this->sortBy('confirmationCode');
    }

    public function sortByRegStatus()
    {
        $this->sortBy('regStatus');
    }

    public function sortByFirstName()
    {
        $this->sortBy('firstName');
    }

    public function sortByPaymentStatus()
    {
        $this->sortBy('paymentStatus');
    }

    public function sortByCreatedAt()
    {
        $this->sortBy('created_at');
    }

    public function exportCsv()
    {
        $registrants = $this->getFilteredRegistrants(false); // Get all records without pagination
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="registrants_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($registrants) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Registration Code',
                'Programme',
                'Programme Code',
                'Name',
                'Email',
                'Contact Number',
                'NRIC',
                'Address',
                'City',
                'Postal Code',
                'Payment Status',
                'Payment Amount',
                'Discount Amount',
                'Net Amount',
                'Payment Option',
                'Payment Reference',
                'Registration Type',
                'Registration Status',
                'Confirmation Code',
                'Group Registration ID',
                'Email Status',
                'Registered At',
                'Payment Completed At'
            ]);

            foreach ($registrants as $registrant) {
                fputcsv($file, [
                    $registrant->regCode,
                    $registrant->programme->title ?? 'N/A',
                    $registrant->programme->programmeCode ?? 'N/A',
                    $registrant->title . ' ' . $registrant->firstName . ' ' . $registrant->lastName,
                    $registrant->email,
                    $registrant->contactNumber,
                    $registrant->nric,
                    $registrant->address,
                    $registrant->city,
                    $registrant->postalCode,
                    $registrant->paymentStatus,
                    $registrant->price,
                    $registrant->discountAmount,
                    $registrant->netAmount,
                    $registrant->paymentOption,
                    $registrant->paymentReferenceNo,
                    $registrant->registrationType,
                    $registrant->regStatus,
                    $registrant->confirmationCode,
                    $registrant->groupRegistrationID,
                    $registrant->emailStatus ? 'Sent' : 'Not Sent',
                    $registrant->created_at->format('Y-m-d H:i:s'),
                    $registrant->payment_completed_at ? $registrant->payment_completed_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        // For Excel export, you might want to use a package like Laravel Excel
        // For now, we'll return a CSV with .xlsx extension
        return $this->exportCsv();
    }

    private function getFilteredRegistrants($paginate = true)
    {
        $query = Registrant::with(['programme', 'promocode', 'promotion'])
            ->whereIn('registrationType', ['user', 'guest', NULL])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('firstName', 'like', "%{$this->search}%")
                        ->orWhere('lastName', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('regCode', 'like', "%{$this->search}%")
                        ->orWhere('confirmationCode', 'like', "%{$this->search}%")
                        ->orWhere('contactNumber', 'like', "%{$this->search}%");
                });
            })
            ->when($this->programmeFilter, function ($query) {
                $query->where('programme_id', $this->programmeFilter);
            })
            ->when($this->paymentStatusFilter, function ($query) {
                $query->where('paymentStatus', $this->paymentStatusFilter);
            })
            ->when($this->registrationTypeFilter, function ($query) {
                $query->where('registrationType', $this->registrationTypeFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    public function render()
    {
        $registrants = $this->getFilteredRegistrants();
        $programmes = Programme::select('id', 'title', 'programmeCode')->orderBy('title')->get();
        
        return view('livewire.admin.registrant-management', [
            'registrants' => $registrants,
            'programmes' => $programmes
        ]);
    }
}
