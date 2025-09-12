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
    public $newDocuments = []; // Pour les nouveaux fichiers

    protected $rules = [
        'title' => 'required|string|max:255',
        'comment' => 'nullable|string',
        'newDocuments.*' => 'file|max:10240|mimes:pdf,jpg,jpeg,png'
    ];

    public function updatedNewDocuments()
    {
        // Ajouter les nouveaux fichiers au tableau existant
        foreach ($this->newDocuments as $newDoc) {
            $this->documents[] = $newDoc;
        }

        // Réinitialiser le champ d'upload
        $this->newDocuments = [];
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'documents' => 'required|min:1', // Au moins un document requis
        ], [
            'documents.required' => 'Vous devez joindre au moins une pièce justificative.',
            'documents.min' => 'Vous devez joindre au moins une pièce justificative.',
        ]);

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
