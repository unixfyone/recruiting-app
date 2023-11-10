<template>
     <Card class="mt-4">
        <template #title> 
            <span class="text-indigo-900">Educación </span>             
            <span class="float-right" v-if="$page.props.auth.user.id === $props.user_id">
                <PrimeButton @click="createEducation()" icon="pi pi-plus" title="Crear Educación" />
            </span>
        </template>
        <template #content>
            <DataTable :value="listEducation" dataKey="id" tableStyle="min-width: 50rem"
                        :paginator="true"
                        :rows="5"
                        :loading="loading1"
                        responsiveLayout="scroll">
                <Column field="institution" header="Institución"></Column>
                <Column field="title" header="Título"></Column>
                <Column field="level" header="Nivel académico"></Column>
                <Column field="currently" header="Estado">
                    <template #body="slotProps">
                        <span v-if="slotProps.data.currently === 1">En curso</span>
                        <span v-else>Finalizado</span>
                    </template>
                </Column>
                <Column field="date_from" header="Inicio"></Column>
                <Column field="date_to" header="Fin"></Column>
                <Column bodyStyle="justify-center" header="Acción"
                        headerStyle="width: 14rem; justify-center" v-if="$page.props.auth.user.id === $props.user_id">
                    <template #body="slotProps">
                        <PrimeButton @click="editEducation(slotProps.data.id)" icon="pi pi-pencil" class="buttonEdit" title="Editar Educación" />
                        <PrimeButton @click="deleteEducation(slotProps.data.id)" icon="pi pi-trash" class="buttonDelete" title="Borrar Educación" />
                    </template>
                </Column>          
            </DataTable>            
        </template>
    </Card>

    <Dialog modal :header="educationId === null ? 'Carga datos de tu educación' : 'Editar datos de tu educación'" :style="{width: '60vw'}"
            v-model:visible="display">
        <CreateEducation :educationId="educationId" :profile="this.$props.profile" />
    </Dialog>
    
    <Toast />
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'
import CreateEducation from './CreateEducation.vue';

export default {
    name: "ListEducation",
    components: {
        CreateEducation
    },
    data() {
        return {
            listEducation: null,
            educationId:  null,
            display: false,
            loading1: true,
            loading2: true,
        };
    },
    props: {
        profile: Number,
        user_id: Number
    },
    methods: {
        async getListEducation(profile) {
            this.loading1 = false;
            await axios.get(`/api/v1/educationByProfile/${profile}`).then((res) => {
                this.listEducation = res.data;
            });
        },
        createEducation() {
            this.educationId = null;
            this.display = true;
        },
        editEducation(educationId) {
            this.display = true;
            this.educationId = educationId;
        },
        async deleteEducation(educationId) {
            Swal.fire( {
                title: 'Seguro de eliminar el registro?',
                showDenyButton: true,
                confirmButtonText: `Borrar`,
                denyButtonText: `No borrar`,
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/v1/educations/${educationId}`).then(() => {
                        this.listEducation = this.listEducation.filter(education => education.id !== educationId)
                        return this.emitter.emit('education_reload', this.$props.profile)
                    }).catch((error) => {
                        console.log(error);
                        Swal.fire('No se logro eliminar', '', 'error')
                    })
                } else if (result.isDenied) {
                    Swal.fire('No se a borrado...', '', 'info')
                }
            })
        },        
    },
    mounted() {
        if (this.$props.profile) {
            this.getListEducation(this.$props.profile);
        }

        this.emitter.on('education_reload', (evt) => {
            this.getListEducation(evt);
            this.display = false;

            this.$toast.add({
                severity:'success', summary: 'EXIOSO!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        });

    },
    components: { CreateEducation }
}
</script>
<style>
    .buttonEdit {
        color: #ffffff;
        background-color: gray;
        margin-right: 2px;
        width: 20px;
    }
    .buttonDelete {
        color: #ffffff;
        background-color: red;
        width: 20px;
    }
</style>