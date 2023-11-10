<template>
    <Card>
        <template #content>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="institution">
                            Institución
                        </label>
                        <InputText type="text" v-model="form.institution" placeholder="Nombres" class="w-full rounded" />
                        <span v-if="error_institution" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_institution }}</span>
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="level">
                            Nivel educativo
                        </label>
                        <Dropdown v-model="form.level" :options="levels" optionLabel="name" optionValue="id" placeholder="Selecccione nivel" class="w-full md:w-14rem" />
                        <span v-if="error_level" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_level }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-12" data-te-input-wrapper-init>
                        <label for="title">
                            Título obtenido
                        </label>
                        <InputText type="text" v-model="form.title" placeholder="Título obtenido" class="w-full rounded" />
                        <span v-if="error_title" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_title }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init v-if="form.level === 'Universitario' || form.level === 'Postgrado' || form.level === 'Especialización' || form.level === 'Doctorado' || form.level === 'Postdoctorado'">
                        <label for="tesis_title">
                            Título Tesis
                        </label>
                        <InputText type="text" v-model="form.tesis_title" placeholder="Nombres" class="w-full rounded" />           
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="currently">
                            Cursando actualmente
                        </label>
                        <Checkbox id="currently" name="currently" value="0" v-model="form.currently" :binary="true" class="mt-8" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4" v-if="form.currently !== true">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="date_from">
                            Desde
                        </label>
                        <Calendar v-model="form.date_from" showIcon dateFormat="yy-mm-dd" />         
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="date_to">
                            Hasta
                        </label>
                        <Calendar v-model="form.date_to" showIcon dateFormat="yy-mm-dd" />
                    </div>
                </div>                
            </div>
        </template>
        <template #footer>
            <Button icon="pi pi-check" label="Guardar" @click="submit" />
        </template>
    </Card>    
</template>

<script>
import axios from 'axios';

export default {
    name: "CreateEducation",
    data() {
        return {
            form: {
                profile_id: null,
                institution: null,
                title: null,
                level: null,
                tesis_title: null,
                currently: 0,
                date_from: null,
                date_to: null
            },
            levels:[
                { id:'Primaria', name:'Primaria' },
                { id:'Bachiller', name:'Bachiller' },
                { id:'Técnico', name:'Técnico' },
                { id:'Universitario', name:'Universitario' },
                { id:'Especialización', name:'Especialización' },
                { id:'Curso', name:'Curso' },
                { id:'Diplomado', name:'Diplomado' },
                { id:'Postgrado', name:'Postgrado' },
                { id:'Doctorado', name:'Doctorado' },
                { id:'Postdoctorado', name:'Postdoctorado' },
            ],
            error_institution: null,
            error_title: null,
            error_level: null
        }
    },
    props: {
        profile: Number,
        educationId: Number,
    },
    methods: {
        async submit () {
            if (!this.$props.educationId) {
                try {
                    const res = await axios.post('/api/v1/educations', this.form)
                    return this.emitter.emit('education_reload', this.$props.profile)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_institution = err.institution ? err.institution[0] : null
                                this.error_title = err.title ? err.title[0] : null
                                this.error_level       = err.level ? err.level[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/v1/educations/${this.$props.educationId}`, this.form)
                return this.emitter.emit('education_reload', this.$props.profile)
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_institution = err.institution ? err.institution[0] : null
                            this.error_title = err.title ? err.title[0] : null
                            this.error_level = err.level ?  err.level[0] : null
                    }
                }
                return null
            }
        },
        async getEducationForm(educationId) {
            const res = await axios.get(`/api/v1/educations/${educationId}`)
            this.form.institution = res.data.institution
            this.form.title       = res.data.title
            this.form.level       = res.data.level
            this.form.profile_id  = res.data.profile_id
            this.form.tesis_title = res.data.tesis_title
            this.form.currently   = res.data.currently
            this.form.date_from   = res.data.date_from
            this.form.date_to     = res.data.date_to
        },
        changeCurrently(event) {
            if (event.target.checked) {
            alert('isSelected');
            }            
        } 
    },
    mounted() {
        console.log(this.$props.educationId);
        this.form.profile_id = this.$props.profile;
        if(this.$props.educationId) {
            this.getEducationForm(this.$props.educationId);
        }
    }
}
</script>