<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registrationForm">
        @csrf

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Select Role')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="toggleCollegeName()">
                <option value="">-- Select Role --</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Lab Manager (User)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- College Name (Only for Lab Manager) -->
        <div class="mt-4" id="collegeNameField" style="display: none;">
            <x-input-label for="college_name" :value="__('College Name')" />
            <x-text-input id="college_name" class="block mt-1 w-full" type="text" name="college_name" :value="old('college_name')" autocomplete="organization" />
            <x-input-error :messages="$errors->get('college_name')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Required for Lab Manager role</p>
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone (Optional)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleCollegeName() {
            const role = document.getElementById('role').value;
            const collegeNameField = document.getElementById('collegeNameField');
            const collegeNameInput = document.getElementById('college_name');
            
            if (role === 'user') {
                collegeNameField.style.display = 'block';
                collegeNameInput.required = true;
            } else {
                collegeNameField.style.display = 'none';
                collegeNameInput.required = false;
                collegeNameInput.value = '';
            }
        }

        // Show college name field if role is already selected (on page load with old input)
        document.addEventListener('DOMContentLoaded', function() {
            toggleCollegeName();
        });
    </script>
</x-guest-layout>
