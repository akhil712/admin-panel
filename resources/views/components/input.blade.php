<div class="form-group mb-3">
    @if (isset($label) && $label != '')
        <div class="d-flex ms-1 justify-content-between align-items-center">
            <label for="{{$id}}" class="mb-1 {{ isset($mandatory) && $mandatory == true ? 'mandatory-field' : '' }}">
                {{ $label }}
            </label>
        </div>
    @endif
    <input type="{{ isset($type) && $type != '' ? $type : 'text' }}" name="{{ $name }}"
        class="form-control {{ isset($mandatory) && $mandatory == true ? 'validate' : '' }} {{ isset($class) ? $class : '' }}"
        id="{{ $id }}" value="{{ $value }}" maxlength="{{ $maxlength ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}"
        @isset($min)
            min="{{ $min }}"
        @endisset
        @isset($max)
            max="{{ $max }}"
        @endisset
        {{ $otherattr ?? '' }} {{ isset($readonly) && $readonly == true ? 'readonly' : '' }}>
        <span class="text-danger error-msg"></span>
</div>
