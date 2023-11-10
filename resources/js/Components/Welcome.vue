<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                ¡Bienvenido a Recruiting-App!
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">
                Te recomendamos mantener tu Hoja de Vida actualizada a fin de que podamos tenerte en cuenta para las vacantes que más se acerquen a tu perfil y área de interés.
                Recuerda que la información suministrada debe ser real y verificable mediante certificados y soportes laborales y educativos.
            </p>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8 p-6 lg:p-8">
            <div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900">
                        Proceso de Selección
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                    El primer paso es tener diligenciados tus datos personales para que podamos contactarte.
                    Debes tener seleccionada una o varias áreas de interés para poder relacionarte con las ofertas disponibles que estén acordes a tu perfil.
                    En caso de que seas elegido para participar en alguno de nuestros procesos de selección, es importante recordar que toda la información de tu hoja de vida debe estar debidamente soportada para ser comprobada por nuestros reclutadores.
                </p>
            </div>
        </div>
    </div>
</template>
