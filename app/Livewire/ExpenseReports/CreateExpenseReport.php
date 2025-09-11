<?php

namespace App\Livewire\ExpenseReports;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ExpenseReport;
class CreateExpenseReport extends Component
{
    use WithFileUploads;
    public $title;
    public $comment;
    public $documents = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'comment' => 'nullable|string',
        'documents.*' => 'file|max:10240|mimes:pdf,jpg,jpeg,png'
    ];

    public function save()
    {
        $this->validate();

        $report = auth()->user()->expenseReports()->create([
            'title' => $this->title,
            'comment' => $this->comment,
        ]);

        foreach ($this->documents as $document) {
            $filename = $document->store('expense-documents');

            $report->documents()->create([
                'filename' => $filename,
                'original_name' => $document->getClientOriginalName(),
                'mime_type' => $document->getMimeType(),
                'size' => $document->getSize(),
            ]);
        }

        session()->flash('message', 'Note de frais créée avec succès!');
        return redirect()->route('my-expense-reports');
    }

    public function render()
    {
        return view('livewire.expense-reports.create-expense-report')
            ->layout('layouts.app');
    }
}
