<div class="relative inline-block text-left">
    <button id="language-dropdown-btn" class="p-0 ml-3 bg-transparent text-white hover:bg-transparent">
        <span class="text-2xl">🌍</span> <!-- Globe Icon -->
    </button>
    <div id="language-dropdown-menu"
        class="dropdown-menu absolute hidden bg-gray-800 text-white rounded-md shadow-lg mt-2 w-32">
        <ul class="py-1">
            <li class="text-left">
                <button wire:click="switchLanguage('en')" class="block w-full px-4 py-2 text-sm hover:bg-gray-700">
                    🇬🇧 English
                </button>
            </li>
            <li class="text-left">
                <button wire:click="switchLanguage('de')" class="block w-full px-4 py-2 text-sm hover:bg-gray-700">
                    🇩🇪 Deutsch
                </button>
            </li>
        </ul>
    </div>
</div>

<script>
    const button = document.querySelector('#language-dropdown-btn');
    const menu = document.querySelector('#language-dropdown-menu');
    const dropdownContainer = document.querySelector('.relative');

    button.addEventListener('click', function(event) {
        menu.classList.toggle('hidden');
        event.stopPropagation();
    });

    document.addEventListener('click', function(event) {
        if (!dropdownContainer.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
