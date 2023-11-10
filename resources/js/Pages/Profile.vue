<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CreateProfile from '@/Pages/Profiles/CreateProfile.vue';
    import ViewProfile from '@/Pages/Profiles/ViewProfile.vue';


    defineProps({
        confirmsTwoFactorAuthentication: Boolean,
        sessions: Array,
    });
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hoja de vida
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateProfile :user="$page.props.auth.user" v-if="existProfile===false" />
                <ViewProfile :user="$page.props.auth.user" v-if="existProfile===true" />
            </div>
        </div>
    </AppLayout>
    <Toast />
</template>

<script>
import axios from 'axios';

export default {
        name: "Profile",
        data() {
            return {
                existProfile: false
            }
        },
        methods: {
           async getProfile(){
                const res = await axios.get(`/api/v1/profileByUser/${this.$page.props.auth.user.id}`)
                res.data.data.length > 0 ? this.existProfile=true : this.existProfile=false;
            }
        },
        mounted() {
            this.getProfile();

            this.emitter.on('profile_reload', (evt) => {
                this.getProfile();

                this.$toast.add({
                    severity:'success', summary: 'EXITOSO!',
                    detail: `Operación realizada con éxito!`, life:3000,
                })
            });
        }
}
</script>
