@php
    $success_redirect = (isset($success_redirect) && !empty($success_redirect)) ? modify($success_redirect)->url() : '/';
@endphp

@isset($form_handle)
    @form($form_handle, ['redirect'=> $success_redirect, 'error_redirect' => '', 'allow_request_redirect' => true,])
        @formfields($form_handle)
            @php
                $validation = $field['validate'] ?? [];
            @endphp
            <div class="input-group">
                <label>{{ $field['display'] }} {{-- <span class="text-secondary font-sm">*</span> --}} @if(in_array("required", $validation))<span class="text-secondary">*</span>@endif</label>
                @switch($field['type'])
                    @case('select')
                    @php


                    @endphp
                        {{-- default browser select
                            <select name="{{ $field['handle'] }}">
                            @foreach($field['options'] as $key=>$val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select> --}}
                        <styled-select name="{{ $field['handle'] }}" :data="{{ json_encode($field['options']) }}"></styled-select>
                        @break
                    @case('textarea')
                        <textarea name="{{ $field['handle'] ?? null }}" placeholder="{{ $field['placeholder'] ?? '' }}"></textarea>
                        @break
                    @case('checkboxes') @case('radio')
                        @foreach($field['options'] ?? [] as $key=>$val)
                            {{-- Vue Component --}}
                            <component is="{{ rtrim($field['type'], 'es') }}" :option="[ '{{ $key }}', '{{ $val }}' ]" :options="{'{{ $key }}':'{{ $val }}'}" handle="{{ $field['handle'] }}"></component>
                        @endforeach
                        @break
                    @case('assets')
                        <input type="file" name="{{ $field['handle'] }}" />
                        @break
                    @default
                        <input type="{{ $field['input_type'] ?? 'text' }}" name="{{ $field['handle'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" />
                @endswitch
                @error($field['handle'], "form.{$form_handle}")
                    <div class="text-secondary">{{ $message }}</div>
                @enderror
            </div>
        @endformfields
        <div class="flex gap-6 items-center mt-6">
            <button class="btn btn--primary w-max"><span>Send</span></button>
            <span>required <span class="text-secondary">*</span></span>
        </div>
    @endform
@endisset
