<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <!-- Custom Registration Button -->
    <a href="{{ route('register') }}" class="block w-full text-center text-green-500 hover:underline">
        Register
    </a>

    <!-- Custom Forget Password Button -->
    <a href="{{ route('password.request') }}" class="block w-full text-center text-red-500 hover:underline">
        Forgot Password?
    </a>
</form>
