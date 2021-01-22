<form action="updateProfileInformation" method="POST">
    @csrf
    <div class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->

        <!-- First Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="first_name">First Name" </label>
            <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
            <x-jet-input-error for="first_name" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="last_name" value="Last Name" />
            <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
            <x-jet-input-error for="last_name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="Email" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone" value="Phone" />
            <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone" />
            <x-jet-input-error for="phone" class="mt-2" />
        </div>
        <!-- Gender -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="gender" value="Gender" />
            <div class="form-group col-lg-6 row">
                <div class="col-lg-4">
                    <div class="input-group">
                        <x-jet-input id="male" type="radio" name="gender" :value="1" wire:model.defer="state.gender"/>
                        <x-jet-label for="male" value="Male" style="display:inline-block;" class="ml-2 mt-1"/>
                    </div>
                </div>
                <div class="offset-4 col-lg-4">
                    <div class="input-group">
                        <x-jet-input id="female" type="radio" name="gender" :value="2" wire:model.defer="state.gender"/>
                        <x-jet-label for="female" value="Female" style="display:inline-block;" class="ml-2 mt-1"/>
                    </div>
                </div>
            </div>
        </div>

        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </form>