<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Middleware;

#[Middleware('web')]
class LocaleSwitcher extends Component
{
    public $locale;

    public function mount()
    {
        $this->locale = Session::get('user_locale', App::getLocale());
        App::setLocale($this->locale);
    }

    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'de'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            $this->locale = $locale;
            $this->redirect(request()->header('Referer') ?? route('form-builder'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.locale-switcher')->layout('layouts.app');
    }

}
