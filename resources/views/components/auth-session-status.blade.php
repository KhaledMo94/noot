@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success text-center']) }}>
        {{ $status }}
    </div>
@endif
