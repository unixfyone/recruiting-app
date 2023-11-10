<template>
    <Card>
        <template #title v-if="!this.$props.profileId"> <span class="text-indigo-900">Datos básicos</span> </template>
        <template #content>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <InputText type="text" v-model="form.first_name" id="first_name" class="w-full rounded" />
                            <label for="first_name">Nombres</label>
                        </span>
                        <span v-if="error_first_name" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_first_name }}</span>
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <InputText type="text" v-model="form.last_name" id="last_name"  class="w-full rounded"/>
                            <label for="last_name">Apellidos</label>
                        </span>
                        <span v-if="error_last_name" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_last_name }}</span>
                    </div>
                </div>
                <div class="grid grid-cols gap-4">
                    <div class="relative mb-12" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <InputText type="text" v-model="form.title" id="title"  class="w-full rounded"/>
                            <label for="title">Título de su perfil</label>
                        </span>
                        <span v-if="error_title" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_title }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <Dropdown v-model="form.nationality" :options="nationalities" optionLabel="name" optionValue="id" placeholder="Seleccione su nacionalidad" class="w-full md:w-14rem" />
                        <span v-if="error_nationality" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_nationality }}</span>
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <Dropdown v-model="form.type_dni" :options="types" optionLabel="name" optionValue="id" placeholder="Seleccione tipo de documento" class="w-full md:w-14rem" />
                        <span v-if="error_type_dni" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_type_dni }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <InputText type="text" v-model="form.dni" placeholder="Documento" id="dni" class="w-full rounded" />
                            <label for="dni">N° de documento</label>
                        </span>
                        <span v-if="error_dni" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_dni }}</span>
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <Calendar v-model="form.birthdate" showIcon dateFormat="yy-mm-dd" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <Dropdown v-model="form.gender" :options="genders" optionLabel="name" optionValue="id" placeholder="Seleccione genero" class="w-full md:w-14rem" />
                        <span v-if="error_gender" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_gender }}</span>
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <InputMask v-model="form.phone" date="phone" mask="(999) 999-9999" placeholder="(999) 999-9999" class="w-full" />
                        <span v-if="error_phone" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_phone }}</span>
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <InputMask v-model="form.phone2" date="phone2" mask="(999) 999-9999" placeholder="(999) 999-9999" class="w-full" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <Dropdown v-model="form.country_id" :options="countries" optionLabel="name" optionValue="iso2" @change="getStates($event.value)" placeholder="Seleccione pais" class="w-full md:w-14rem" />
                        <span v-if="error_country_id" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_country_id }}</span>
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <Dropdown v-model="form.state_id" :options="states" optionLabel="name" optionValue="iso2" @change="getCities($event.value)" placeholder="Seleccione estado" class="w-full md:w-14rem" />
                    </div>
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <Dropdown v-model="form.city_id" :options="cities" optionLabel="name" optionValue="id" placeholder="Seleccione ciudad" class="w-full md:w-14rem" />
                        <span v-if="error_city_id" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_city_id }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <InputText type="text" v-model="form.postal_code" id="postal_code" class="w-full rounded" />
                            <label for="postal_code">Código Postal</label>
                        </span>
                        <span v-if="error_postal_code" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_postal_code }}</span>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="relative mb-4" data-te-input-wrapper-init>
                            <MultiSelect v-model="form.languages" :options="languages_list" optionLabel="name" optionValue="id" placeholder="Selecciona los idiomas que manejas..." :maxSelectedLabels="3" class="w-full md:w-20rem" />
                            <span v-if="error_languages" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_languages }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <span class="p-float-label">
                            <Textarea v-model="form.description" rows="5" cols="30" id="description" class="w-full rounded"  />
                            <label for="description">Escribe una descripción acerca de ti</label>
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-4" data-te-input-wrapper-init>
                        <MultiSelect v-model="form.area_interest" :options="areas_interest" optionLabel="name" optionValue="id" placeholder="Selecciona tus áreas de interés" :maxSelectedLabels="3" class="w-full md:w-20rem" />
                        <span v-if="error_area_interest" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_area_interest }}</span>
                    </div>
                </div>

                <!-- <FileUpload mode="basic" name="form.uri_cv" accept=".pdf,.doc" :maxFileSize="1000000" @change="upload($event)" chooseLabel="Sube tu CV" /> -->
                <!-- <FileUpload mode="basic" name="uri_cv" accept=".pdf" customUpload @uploader="customBase64Uploader" chooseLabel="Subir CV" /> -->

            </div>
        </template>
        <template #footer>
            <Button label="Guardar" @click="submit" />
        </template>
    </Card>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

    export default {
        name: "CreateProfile",
        data () {
            return {
                form: {
                    user_id: this.$props.user.id,
                    first_name: null,
                    last_name: null,
                    title: null,
                    nationality: null,
                    type_dni: null,
                    dni: null,
                    birthdate: null,
                    gender: null,
                    phone: null,
                    phone2: null,
                    country_id: null,
                    state_id: null,
                    city_id: null,
                    postal_code: null,
                    description: null,
                    languages: null,
                    area_interest: null,
                    uri_cv: null,
                },
                state_id: null,
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
                error_first_name: null,
                error_last_name: null,
                error_title: null,
                error_nationality: null,
                error_type_dni: null,
                error_dni: null,
                error_gender: null,
                error_phone: null,
                error_country_id: null,
                error_state_id: null,
                error_city_id: null,
                error_postal_code: null,
                error_languages: null,
                error_area_interest: null
            }
        },
        props: {
              user: Object,
              profileId: Number
        },
        methods: {
            async submit () {
                if (!this.$props.profileId) {
                    try {
                        this.form.area_interest = JSON.stringify(this.form.area_interest)
                        this.form.languages = JSON.stringify(this.form.languages)

                     await axios.post('/api/v1/profiles', this.form)
                        return this.emitter.emit('profile_reload', this.$props.user)
                    }
                    catch (e) {
                        if (e.response) {
                            switch (e.response.status) {
                                case 422:
                                    let err = e.response.data.errors
                                    this.error_first_name = err.first_name ? err.first_name[0] : null
                                    this.error_last_name = err.last_name ? err.last_name[0] : null
                                    this.error_title = err.title ? err.title[0] : null
                                    this.error_nationality = err.nationality ?  err.nationality[0] : null
                                    this.error_type_dni = err.type_dni ?  err.type_dni[0] : null
                                    this.error_dni = err.dni ?  err.dni[0] : null
                                    this.error_gender = err.gender ?  err.gender[0] : null
                                    this.error_phone = err.phone ?  err.phone[0] : null
                                    this.error_country_id = err.country_id ?  err.country_id[0] : null
                                    this.error_state_id = err.state_id ?  err.state_id[0] : null
                                    this.error_city_id = err.city_id ?  err.city_id[0] : null
                                    this.error_postal_code = err.postal_code ?  err.postal_code[0] : null
                                    this.error_languages = err.languages ?  err.languages[0] : null
                                    this.error_area_interest = err.area_interest ?  err.area_interest[0] : null
                                    //this.resetMultiSelect();
                                    break
                            }
                        }
                        return null
                    }
                }
                try {
                    this.form.birthdate = moment(this.form.birthdate, "ddd MMM DD YYYY HH:mm:ss [GMT]").toDate();
                    console.log(this.form)
                    await axios.put(`/api/v1/profiles/${this.$props.profileId}`, this.form)
                    return this.emitter.emit('profileEdit_reload', this.$props.user)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_first_name = err.first_name ? err.first_name[0] : null
                                this.error_last_name = err.last_name ? err.last_name[0] : null
                                this.error_title = err.title ? err.title[0] : null
                                this.error_nationality = err.nationality ?  err.nationality[0] : null
                                this.error_type_dni = err.type_dni ?  err.type_dni[0] : null
                                this.error_dni = err.dni ?  err.dni[0] : null
                                this.error_gender = err.gender ?  err.gender[0] : null
                                this.error_phone = err.phone ?  err.phone[0] : null
                                this.error_country_id = err.country_id ?  err.country_id[0] : null
                                this.error_state_id = err.state_id ?  err.state_id[0] : null
                                this.error_city_id = err.city_id ?  err.city_id[0] : null
                                this.error_postal_code = err.postal_code ?  err.postal_code[0] : null
                                //this.resetMultiSelect();
                        }
                    }
                    return null
                }
            },
            async getProfileForm(profileId){
                const res = await axios.get(`/api/v1/profiles/${profileId}`)
                this.form.first_name    = res.data.first_name
                this.form.last_name     = res.data.last_name
                this.form.title         = res.data.title
                this.form.nationality   = res.data.nationality
                this.form.type_dni      = res.data.type_dni
                this.form.dni           = res.data.dni
                this.form.birthdate     = res.data.birthdate
                this.form.gender        = res.data.gender
                this.form.phone         = res.data.phone
                this.form.phone2        = res.data.phone2
                this.form.country_id    = res.data.country_id
                this.form.state_id      = res.data.state_id
                this.form.city_id       = res.data.city_id
                this.form.postal_code   = res.data.postal_code
                this.form.description   = res.data.description
                this.form.languages     = JSON.parse(res.data.languages)
                this.form.area_interest = JSON.parse(res.data.area_interest)

                this.getStates(this.form.country_id)
                this.getCities(this.form.state_id)
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
            resetMultiSelect() {
                this.form.area_interest = null;
                this.form.languages = null;
            },
            async customBase64Uploader(event) {
                const file = event.files[0];
                const reader = new FileReader();
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let data = new FormData();
                data.append('file', file);
                data.append('profile_id',this.$props.profileId);
                axios.post(`/api/v1/profileUploadFile`, data, config)
                    .then(function (res) {
                        existingObj.success = res.data.success;
                    })
                    .catch(function (err) {
                        existingObj.output = err;
                    });

                //await axios.put(`/api/v1/profiles/${this.$props.profileId}`, file, config)

            }
        },
        mounted() {
            this.getCountries();
            if(this.$props.profileId){
                this.getProfileForm(this.$props.profileId)
            }
        }
    }
</script>
