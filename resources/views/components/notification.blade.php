@props(['type' => 'success', 'message'])

@if($message)
    <div class="fixed bottom-4 right-4 z-50">
        <div class="{{ 
            $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
            ($type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 'bg-blue-100 border-blue-400 text-blue-700')
        }} border-l-4 px-4 py-3 rounded-lg shadow-lg max-w-xs" role="alert">
            <div class="flex items-center">
                <div class="py-1">
                    @if($type === 'success')
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    @elseif($type === 'error')
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    @else
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    @endif
                </div>
                <div>
                    <p class="text-sm">{{ $message }}</p>
                </div>
                <button type="button" class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif