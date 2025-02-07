<div class="flex items-center">
    <button wire:click="setLocale('en')" class="ml-4 px-2 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-700">
        {{ __('EN') }}
    </button>
    <button wire:click="setLocale('de')" class="ml-2 px-2 py-1 bg-gray-600 text-white rounded-md hover:bg-gray-700">
        {{ __('DE') }}
    </button>
</div>
