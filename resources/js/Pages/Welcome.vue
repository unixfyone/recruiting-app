<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="container">
        <div class="w-screen">
            <div>
                <div class="bg-white grid pb-20" style="background-image: url('/images/home.png'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 100%; border: none; outline: none;  margin: 0;  grid-column-gap: 0;">
                    <div class="col-span-2 mt-16" >
                        <h1 class="text-2xl font-bold tracking-tight text-white sm:text-4xl pl-4">RECRUITING-APP</h1>
                        <h2 class="pl-4 text-2xl font-bold tracking-tight text-white">Con nosotros tendrá la oportunidad de ingresar a la industria del Oil & Gas, </h2>
                        <h2 class="pl-4 text-2xl font-bold tracking-tight text-white">desarrollar su carrera, recibiendo beneficios competitivos y proyección profesional.</h2>
                        <div v-if="canLogin"  class="col-span-2 flex pl-4">
                            <Link :href="route('login')" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-6">
                                INICIA SESIÓN
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center pt-20">
                    <div class="mx-auto max-w-7xl">
                        <h2 class="text-3xl font-bold tracking-tight text-blue sm:text-4xl mt-0 text-center">Le brindamos esta aplicación, con la que puede aplicar para ingresar a nuestra Organización.</h2>
                        <p class="text-3xl tracking-tight text-blue sm:text-2xl mb-24 mt-12">
                                <i class="pi pi-check"></i> Ingrese a nuestra plataforma<br>
                                <i class="pi pi-check"></i> Registre sus datos<br>
                                <i class="pi pi-check"></i> Describa detalladamente su perfil profesional<br>
                                <i class="pi pi-check"></i> Mantega su perfil actualizado<br>
                        </p>

                        <div v-if="canLogin" class="col-span-2 mt-12 flex items-center justify-center mb-8">
                            <Link v-if="canRegister" :href="route('register')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded">
                                REGISTRATE
                            </Link>
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}

ul.no-bullets {
  list-style: none;
}
</style>

