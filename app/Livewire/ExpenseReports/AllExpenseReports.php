<?php

namespace App\Livewire\ExpenseReports;

use Livewire\Component;
use App\Models\ExpenseReport;

class AllExpenseReports extends Component
{
    // Variables pour les modals
    public $selectedReport = null;
    public $showModal = false;
    public $showValidationModal = false;
    public $showRejectionModal = false;
    public $rejectionComment = '';
    public $reportToValidate = null;
    public $statusFilter = '';

    public function viewReport($reportId)
    {
        $this->selectedReport = ExpenseReport::with(['documents', 'user'])->findOrFail($reportId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReport = null;
    }

    public function showValidateModal($reportId)
    {
        $this->reportToValidate = $reportId;
        $this->showValidationModal = true;
    }

    public function closeValidationModal()
    {
        $this->showValidationModal = false;
        $this->reportToValidate = null;
    }

    public function showRejectModal($reportId)
    {
        $this->reportToValidate = $reportId;
        $this->rejectionComment = '';
        $this->showRejectionModal = true;
    }

    public function closeRejectionModal()
    {
        $this->showRejectionModal = false;
        $this->reportToValidate = null;
        $this->rejectionComment = '';
    }

    public function validateReport()
    {
        if ($this->reportToValidate) {
            $report = ExpenseReport::findOrFail($this->reportToValidate);
            $report->update(['status' => 'validated']);
            session()->flash('message', 'Note de frais validée!');
            $this->closeValidationModal();
        }
    }

    public function rejectReport()
    {
        if ($this->reportToValidate) {
            $report = ExpenseReport::findOrFail($this->reportToValidate);
            $report->update([
                'status' => 'rejected',
                'manager_comment' => $this->rejectionComment
            ]);
            session()->flash('message', 'Note de frais refusée!');
            $this->closeRejectionModal();
        }
    }

    public function processReport($reportId)
    {
        $report = ExpenseReport::findOrFail($reportId);
        $report->update(['status' => 'processed']);
        session()->flash('message', 'Note de frais traitée!');
    }

    public function render()
    {
        $query = ExpenseReport::with(['user', 'documents']);

        // Si comptabilité, ne voir que les notes validées/traitées
        if (auth()->user()->hasRole('accounting')) {
            $query->whereIn('status', ['validated', 'processed']);
        }

        // Filtrer par statut si spécifié
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.expense-reports.all-expense-reports', [
            'reports' => $query->latest()->get()
        ])->layout('layouts.app');
    }
}
