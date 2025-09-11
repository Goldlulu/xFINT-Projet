<?php

namespace App\Livewire\ExpenseReports;

use Livewire\Component;
use App\Models\ExpenseReport;

class MyExpenseReports extends Component
{
    public $selectedReport = null;
    public $showModal = false;

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

    public function render()
    {
        return view('livewire.expense-reports.my-expense-reports', [
            'reports' => auth()->user()->expenseReports()->latest()->get()
        ])->layout('layouts.app');
    }
}
