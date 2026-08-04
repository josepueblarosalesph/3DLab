<?php

namespace App\Livewire\Admin;

use App\Models\Inquiry;
use Livewire\Component;
use Livewire\WithPagination;

class InquiryIndex extends Component
{
    use WithPagination;

    public function markRead(int $id): void
    {
        Inquiry::whereKey($id)->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.admin.inquiry-index', [
            'inquiries' => Inquiry::latest()->paginate(12),
        ])->layout('components.layouts.admin', ['title' => 'Consultas']);
    }
}
