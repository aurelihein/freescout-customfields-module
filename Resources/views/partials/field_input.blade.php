@php
    use Modules\CustomFields\Services\CustomFieldService;
    $options = CustomFieldService::parseOptions($field->options);
@endphp
<div class="cf-field">
    @if ($field->type === 'checkbox')
        {{-- Label sits on the box's own line; a stacked cf-label would leave it orphaned. --}}
        <label class="cf-check">
            <input type="checkbox" name="cf[{{ $field->id }}]" value="1" @if ($value) checked @endif> {{ $field->name }}
        </label>
    @else
    <label class="cf-label">{{ $field->name }}</label>
    @switch($field->type)
        @case('dropdown')
            <select name="cf[{{ $field->id }}]" class="form-control input-sm">
                <option value=""></option>
                @foreach ($options as $opt)
                    <option value="{{ $opt }}" @if ($value === $opt) selected @endif>{{ $opt }}</option>
                @endforeach
            </select>
            @break
        @case('multiselect')
            <select name="cf[{{ $field->id }}][]" class="form-control input-sm" multiple>
                @foreach ($options as $opt)
                    <option value="{{ $opt }}" @if (is_array($value) && in_array($opt, $value)) selected @endif>{{ $opt }}</option>
                @endforeach
            </select>
            @break
        @case('multiline')
            <textarea name="cf[{{ $field->id }}]" class="form-control input-sm" rows="3">{{ $value }}</textarea>
            @break
        @case('number')
            <input type="number" step="any" name="cf[{{ $field->id }}]" class="form-control input-sm" value="{{ $value }}">
            @break
        @case('date')
            <input type="date" name="cf[{{ $field->id }}]" class="form-control input-sm" value="{{ $value }}">
            @break
        @case('tags')
            <input type="text" name="cf[{{ $field->id }}]" class="form-control input-sm" value="{{ is_array($value) ? implode(', ', $value) : '' }}" placeholder="{{ __('Comma-separated') }}">
            @break
        @default
            <input type="text" name="cf[{{ $field->id }}]" class="form-control input-sm" value="{{ $value }}">
    @endswitch
    @endif
</div>
