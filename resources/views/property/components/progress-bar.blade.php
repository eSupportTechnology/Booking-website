@php
$steps = [
    1 => 'Type',
    2 => 'Basic Info', 
    3 => 'Details',
    4 => 'Host Profile',
    5 => 'Photos',
    6 => 'Pricing',
    7 => 'Review'
];
@endphp

<div class="mb-8">
    <div class="flex items-center justify-between">
        @foreach($steps as $stepNumber => $stepName)
        <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                    {{ $stepNumber <= $currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                    {{ $stepNumber }}
                </div>
                <span class="ml-2 text-sm font-medium {{ $stepNumber <= $currentStep ? 'text-blue-600' : 'text-gray-500' }}">
                    {{ $stepName }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="flex-1 h-0.5 mx-4 {{ $stepNumber < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>