<template>
    <Card>
        <template #content>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="company_name">
                            Nombre de la empresa
                        </label>
                        <InputText type="text" v-model="form.company_name" placeholder="Nombre de la empresa" class="w-full rounded" />
                        <span v-if="error_company_name" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_company_name }}</span>
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="position">
                            Cargo/Rol
                        </label>
                        <InputText type="text" v-model="form.position" placeholder="Cargo ocupado" class="w-full rounded" />
                        <span v-if="error_position" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_position }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="functions">
                            Funciones
                        </label>
                        <InputText type="text" v-model="form.functions" placeholder="Funciones" class="w-full rounded" /> 
                        <span v-if="error_functions" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_functions }}</span>          
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="currently">
                            Trabajo aquí actualmente
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
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="functions">
                            Referencia - Nombre
                        </label>
                        <InputText type="text" v-model="form.reference_name" placeholder="Nombre de una persona de Referencia" class="w-full rounded" /> 
                        <span v-if="error_functions" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_functions }}</span>          
                    </div>
                    <div class="relative mb-6" data-te-input-wrapper-init>
                        <label for="functions">
                            Referencia - Teléfono
                        </label>
                        <InputMask v-model="form.reference_phone" date="reference_phone" mask="(999) 999-9999" placeholder="(999) 999-9999" class="w-full" />
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
    name: "CreateExperience",
    data() {
        return {
            form: {
                profile_id: null,
                position: null,
                company_name: null,
                functions: null,
                currently: 0,
                date_from: null,
                date_to: null,
                reference_name: null,
                reference_phone: null
            },
            error_position: null,
            error_company_name: null,
            error_functions: null
        }
    },
    props: {
        profile: Number,
        experienceId: Number,
    },
    methods: {
        async submit () {
            if (!this.$props.experienceId) {
                try {
                    const res = await axios.post('/api/v1/experiences', this.form)
                    return this.emitter.emit('experience_reload', this.$props.profile)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_position = err.position ? err.position[0] : null
                                this.company_name   = err.company_name ? err.company_name[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/v1/experiences/${this.$props.experienceId}`, this.form)
                return this.emitter.emit('experience_reload', this.$props.profile)
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_position = err.position ? err.position[0] : null
                            this.error_company_name = err.company_name ?  err.company_name[0] : null
                    }
                }
                return null
            }
        },
        async getExperienceForm(experienceId) {
            const res = await axios.get(`/api/v1/experiences/${experienceId}`)
            this.form.profile_id        = res.data.profile_id
            this.form.position          = res.data.position
            this.form.company_name      = res.data.company_name
            this.form.functions         = res.data.functions
            this.form.currently         = res.data.currently
            this.form.date_from         = res.data.date_from
            this.form.date_to           = res.data.date_to,
            this.form.reference_name    = res.data.reference_name,
            this.form.reference_phone   = res.data.reference_phone
        },
        changeCurrently(event) {
            if (event.target.checked) {
            alert('isSelected');
            }            
        } 
    },
    mounted() {
        console.log(this.$props.experienceId);
        this.form.profile_id = this.$props.profile;
        if(this.$props.experienceId) {
            this.getExperienceForm(this.$props.experienceId);
        }
    }
}
</script>