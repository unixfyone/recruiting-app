<template>
    <Card>
        <template #title>
            <span class="text-indigo-900">Datos básicos</span>
<!--             <div class="grid justify-items-end ...">
                <span class="justify-items-center">
                    <a :href="`/api/v1/profilePdfData/${profile.id}`" target="_blank">
                        <i class="pi pi-print justify-items-end" style="font-size: 2rem"></i>
                    </a>
                </span>
            </div> -->

        </template>
        <template #content>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="first_name" class="font-bold">
                            Nombres
                        </label>
                        <InputText type="text" v-model="profile.first_name" class="w-full rounded" disabled />
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="last_name" class="font-bold">
                            Apellidos
                        </label>
                        <InputText type="text" v-model="profile.last_name" class="w-full rounded" disabled />
                    </div>
                </div>
                <div class="grid grid-cols gap-4">
                    <div class="relative mb-12" data-te-input-wrapper-init>
                        <label for="title" class="font-bold">
                            Titulo del perfil
                        </label>
                        <InputText type="text" v-model="profile.title" class="w-full rounded" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="nationality" class="font-bold">
                            Nacionalidad
                        </label>
                        <Dropdown v-model="profile.nationality" :options="nationalities" optionLabel="name" optionValue="id" placeholder="Seleccione su nacionalidad" class="w-full md:w-14rem" disabled />
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="type_dni" class="font-bold">
                            Tipo de documento
                        </label>
                        <Dropdown v-model="profile.type_dni" :options="types" optionLabel="name" optionValue="id" class="w-full md:w-14rem" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="dni" class="font-bold">
                            # Documento
                        </label>
                        <InputText type="text" v-model="profile.dni" class="w-full rounded" disabled />
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="birthdate" class="font-bold">
                            Fecha de nacimiento
                        </label>
                        <InputText type="text" v-model="profile.birthdate" class="w-full rounded" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="gender" class="font-bold">
                            Género
                        </label>
                        <Dropdown v-model="profile.gender" :options="genders" optionLabel="name" optionValue="id" placeholder="Seleccione genero" class="w-full md:w-14rem" disabled />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="phone" class="font-bold">
                            Teléfono
                        </label>
                        <InputMask v-model="profile.phone" date="phone" mask="(999) 999-9999" placeholder="(999) 999-9999" class="w-full" disabled />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="phone2" class="font-bold">
                            Teléfono 2
                        </label>
                        <InputMask v-model="profile.phone2" date="phone2" mask="(999) 999-9999" placeholder="(999) 999-9999" class="w-full" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="country_id" class="font-bold">
                            País
                        </label>
                        <Dropdown v-model="profile.country_id" :options="countries" optionLabel="name" optionValue="iso2" class="w-full md:w-14rem" disabled />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="state_id" class="font-bold">
                            Estado
                        </label>
                        <Dropdown v-model="profile.state_id" :options="states" optionLabel="name" optionValue="iso2" class="w-full md:w-14rem" disabled />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="city_id" class="font-bold">
                            Ciudad
                        </label>
                        <Dropdown v-model="profile.city_id" :options="cities" optionLabel="name" optionValue="id" class="w-full md:w-14rem" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="postal_code" class="font-bold">
                            Código postal
                        </label>
                        <Chip :label="profile.postal_code" icon="pi pi-id-card" class="mt-2" />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="languages" class="font-bold">
                            Idiomas
                        </label>
                        <ul>
                            <li v-for="languag in selectedLanguages" :key="languag.id">
                                <span v-if="profile.languages">
                                    <i class="pi pi-check"></i> {{ languag.name }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="description" class="font-bold">
                            Descripción
                        </label>
                        <Textarea v-model="profile.description" rows="5" cols="30" class="w-full rounded" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <label for="area_interest" class="font-bold">
                            Áreas de interés
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
            <Button label="Editar" icon="pi pi-pencil" @click="editProfile(profile.id)" />
        </template>
    </Card>

    <ListEducation v-if="profile.id" :profile="profile.id" :user_id="profile.user_id" />

    <listExperience v-if="profile.id" :profile="profile.id" :user_id="profile.user_id" />

    <listSkill v-if="profile.id" :profile="profile.id" :user_id="profile.user_id" />

    <Dialog modal header="Editando datos básicos" :style="{width: '60vw'}"
            v-model:visible="display">
        <CreateProfile :user="$page.props.auth.user" :profileId="profile.id" />
    </Dialog>

</template>

<script>
import axios from 'axios';
import ListEducation from '@/Pages/Education/ListEducation.vue';
import listExperience from '@/Pages/Experience/ListExperience.vue';
import listSkill from '@/Pages/Skills/ListSkill.vue';
import CreateProfile from './CreateProfile.vue';

export default {
    name: "ViewProfile",
    components: {
        ListEducation,
        listExperience,
        CreateProfile,
        listSkill
    },
    data() {
        return {
            profile: [],
            types: [
                    {id:'Cédula',name:'Cédula'},
                    {id:'Pasaporte',name:'Pasaporte'},
                    {id:'Otro',name:'Otro'}
                ],
                genders: [
                    { id:'Masculino', name:'Masculino' },
                    { id:'Femenino', name:'Femenino' }
                ],
                countries: null,
                states: null,
                cities: null,
                languages_list: [
                    { id:1, name:'Inglés'},
                    { id:2, name:'Español'},
                    { id:3, name:'Portugués'},
                    { id:4, name:'Otro'}
                ],
                nationalities: [
                    { id: 'Venezolano', name:'Venezolano' },
                    { id: 'Extranjero', name:'Extranjero' }
                ],
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
                display: false,
                selectedAreas: null,
                selectedLanguages: null
        }
    },
    props: {
        user:Object
    },
    methods: {
        async getProfile(){
            await axios.get(`/api/v1/profileByUser/${this.$props.user.id}`).then((res) => {
                //mejorar backend para este request
                this.profile = res.data.data[0];
                this.filterAreas(this.profile.area_interest);
                this.filterLanguages(this.profile.languages);
                this.getCountries();
                this.getStates(this.profile.country_id);
                this.getCities(this.profile.country_id, this.profile.state_id);
            })
        },
        filterAreas(area_interest){
            const filteredAreas = this.areas_interest.filter(area => JSON.parse(area_interest).includes(area.id));
            this.selectedAreas = filteredAreas
        },
        filterLanguages(languages){
            const filteredLanguages = this.languages_list.filter(languag => JSON.parse(languages).includes(languag.id));
            this.selectedLanguages = filteredLanguages
        },
        editProfile(profileId){
            this.display = true;
        },
        async getCountries() {
            let config = {
                method: 'get',
                url: 'https://api.countrystatecity.in/v1/countries',
                headers: {
                    'X-CSCAPI-KEY': 'dmpkQWx1WDZ1Vzk4Zm9YeGdNck0ySEs5S2tKem1OYmhleGNSUUpKRA=='
                }
            };
            await axios(config).then((response) => {
                let findCountries = response.data.map(({ iso2, name }) => ({ iso2, name }));
                this.countries = findCountries;
            }).catch(function (error) {
                console.log(error);
            })
        },
        async getStates(state_id) {
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
            }).catch(function (error) {
                console.log(error);
            })
        },
        async getCities(country_id, state_id) {
            let config = {
                method: 'get',
                url: `https://api.countrystatecity.in/v1/countries/${country_id}/states/${state_id}/cities`,
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
    },
    mounted(){
        this.getProfile();

        this.emitter.on('profileEdit_reload', (evt) => {
            this.display = false;
            this.getProfile();

            this.$toast.add({
                severity:'success', summary: 'EXIOSO!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        });
    }
}
</script>
