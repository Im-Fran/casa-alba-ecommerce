<?php

namespace App\Livewire\Contact;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class ContactPage extends Component {
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'message' => ['required', 'string', 'max:5000'],
    ];

    public function submit(): void {
        $this->validate();

        // Handle form submission, e.g., send an email or save to the database

        session()->flash('message', 'Thank you for your message. We will get back to you soon.');
    }

    public function render(): Application|Factory|IlluminateView|View {
        return view('livewire.contact.index');
    }
}
