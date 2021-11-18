@extends('buildamic::layouts.set')

@php
   $data = $set->value()->value();
   $form_handle = $data['form'] ?? false;
   $success_redirect = $data['success_redirect'] ?? '';
@endphp

@section('set_content')
    @if($form_handle)
        @component('buildamic::components.form', ["success_redirect" => $success_redirect, "form_handle" => $form_handle])@endcomponent
    @else
        <p>No form was linked inside the forms component, please link one.</p>
    @endif
@overwrite
