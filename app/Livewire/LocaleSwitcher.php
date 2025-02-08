<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Middleware;

class LocaleSwitcher extends Component
{
    #[Middleware('auth')]
    public function switchLanguage($locale)
    {
        if (!in_array($locale, ['en', 'de'])) {
            abort(400);
        }

        Session::put('locale', $locale);

        return redirect()->route('form-builder');
    }

    public function render()
    {
        return view('livewire.locale-switcher')->layout('layouts.app');
    }

}
