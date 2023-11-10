<template>
    <Card>
        <template #content>
            <div class="grid grid-cols-1 gap-4">
                <div class="relative mb-4" data-te-input-wrapper-init>
                    <span class="p-float-label">
                        <Dropdown v-model="form.selectedUser" :options="userList" optionLabel="user.name" placeholder="Select a User" class="w-full md:w-14rem" />
                        <label for="to">Enviar a:</label>

                    </span>
                </div>
            </div>
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
            <Button icon="pi pi-check" label="Enviar" @click="submit(this.$props.profile)" />
        </template>
    </Card>
</template>

<script>
import axios from 'axios';

export default {
    name: "ShareProfile",
    data() {
        return {
            form: {
                profile_id: null,
                user_id: this.$props.user.id,
                selectedUser: null,
                comment: null,
            },
            userList: null,
            error_comment: null,
        }
    },
    props: {
        profile: Number,
        user: Object,
    },
    methods: {
        async submit (profile) {
            console.log(this.form);
/*             await axios.get(`/api/v1/profileSendMail/${profile}`).then((res) => {
                console.log(res.data)
            }) */
        },
        async getListUsers() {
            await axios.get(`/api/v1/getListUsers/`).then((res) => {
                console.log(res.data);
                this.userList = res.data
            })
        }
    },
    mounted() {
        this.form.profile_id = this.$props.profile;
        this.getListUsers();
    }
}
</script>
