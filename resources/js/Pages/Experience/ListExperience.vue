<template>
    <Card class="mt-4">
       <template #title> 
            <span class="text-indigo-900">Experiencia</span> 
            <span class="float-right" v-if="$page.props.auth.user.id === $props.user_id">
                <PrimeButton @click="createExperience(this.$props.profile)" icon="pi pi-plus" title="Crear Experiencia" />
            </span>
        </template>

       <template #content>
           <DataTable :value="listExperience" dataKey="id" tableStyle="min-width: 50rem"
                        :paginator="true"
                        :rows="5"
                        :loading="loading1"
                        responsiveLayout="scroll">
               <Column field="company_name" header="Empresa"></Column>
               <Column field="position" header="Cargo"></Column>
                <Column field="currently" header="Estado">
                    <template #body="slotProps">
                        <span v-if="slotProps.data.currently === 1">Actualmente</span>
                        <span v-else>Finalizado</span>
                    </template>
                </Column>
               <Column field="date_from" header="Inicio"></Column>
               <Column field="date_to" header="Fin"></Column>
               <Column bodyStyle="justify-center" header="Acción"
                        headerStyle="width: 14rem; justify-center" v-if="$page.props.auth.user.id === $props.user_id">
                    <template #body="slotProps">
                        <PrimeButton @click="editExperience(slotProps.data.id)" icon="pi pi-pencil" class="buttonEdit" title="Editar Experiencia" />
                        <PrimeButton @click="deleteExperience(slotProps.data.id)" icon="pi pi-trash" class="buttonDelete" title="Borrar Experiencia" />
                    </template>
                </Column>               
           </DataTable>            
       </template>
   </Card>

   <Dialog modal :header="experienceId === null ? 'Carga datos de tu experiencia' : 'Editar datos de tu experiencia'" :style="{width: '60vw'}"
            v-model:visible="display">
        <CreateExperience :experienceId="experienceId" :profile="this.$props.profile" />
    </Dialog>

    <Toast />
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import CreateExperience from './CreateExperience.vue';

export default {
   name: "ListExperience",
   components: {
        CreateExperience
    },
   data() {
       return {
           listExperience: null,
           experienceId:  null,
           display: false,
           loading1: true,
           loading2: true,
       }
   },
   props: {
       profile: Number,
       user_id: Number
   },
   methods: {
       async getListExperience(profile){
        this.loading1 = false;
           await axios.get(`/api/v1/experienceByProfile/${profile}`).then((res) => {
               this.listExperience = res.data;
           })
       },
       createExperience(profile){
            this.experienceId = null;
            this.display = true;
       },
        editExperience(experienceId){
            this.display = true;
            this.experienceId = experienceId;

        },
        async deleteExperience(experienceId){
            Swal.fire( {
                title: 'Seguro de eliminar el registro?',
                showDenyButton: true,
                confirmButtonText: `Borrar`,
                denyButtonText: `No borrar`,
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/v1/experiences/${experienceId}`).then(() => {
                        this.listExperience = this.listExperience.filter(experience => experience.id !== experienceId)
                        return this.emitter.emit('experience_reload', this.$props.profile)
                    }).catch(() => {
                        console.log(error);
                        Swal.fire('No se logro eliminar', '', 'error')
                    })
                } else if (result.isDenied) {
                    Swal.fire('No se ha borrado...', '', 'info')
                }
            })
        },    
   },
   mounted(){
       if (this.$props.profile){
            this.getListExperience(this.$props.profile);
        }    
        
        this.emitter.on('experience_reload', (evt) => {
            this.getListExperience(evt);
            this.display = false;

            this.$toast.add({
                severity:'success', summary: 'EXITOSO!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        });
   },
   components: { CreateExperience }
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