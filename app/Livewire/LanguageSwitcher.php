<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public array $languages = [];

    public string $currentLocale;

    public array $languagesFull = [];

    public function mount()
    {
        $this->currentLocale = session('landing_locale', config('app.landing_locale'));

        $allLanguages = [
            'en' => ['flag' => '🇺🇸', 'label' => 'messages.landing.languages.english'],
            'es' => ['flag' => '🇪🇸', 'label' => 'messages.landing.languages.spanish'],
            'fr' => ['flag' => '🇫🇷', 'label' => 'messages.landing.languages.french'],
            'de' => ['flag' => '🇩🇪', 'label' => 'messages.landing.languages.german'],
            'ru' => ['flag' => '🇷🇺', 'label' => 'messages.landing.languages.russian'],
            'ar' => ['flag' => '🇸🇦', 'label' => 'messages.landing.languages.arabic'],
            'da' => ['flag' => '🇩🇰', 'label' => 'messages.landing.languages.danish'],
            'nl' => ['flag' => '🇳🇱', 'label' => 'messages.landing.languages.dutch'],
            'it' => ['flag' => '🇮🇹', 'label' => 'messages.landing.languages.italian'],
            'ja' => ['flag' => '🇯🇵', 'label' => 'messages.landing.languages.japanese'],
            'pl' => ['flag' => '🇵🇱', 'label' => 'messages.landing.languages.polish'],
            'pt' => ['flag' => '🇵🇹', 'label' => 'messages.landing.languages.portuguese'],
        ];

        $this->languagesFull = $allLanguages;

        $this->languages = Arr::except($allLanguages, $this->currentLocale);
    }

    public function getLanguageLabelProperty()
    {
        return $this->languagesFull[$this->currentLocale] ?? ['flag' => '🌐', 'label' => 'Unknown'];
    }

    public function switchLanguage($locale)
    {
        $this->currentLocale = $locale;
        App::setLocale($locale);
        session()->put('landing_locale', $locale);

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
