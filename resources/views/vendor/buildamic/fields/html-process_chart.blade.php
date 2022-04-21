@php
    $steps = \Statamic\Facades\Entry::query()->where('collection', 'process')->orderBy('order')->get();
@endphp

@extends('buildamic::layouts.field', ['class' => 'w-full'])

@section('field_content')
    <process-chart :steps="{{ json_encode($steps->toAugmentedArray()) }}"></process-chart>
@overwrite
