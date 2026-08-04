<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:100')]
    public string $name = '';

    #[Validate('nullable|max:140')]
    public ?string $organization = '';

    #[Validate('required')]
    public string $role = '';

    #[Validate('required')]
    public string $area = '';

    #[Validate('required|email|max:160')]
    public string $email = '';

    #[Validate('required|min:20|max:2000')]
    public string $message = '';

    public bool $sent = false;

    public function submit(): void
    {
        Inquiry::create($this->validate());
        $this->reset(['name', 'organization', 'role', 'area', 'email', 'message']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
