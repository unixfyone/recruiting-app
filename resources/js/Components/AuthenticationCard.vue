<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background-image: url('/images/login.png'); background-repeat: no-repeat; background-size: cover;">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-300 text-black shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
