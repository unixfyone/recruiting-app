<template>

    <DataTable :value="listProminent" dataKey="id" tableStyle="min-width: 50rem"
                :paginator="true"
                :rows="5"
                :loading="loading1"
                responsiveLayout="scroll">
        <Column field="comment" header="Comentario"></Column>
        <Column field="fecha" header="Fecha" />
        <Column field="user.name" header="Usuario" />
        <Column field="profile.full_name" header="Perfil" />
         
        <!-- <Column bodyStyle="justify-center" header="Acción"
                headerStyle="width: 14rem; justify-center">
            <template #body="slotProps">
                <PrimeButton @click="editProminent(slotProps.data.id)" icon="pi pi-pencil" class="buttonEdit" title="Editar Comentario" />
                <PrimeButton @click="deleteProminent(slotProps.data.id)" icon="pi pi-trash" class="buttonDelete" title="Borrar Comentario" />
            </template>
        </Column> -->
                   
    </DataTable>


   <Dialog modal :header="prominentId === null ? 'Carga comentarios sobre este perfil' : 'Editar comentarios del perfil'" :style="{width: '60vw'}"
            v-model:visible="display">
        <CreateProminent :prominentId="prominentId" :profile="this.$props.profile" />
    </Dialog>

    <Toast />
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import CreateProminent from './CreateProminent.vue';

export default {
   name: "ListProminent",
   components: {
        CreateProminent
    },
   data() {
       return {
           listProminent: null,
           prominentId:  null,
           display: false,
           loading1: true,
           loading2: true,
       }
   },
   props: {
       profile: Number,
       user: Object
   },
   methods: {
       async getListProminents(profile){
        this.loading1 = false;
           await axios.get(`/api/v1/prominentByProfile/${profile}`).then((res) => {
               this.listProminent = res.data;
           })
       },
       createProminent(profile){
            this.skillId = null;
            this.display = true;
       },
       editProminent(skillId){
            this.display = true;
            this.skillId = skillId;

        },
        async deleteProminent(skillId){
            Swal.fire( {
                title: 'Seguro de eliminar el registro?',
                showDenyButton: true,
                confirmButtonText: `Borrar`,
                denyButtonText: `No borrar`,
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/v1/skills/${skillId}`).then(() => {
                        this.listSkill = this.listSkill.filter(skill => skill.id !== skillId)
                        return this.emitter.emit('skill_reload', this.$props.profile)
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
            this.getListProminents(this.$props.profile);
        }
   },
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