@props(['type' => 'success', 'message' => ''])

@if ($message)
    <div class="my-3 bg-{{ $type === 'success' ? 'green-100' : 'red-100' }} border-l-4 border-{{ $type === 'success' ? 'green-500' : 'red-500' }} text-{{ $type === 'success' ? 'green-800' : 'red-800' }} px-4 py-3 rounded-md flex items-center justify-between shadow-sm" role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-{{ $type === 'success' ? 'green-500' : 'red-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}" />
            </svg>
            <span class="font-medium">{{ $message }}</span>
        </div>
        <button @click="show = false" class="text-{{ $type === 'success' ? 'green-500' : 'red-500' }} hover:text-{{ $type === 'success' ? 'green-700' : 'red-700' }} focus:outline-none">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif
