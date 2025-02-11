<?php

namespace App\Livewire\Contact;

use App\Livewire\Forms\ContactForm;
use Illuminate\View\View;
use Livewire\Component;
use Toaster;

class ContactPage extends Component {

    public ContactForm $form;

    public function submit(): void {
        $this->form->validate();
        // Handle form submission, e.g., send an email or save to the database

        Toaster::success('Gracias por tu mensaje! Te contactaremos lo más pronto posible.');
    }

    public function render(): View {
        return view('livewire.contact.index');
    }
}
