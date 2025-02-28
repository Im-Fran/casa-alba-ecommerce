<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccountPage extends Component
{
    public $form = [
        'name' => '',
        'last_name' => '',
        'email' => '',
        'current_password' => '',
        'new_password' => '',
        'new_password_confirmation' => '',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->form['name'] = $user->name;
        $this->form['last_name'] = $user->last_name;
        $this->form['email'] = $user->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.last_name' => 'required|string|max:255',
            'form.email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $this->form['name'],
            'last_name' => $this->form['last_name'],
            'email' => $this->form['email'],
        ]);

        $this->dispatch('notify', [
            'message' => 'Perfil actualizado correctamente',
            'type' => 'success'
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'form.current_password' => 'required|current_password',
            'form.new_password' => 'required|min:8|confirmed',
            'form.new_password_confirmation' => 'required'
        ]);

        Auth::user()->update([
            'password' => bcrypt($this->form['new_password'])
        ]);

        $this->form['current_password'] = '';
        $this->form['new_password'] = '';
        $this->form['new_password_confirmation'] = '';

        $this->dispatch('notify', [
            'message' => 'Contraseña actualizada correctamente',
            'type' => 'success'
        ]);
    }

}
