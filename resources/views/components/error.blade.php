
@props([
    'name' => 'required'
])

@error($name)
    <div class="alert alert-error my-1">
        {{ $message }}
    </div>
@enderror
