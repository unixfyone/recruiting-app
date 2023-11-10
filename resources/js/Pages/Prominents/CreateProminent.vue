<template>
    <Card>
        <template #content>
            <div class="grid grid-cols-1 gap-4">
                <div class="relative mb-4" data-te-input-wrapper-init>
                    <span class="p-float-label">
                        <Textarea v-model="form.comment" rows="5" cols="30" class="w-full rounded" />
                        <label for="comment">Comentarios</label>
                        <span v-if="error_comment" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ error_comment }}</span>
                    </span>
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
    name: "CreateProminent",
    data() {
        return {
            form: {
                profile_id: null,
                user_id: this.$props.user.id,
                comment: null,
            },
            error_comment: null,
        }
    },
    props: {
        profile: Number,
        user: Object,
    },
    methods: {
        async submit () {
            try {
                const res = await axios.post('/api/v1/prominents', this.form)
                return this.emitter.emit('prominent_reload', this.$props.profile)
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
    },
    mounted() {
        this.form.profile_id = this.$props.profile;
    }
}
</script>