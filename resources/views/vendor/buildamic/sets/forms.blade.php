@extends('buildamic::layouts.set')

@php
   $data = $set->value()->value();
   $title = $data['title'] ?? null;
   $form_handle = $data['form'] ?? false;
   $button_text = $data['button_text'] ?? 'Send';
   $success_redirect = $data['success_redirect'] ?? '';
   $inputs_wrapper_class = $data['inputs_wrapper_class'] ?? '';
   $input_class = $data['input_class'] ?? '';
   $form_wrapper_class = $data['form_wrapper_class'] ?? '';
   $button_class = $data['button_class'] ?? '';
   $hide_labels = $data['hide_labels'] ?? false;
@endphp

@section('set_content')
    @isset($title)
        <h3>{{ $title }}</h3>
    @endisset
    @if($form_handle)
        @component('components.form', [
            "success_redirect" => $success_redirect,
            "button_text" => $button_text,
            "inputs_wrapper_class" => $inputs_wrapper_class,
            "input_class" => $input_class,
            "form_wrapper_class" => $form_wrapper_class,
            "button_class" => $button_class,
            "hide_labels" => $hide_labels,
            "form_handle" => $form_handle
            ]
        )@endcomponent
    @else
        <p>No form was linked inside the forms component, please link one.</p>
    @endif
@overwrite
