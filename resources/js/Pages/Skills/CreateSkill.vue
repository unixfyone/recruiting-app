<template>
    <Card>
        <template #content>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-4">
                    <div class="relative mb-12" data-te-input-wrapper-init>
                        <label for="name">
                            Nombre de la habilidad o destreza
                        </label>
                        <InputText type="text" v-model="form.name" placeholder="Nombre" class="w-full rounded" />
                        <span v-if="error_name" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_name }}</span>
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
    name: "CreateSkill",
    data() {
        return {
            form: {
                profile_id: null,
                name: null,
            },
            error_name: null,
        }
    },
    props: {
        profile: Number,
        skillId: Number,
    },
    methods: {
        async submit () {
            if (!this.$props.skillId) {
                try {
                    const res = await axios.post('/api/v1/skills', this.form)
                    return this.emitter.emit('skill_reload', this.$props.profile)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_name = err.name ? err.name[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/v1/skills/${this.$props.skillId}`, this.form)
                return this.emitter.emit('skill_reload', this.$props.profile)
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_name = err.name ? err.name[0] : null
                    }
                }
                return null
            }
        },
        async getSkillForm(skillId) {
            const res = await axios.get(`/api/v1/skills/${skillId}`)
            this.form.profile_id  = res.data.profile_id
            this.form.name        = res.data.name
        },
        changeCurrently(event) {
            if (event.target.checked) {
            alert('isSelected');
            }            
        } 
    },
    mounted() {
        this.form.profile_id = this.$props.profile;
        if(this.$props.skillId) {
            this.getSkillForm(this.$props.skillId);
        }
    }
}
</script>