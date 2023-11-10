<template>
    <Card>
        <template #title>
            <span class="text-indigo-900">Perfiles</span>
        </template>
        <template #content>
            <div class="card flex mb-8">
                <Dropdown v-model="selectedAreas" :options="areas_interest" optionLabel="name" placeholder="Seleccione un area" class="w-full md:w-14rem" />
                <Dropdown v-model="selectedStatus" :options="status" optionLabel="name" placeholder="Buscar por status" class="w-full md:w-14rem ml-4" />
                <span class="ml-2"><Button icon="pi pi-search" label="Buscar" @click="seekByStatus" class="full md:w-14rem ml-4"  /></span>
            </div>
                <div class="grid grid-cols-4 gap-4">
                    <div v-for="listProfile in listProfiles">
                        <Card class="cursor-pointer hover:bg-slate-100 ...">
                            <template #header>
                                <img alt="user header" title="profile-img" class="rounded-full object-fill h-64 block w-full min-w-fit" :src="`https://unixfystorage.blob.core.windows.net/unixfy-recruiting/${ listProfile.user.profile_photo_path }`" />
                            </template>
                            <template #title><span class="text-sky-900">{{ listProfile.full_name }}</span></template>
                            <template #subtitle><span class="text-gray-700 font-bold">{{ listProfile.title }}</span></template>
                            <template #content  v-if="listProfile.experiences[0]">
                                <h2 class="text-1xl font-extrabold leading-none tracking-tight text-sky-900 md:text-1xl lg:text-1xl text-center">Experiencia más reciente</h2>
                                <p class="text-1xl font-extrabold leading-none tracking-tight text-gray-800 md:text-1xl lg:text-1xl mt-1 text-center"> {{ listProfile.experiences[0].position }}</p>
                                <p class="text-1xl font-extrabold leading-none tracking-tight text-gray-800 md:text-1xl lg:text-1xl mt-1 text-center">{{ listProfile.experiences[0].diff }}</p>
                            </template>
                            <template #footer>
                                <Button icon="pi pi-check" label="Contactar" @click="viewProfile(listProfile.id)" class="max-w-full" />
                            </template>
                        </Card>
                    </div>
                </div>
        </template>
    </Card>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'
export default {
    name: "ListProfiles",
    data() {
        return {
            listProfiles: null,
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
            status: [
                { id: 'Visto', name: 'Completado' },
                { id: 'Destacado', name: 'Destacado' },
                { id: 'Blacklist', name: 'En espera' }
            ],
            selectedStatus: null,
            selectedAreas: null,
            viewed: false,
            city: null
        }
    },
    props: {
        user: Object,
    },
    methods: {
        async getListProfiles() {
            this.loading1 = false;
            await axios.get(`/api/v1/profiles`).then((res)=>{
                this.listProfiles = res.data.data;
                this.city = this.listProfiles.state_id
            })
        },
        viewProfile(idProfile){
            this.$inertia.visit(route('showProfile',idProfile), { method: 'get' });
        },
        shareProfile(idProfile) {
            console.log(idProfile)
        },

        async getStates(state_id) {
            this.state_id = state_id
            let config = {
                method: 'get',
                url: `https://api.countrystatecity.in/v1/countries/${state_id}/states`,
                headers: {
                    'X-CSCAPI-KEY': 'dmpkQWx1WDZ1Vzk4Zm9YeGdNck0ySEs5S2tKem1OYmhleGNSUUpKRA=='
                }
            };
            await axios(config).then((response) => {
                let findStates = response.data.map(({ iso2, name }) => ({ iso2, name }));
                this.states = findStates;
                this.states.sort((a, b) => (a.name > b.name) ? 1 : -1);
            }).catch(function (error) {
                console.log(error);
            })
        },
        async getCities(state_id) {
            let config = {
                method: 'get',
                url: `https://api.countrystatecity.in/v1/countries/${this.state_id}/states/${state_id}/cities`,
                headers: {
                    'X-CSCAPI-KEY': 'dmpkQWx1WDZ1Vzk4Zm9YeGdNck0ySEs5S2tKem1OYmhleGNSUUpKRA=='
                }
            };
            await axios(config).then((response) => {
                let findStates = response.data.map(({ id, name }) => ({ id, name }));
                this.cities = findStates;
            }).catch(function (error) {
                console.log(error);
            })
        },
        async seekByStatus() {
            await axios.get(`/api/v1/profilesByFilter/${this.selectedAreas ? this.selectedAreas.id: null}/${this.selectedStatus ? this.selectedStatus.id: null}`).then((res)=>{
                this.listProfiles = res.data;

                console.log(this.listProfiles.data);
/*                 if(this.listProfiles.length === 0){
                    Swal.fire({
                    title: 'No se encontraron registros',
                    text: 'Intente realizar la busqueda con otros parametros',
                    icon: 'error',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    timer: 1500
                    })
                } */
            })
        }
    },
    mounted() {
        this.getListProfiles();
    }
}
</script>
<style scoped>
 .viewed_style {
    background-color: green;
    color: #fff;
 }
 .share_button{
    margin-left: 4px;
 }
 :deep(.p-card-title) {
    text-align: center;
    height: 15px;
    margin-bottom: 20px;
 }
 :deep(.p-card .p-card-subtitle) {
    text-align: center;
 }
 :deep(.p-button) {
    width: 100%;
 }
 :deep(.p-card-header) {
    padding: 1em;
 }
</style>
