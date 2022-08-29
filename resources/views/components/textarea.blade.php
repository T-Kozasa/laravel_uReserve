@props(['disabled' => false])

{{-- vender/laravel/jetstream/resouces/viwes/components/input.blade.phpからコピー --}}
<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
    {{$slot}}
</textarea>
