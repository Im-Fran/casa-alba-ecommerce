<?php

namespace App\Livewire\Contact;

use App\Livewire\Forms\ContactForm;
use Illuminate\View\View;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class ContactPage extends Component {

    use WireToast;

    public ContactForm $form;

    public function submit(): void {
        // Handle form submission, e.g., send an email or save to the database

        toast()
            ->success('Gracias por tu mensaje! Te contactaremos lo más pronto posible.')
            ->push();
    }

    public function render(): View {
        return view('livewire.contact.index');
    }
}
