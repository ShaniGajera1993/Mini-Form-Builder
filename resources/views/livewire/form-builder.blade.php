<div x-data="{
    formConfig: @entangle('formConfig'),
    showFieldMenu: false,
    searchTerm: '',
    showPreview: false,
    filteredFieldTypes: ['text', 'button', 'select', 'radio', 'checkbox'],
    notifications: [],

    addNotification(message, type = 'error') {
        const id = Date.now();
        this.notifications.push({ id, message, type });
        setTimeout(() => {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }, 3000);
    },

    addField(type) {
        if (this.isValidField('New Field', 'Enter value') && this.isValidTitle(this.formConfig.title)) {
            this.formConfig.fields.push({
                id: crypto.randomUUID(),
                type: type,
                label: 'New Field',
                placeholder: 'Enter value',
                required: false,
                options: []
            });
            this.showFieldMenu = false;
        }
    },

    removeField(id) {
        this.formConfig.fields = this.formConfig.fields.filter(field => field.id !== id);
    },

    updateField(id, updates) {
        const fieldIndex = this.formConfig.fields.findIndex(field => field.id === id);
        if (fieldIndex !== -1) {
            this.formConfig.fields[fieldIndex] = { ...this.formConfig.fields[fieldIndex], ...updates };
        }
    },

    isValidField(label, placeholder) {
        const regex = /^[a-zA-Z ]+$/;
        return label && placeholder && regex.test(label) && regex.test(placeholder);
    },

    isValidTitle(title) {
        const regex = /^[a-zA-Z ]+$/;
        return title && regex.test(title);
    },

    validateForm() {
        let valid = true;
        if (!this.isValidTitle(this.formConfig.title)) {
            valid = false;
            this.addNotification('Please ensure the form has a valid title.');
        }
        this.formConfig.fields.forEach(field => {
            if (!field.label || !field.placeholder || !this.isValidField(field.label, field.placeholder)) {
                valid = false;
                this.addNotification('Please ensure all fields have a valid label and placeholder.');
            }
        });
        if (this.formConfig.fields.length === 0) {
            valid = false;
            this.addNotification('Please add at least one field to the form.');
        }
        if (this.formConfig.fields.some(field => field.type === 'select' && field.options.length < 2)) {
            valid = false;
            this.addNotification('Select fields must have at least two options.');
        }
        if (this.formConfig.fields.some(field => field.type === 'radio' && field.options.length < 2)) {
            valid = false;
            this.addNotification('Radio buttons must have at least two options.');
        }
        return valid;
    },

    publishForm() {
        if (this.validateForm()) {
            this.addNotification('Form Published Successfully!', 'success');
            @this.call('publishForm');
        }
    }
}" class="flex min-h-screen bg-gray-50">
    <div class="fixed left-1/2 transform -translate-x-1/2 space-y-2 z-50">
        <template x-for="notification in notifications" :key="notification.id">
            <div class="px-4 py-2 rounded-md shadow-md text-white text-sm"
                :class="notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'" x-text="notification.message">
            </div>
        </template>
    </div>
    <div class="flex-1">
        <div class="max-w-5xl mx-auto p-8">
            <div class="flex justify-between items-center mb-6 flex-wrap">
                <!-- Breadcrumb Section -->
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="#" class="text-blue-600 hover:underline">My Forms</a>
                    <span>/</span>
                    <span>Create New Form</span>
                </div>

                <!-- Button Section -->
                <div class="flex gap-2 mt-4 sm:mt-0 w-full sm:w-auto justify-between sm:justify-start">
                    <!-- Preview Button -->
                    <button x-on:click="showPreview = true"
                        class="px-2 py-1 sm:px-4 sm:py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 items-center gap-2 w-full sm:w-auto">
                        Preview
                    </button>
                    <!-- Publish Button -->
                    <button x-on:click="publishForm"
                        class="px-2 py-1 sm:px-4 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-full sm:w-auto">
                        Publish Form
                    </button>
                </div>
            </div>


            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <input x-model="formConfig.title"
                            class="text-2xl font-medium text-gray-800 w-full border-none focus:outline-none focus:ring-0 mb-6"
                            placeholder="Untitled Form" />

                        <div class="space-y-4">
                            <template x-for="field in formConfig.fields" :key="field.id">
                                <div
                                    class="bg-white border border-gray-200 rounded-md p-4 hover:border-blue-500 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <input x-model="field.label"
                                                class="text-base font-medium text-gray-800 w-full border-none focus:outline-none focus:ring-0"
                                                placeholder="Field Label" />
                                            <input x-model="field.placeholder"
                                                class="mt-2 text-sm text-gray-500 w-full border-none focus:outline-none focus:ring-0"
                                                placeholder="Enter placeholder text" />
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button x-on:click="removeField(field.id)"
                                                class="p-1 text-gray-400 hover:text-red-500">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div x-show="field.type === 'select'" class="mt-4 p-4">
                                        <label
                                            class="text-base font-medium text-gray-800 w-full border-none focus:outline-none focus:ring-0">Options</label>
                                        <div>
                                            <template x-for="(option, index) in field.options" :key="index">
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <input type="text" x-model="field.options[index]"
                                                        class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm"
                                                        placeholder="Option" />
                                                    <button x-on:click="field.options.splice(index, 1)"
                                                        class="p-1 text-gray-400 hover:text-red-500">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        <button x-on:click="field.options.push('')"
                                            class="text-blue-600 text-sm mt-2 hover:bg-blue-50 px-4 py-2 rounded-md">
                                            Add Option
                                        </button>
                                    </div>
                                    <div x-show="field.type === 'radio'" class="mt-4 p-4">
                                        <label class="block text-sm text-gray-600 mb-2">Options</label>
                                        <div>
                                            <template x-for="(option, index) in field.options" :key="index">
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <input type="text" x-model="field.options[index]"
                                                        class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm"
                                                        placeholder="Option" />
                                                    <button x-on:click="field.options.splice(index, 1)"
                                                        class="p-1 text-gray-400 hover:text-red-500">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        <button x-on:click="field.options.push('')"
                                            class="text-blue-600 text-sm mt-2 hover:bg-blue-50 px-4 py-2 rounded-md">
                                            Add Option
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="relative mt-6">
                            <button x-on:click="showFieldMenu = !showFieldMenu"
                                class="w-full px-4 py-3 text-sm text-blue-600 border border-dashed border-blue-300 rounded-md hover:bg-blue-50 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5h6M9 12h6M9 19h6" />
                                </svg>
                                Add New Field
                            </button>

                            <div x-show="showFieldMenu"
                                class="absolute left-0 right-0 mt-2 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                                <div class="p-2">
                                    <div class="relative">
                                        <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16h12M8 12h12M8 8h12" />
                                        </svg>
                                        <input type="text" x-model="searchTerm"
                                            class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                            placeholder="Search field type..." />
                                    </div>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <template
                                        x-for="type in filteredFieldTypes.filter(field => field.toLowerCase().includes(searchTerm.toLowerCase()))"
                                        :key="type">
                                        <button x-on:click="addField(type)"
                                            class="w-full px-4 py-2 text-sm text-left hover:bg-gray-50 flex items-center gap-2">
                                            <span x-text="type.charAt(0).toUpperCase() + type.slice(1)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-medium text-gray-800 mb-4">Form Style</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Background Color</label>
                                <div class="flex gap-2">
                                    <template
                                        x-for="color in ['#ffffff', '#f3f4f6', '#fef2f2', '#ecfdf5', '#eff6ff', '#faf5ff']"
                                        :key="color">
                                        <button x-on:click="formConfig.style.backgroundColor = color"
                                            :class="{
                                                'ring-2 ring-blue-500 ring-offset-2': formConfig.style
                                                    .backgroundColor ===
                                                    color
                                            }"
                                            class="w-6 h-6 rounded-full border"
                                            :style="{ backgroundColor: color }"></button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Font Family</label>
                                <select x-model="formConfig.style.fontFamily"
                                    class="w-full rounded-md border-gray-300 text-sm">
                                    <option value="Roboto">Roboto</option>
                                    <option value="Inter">Inter</option>
                                    <option value="Poppins">Poppins</option>
                                </select>
                            </div>

                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" x-model="formConfig.style.showLabels"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    <span class="text-sm text-gray-600">Show Labels</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Preview Modal -->
    <div x-show="showPreview" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Form Preview</h2>
                <button x-on:click="showPreview = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Form Title: <span x-text="formConfig.title"></span>
                    </h3>
                    <div class="space-y-4">
                        <template x-for="field in formConfig.fields" :key="field.id">
                            <div class="space-y-1">
                                <template x-if="formConfig.style.showLabels">
                                    <label class="block text-sm font-medium text-gray-700"
                                        x-text="field.label"></label>
                                </template>
                                <template x-if="field.type === 'text'">
                                    <input type="text" :placeholder="field.placeholder"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </template>
                                <template x-if="field.type === 'select'">
                                    <select
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="" class="text-sm text-gray-500">Select an option</option>
                                        <template x-for="option in field.options" :key="option">
                                            <option :value="option" x-text="option"
                                                class="text-sm text-gray-800">
                                            </option>
                                        </template>
                                    </select>
                                </template>
                                <template x-if="field.type === 'checkbox'">
                                    <input type="checkbox"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                </template>
                                <template x-if="field.type === 'radio'">
                                    <div class="space-y-2 mt-2">
                                        <template x-for="(option, index) in field.options" :key="index">
                                            <label class="block text-sm text-gray-700">
                                                <input type="radio" :name="field.id" :value="option"
                                                    class="mr-2 leading-tight text-blue-600 focus:ring-blue-500 border-gray-300" />
                                                <span x-text="option" class="text-sm text-gray-800"></span>
                                            </label>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
