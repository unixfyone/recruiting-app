<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-white mt-4 rounded-lg">
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="relative mb-8" data-te-input-wrapper-init>
                        <img :src="imageURI" class="rounded-full h-40 w-40 object-cover"  />
                        <h2 class="text-4xl font-bold text-indigo-900">{{ profile.full_name }}</h2>
                        <h2 class="text-2xl font-bold text-indigo-500"> {{ profile.title }}</h2>
                        <h2 class="text-1xl mt-4">{{ profile.description }}</h2>
                    </div>
                    <div>
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
<!--                                     <div class="grid justify-items-end ...">
                                        <span class="justify-items-center">
                                            <a :href="`/api/v1/profilePdfData/${profile.id}`" target="_blank">
                                                <i class="pi pi-print justify-items-end" style="font-size: 2rem"></i>
                                            </a>
                                        </span>
                                    </div> -->
                                    <div class="grid justify-items-end mb-6">
                                        <span class="justify-items-center">
                                            <i class="pi pi-heart justify-items-end" title="Destacado" style="font-size: 2rem; cursor: pointer;" @click="manageState"></i>
                                            <i class="pi pi-comments justify-items-end ml-4" title="Ver comentarios" style="font-size: 2rem; cursor: pointer;" @click="getProminents"></i>
                                            <i class="pi pi-times-circle justify-items-end ml-4" title="Hold" style="font-size: 2rem; cursor: pointer;" @click="manageBlackList"></i>
                                            <i class="pi pi-share-alt justify-items-end ml-4" title="Compartir" style="font-size: 2rem; cursor: pointer;" @click="manageShare"></i>
                                        </span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <table class="min-w-full text-left text-sm font-light">
                                        <tbody>
                                            <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">Nacionalidad</td>
                                            <td class="whitespace-nowrap  px-6 py-4">{{ profile.nationality }}</td>
                                            </tr>
                                            <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">Fecha de Nacimiento</td>
                                            <td class="whitespace-nowrap  px-6 py-4 ">{{ profile.birthdate }}</td>
                                            </tr>
                                            <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">Género</td>
                                            <td class="whitespace-nowrap  px-6 py-4 ">{{ profile.gender }}</td>
                                            </tr>
                                            <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">Número telefónico</td>
                                            <td class="whitespace-nowrap  px-6 py-4 ">{{ profile.phone }}</td>
                                            </tr>
                                            <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">Número opcional</td>
                                            <td class="whitespace-nowrap  px-6 py-4 ">{{ profile.phone2 }}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4  mt-4">
                                        <div class="relative mb-4" data-te-input-wrapper-init>
                                            <label for="area_interest" class="font-bold">
                                                <h2 class="text-2xl font-bold text-blue-800">Áreas de interés</h2>
                                            </label>
                                            <ul>
                                                <li v-for="area in selectedAreas" :key="area.id">
                                                    <span v-if="profile.area_interest">
                                                        <i class="pi pi-check"></i> {{ area.name }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-2">
                <div class="grid grid-cols gap-4">
                    <ListEducation v-if="profile.id" :profile="profile.id" />
                </div>
            </div>
            <div class="max-w-7xl mx-auto mt-2">
                <div class="grid grid-cols gap-4">
                    <listExperience v-if="profile.id" :profile="profile.id" />
                </div>
            </div>
            <div class="max-w-7xl mx-auto mt-2 pb-8">
                <div class="grid grid-cols gap-4">
                    <listSkill v-if="profile.id" :profile="profile.id" />
                </div>
            </div>

            <Dialog modal header="Agregar a destacados" :style="{width: '60vw'}"
                    v-model:visible="display">
                <CreateProminent :profile="profile.id" :user="$page.props.auth.user" />
            </Dialog>

            <Dialog modal header="Comentarios" :style="{width: '60vw'}"
                    v-model:visible="displayProminent">
                <ListProminent :profile="profile.id" :user="$page.props.auth.user" />
            </Dialog>

            <Dialog modal header="Compartir" :style="{width: '60vw'}"
                    v-model:visible="displayShare">
                <ShareProfile :profile="profile.id" :user="$page.props.auth.user" />
            </Dialog>

        </div>
    </AppLayout>
    <Toast />
</template>

<script>
import axios from 'axios'
import ListEducation from '@/Pages/Education/ListEducation.vue';
import listExperience from '@/Pages/Experience/ListExperience.vue';
import listSkill from '@/Pages/Skills/ListSkill.vue';
import CreateProminent from '@/Pages/Prominents/CreateProminent.vue';
import ListProminent from '@/Pages/Prominents/ListProminent.vue';
import ShareProfile from '@/Pages/Share/ShareProfile.vue';

export default {
    name: "ShowProfile",
    components: {
        ListEducation,
        listExperience,
        listSkill,
        CreateProminent,
        ListProminent,
        ShareProfile
    },
    data() {
        return {
            profile: [],
            imageURI: null,
            areas_interest: [
                    { id: 1, name:'Administracion Y Finanzas' },
                    { id: 2, name:'Almacen' },
                    { id: 3, name:'Automatización y Desarrollo' },
                    { id: 4, name:'Bombeo' },
                    { id: 5, name:'Coiled Tubing' },
                    { id: 6, name:'Coiled Tubing / Bombeo' },
                    { id: 7, name:'Control Y Gestion' },
                    { id: 8, name:'Comercialización, Ventas y Marketing' },
                    { id: 9, name:'Facilidades' },
                    { id: 10, name:'Gerencia' },
                    { id: 11, name:'Gestion De Talento Humano' },
                    { id: 12, name:'Guaya Electrica' },
                    { id: 13, name:'Guaya Electrica / Guaya Fina' },
                    { id: 14, name:'Guaya Fina' },
                    { id: 15, name:'QHSE' },
                    { id: 16, name:'Infraestructura y Soporte Técnico' },
                    { id: 17, name:'Legales' },
                    { id: 18, name:'Logistica Y Servicios Generales' },
                    { id: 19, name:'Mantenimiento Y Activos' },
                    { id: 20, name:'Medios Y Comunicación Corporativa' },
                    { id: 21, name:'Operaciones' },
                    { id: 22, name:'Operaciones Lacustres' },
                    { id: 23, name:'Planificacion' },
                    { id: 24, name:'Procura' },
                    { id: 25, name:'Proyectos' },
                    { id: 26, name:'Relaciones Institucionales' },
                    { id: 27, name:'Riesgos' },
                    { id: 28, name:'Seguridad Fisica' },
                    { id: 29, name:'Sistemas de Tecnología de la información' },
                    { id: 30, name:'Tesoreria' },
                    { id: 31, name:'Ventas & Marketing' },
                    { id: 32, name:'Well Testing' }
                ],
                selectedAreas: null,
                display: false,
                displayProminent: false,
                promient: null,
                displayShare: false
        }
    },
    props: {
        idProfile:String,
        user: Object
    },
    methods: {
        async getProfile(idProfile) {
            await axios.get(`/api/v1/profiles/${idProfile}`).then((res)=>{
                this.profile = res.data.data
                this.imageURI = `https://unixfystorage.blob.core.windows.net/unixfy-recruiting/${res.data.user.profile_photo_path}`
                this.filterAreas(this.profile.area_interest);
            })
        },
        filterAreas(area_interest){
            const filteredAreas = this.areas_interest.filter(area => JSON.parse(area_interest).includes(area.id));
            this.selectedAreas = filteredAreas
        },
        manageState() {
            this.display = true;
        },
        getProminents() {
            this.displayProminent = true;
        },
        manageBlackList() {
            alert('Lista negra');
        },
        manageShare() {
            this.displayShare = true;
        }
    },
    mounted() {
        this.getProfile(this.$props.idProfile)

        this.emitter.on('prominent_reload', (evt) => {
            this.display = false;
            this.$toast.add({
                severity:'success', summary: 'EXITOSO!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        });
    }
}
</script>
