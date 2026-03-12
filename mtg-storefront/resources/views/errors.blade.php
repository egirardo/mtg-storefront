@if ($errors->any())
<div
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
    class="rounded-md border border-red-400 bg-red-50 p-4 mb-5"
>
    <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
            class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
            aria-hidden="true"
            focusable="false">
            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
        </svg>

        <div>
            <h2 class="text-sm font-semibold text-red-800">
                Please fix the following {{ $errors->count() === 1 ? 'error' : $errors->count() . ' errors' }} before continuing:
            </h2>

            <ul class="mt-2 list-disc list-inside space-y-1" aria-label="Error list">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif