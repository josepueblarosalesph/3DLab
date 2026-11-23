<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;

class ProjectIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.project-index', ['projects' => Project::orderBy('id')->get()])
            ->layout('components.layouts.admin', ['title' => 'Proyectos']);
    }
}
