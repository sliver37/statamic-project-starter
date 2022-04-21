@php
    $success_redirect = (isset($success_redirect) && !empty($success_redirect)) ? modify($success_redirect)->url() : '/';
    $hide_labels = $hide_labels ?? false;
@endphp

@isset($form_handle)
    @form($form_handle, ['redirect'=> $success_redirect, 'error_redirect' => '', 'allow_request_redirect' => true, 'class' => $form_wrapper_class ?? ''])
        <input type="hidden" name="honeypot" />

        <div class="inputs-wrapper {{ $inputs_wrapper_class }}">
            @formfields($form_handle)
                @php
                    $validation = $field['validate'] ?? [];
                @endphp
                <div class="input-group flex-grow">
                    <label>
                        @if(!$hide_labels)
                            {{ $field['display'] }}
                            @if(in_array("required", $validation))<span class="text-tertiary">*</span>@endif
                        @endif {{-- <span class="text-tertiary font-sm">*</span> --}} </label>
                    @switch($field['type'])
                        @case('select')
                            {{-- default browser select
                                <select name="{{ $field['handle'] }}">
                                @foreach($field['options'] as $key=>$val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select> --}}
                            <styled-select name="{{ $field['handle'] }}" :data="{{ json_encode($field['options']) }}"></styled-select>
                            @break
                        @case('textarea')
                            <textarea class="{{ $input_class }}" name="{{ $field['handle'] ?? null }}" placeholder="{{ $field['placeholder'] ?? '' }}"></textarea>
                            @break
                        @case('checkboxes') @case('radio')
                            @foreach($field['options'] ?? [] as $key=>$val)
                                {{-- Vue Component --}}
                                <component is="{{ rtrim($field['type'], 'es') }}" :option="[ '{{ $key }}', '{{ $val }}' ]" :options="{'{{ $key }}':'{{ $val }}'}" handle="{{ $field['handle'] }}"></component>
                            @endforeach
                            @break
                        @case('assets')
                            <input class="{{ $input_class }}" type="file" name="{{ $field['handle'] }}" />
                            @break
                        @default
                            <input class="{{ $input_class }}" type="{{ $field['input_type'] ?? 'text' }}" name="{{ $field['handle'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" />
                    @endswitch
                    @error($field['handle'], "form.{$form_handle}")
                        <div class="text-tertiary">{{ $message }}</div>
                    @enderror
                </div>
            @endformfields
            @antlers('@{{ captcha }}')

        </div>
        <div class="flex gap-6 items-center mt-6">
            <button class="btn w-max {{ $button_class }}"><span>{{ $button_text }}</span></button>
            <span>Required <span class="text-tertiary">*</span></span>
        </div>
    @endform
@endisset
