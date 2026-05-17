@if ($errors->any())
    <div role="alert" class="alert alert-error mb-5 border border-error/30 bg-error/10 text-sm text-error">
        <span>{{ $errors->first() }}</span>
    </div>
@endif

@if (session('status'))
    <div role="status" class="alert alert-success mb-5 border border-success/30 bg-success/10 text-sm text-success">
        <span>{{ session('status') }}</span>
    </div>
@endif
