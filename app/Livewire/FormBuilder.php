<?php

namespace App\Livewire;

use App\Models\Form;
use App\Models\FormField;
use Livewire\Component;

class FormBuilder extends Component
{
    public $formConfig = [
        'id' => null,
        'title' => '',
        'fields' => [],
        'style' => [
            'backgroundColor' => '#ffffff',
            'fontFamily' => 'Roboto',
            'showLabels' => true,
        ],
    ];

    public function mount()
    {
        $this->formConfig['title'] = __('form.form_title');
    }

    public function render()
    {
        return view('livewire.form-builder')->layout('layouts.app');
    }

    public function publishForm()
    {
        $form = Form::create([
            'title' => $this->formConfig['title'],
            'style' => $this->formConfig['style'],
        ]);

        foreach ($this->formConfig['fields'] as $field) {
            FormField::create([
                'form_id' => $form->id,
                'type' => $field['type'],
                'label' => $field['label'],
                'placeholder' => $field['placeholder'],
                'required' => $field['required'],
                'options' => in_array($field['type'], ['select', 'radio']) ? $field['options'] : null,
            ]);
        }

        session()->flash('message', 'Form Published Successfully!');
    }
}
