<template>
    <Card class="mt-4">
       <template #title> 
            <span class="text-indigo-900">Habilidades y Destrezas</span> 
            <span class="float-right" v-if="$page.props.auth.user.id === $props.user_id">
                <PrimeButton @click="createSkill(this.$props.profile)" icon="pi pi-plus" title="Crear Habilidad" />
            </span>
        </template>

       <template #content>
           <DataTable :value="listSkill" dataKey="id" tableStyle="min-width: 50rem"
                        :paginator="true"
                        :rows="5"
                        :loading="loading1"
                        responsiveLayout="scroll">
               <Column field="name" header="Nombre"></Column>
               <Column bodyStyle="justify-center" header="Acción"
                        headerStyle="width: 14rem; justify-center" v-if="$page.props.auth.user.id === $props.user_id">
                    <template #body="slotProps">
                        <PrimeButton @click="editSkill(slotProps.data.id)" icon="pi pi-pencil" class="buttonEdit" title="Editar Habilidad" />
                        <PrimeButton @click="deleteSkill(slotProps.data.id)" icon="pi pi-trash" class="buttonDelete" title="Borrar Habilidad" />
                    </template>
                </Column>               
           </DataTable>            
       </template>
   </Card>

   <Dialog modal :header="skillId === null ? 'Carga datos de tus habilidades' : 'Editar habilidades'" :style="{width: '60vw'}"
            v-model:visible="display">
        <CreateSkill :skillId="skillId" :profile="this.$props.profile" />
    </Dialog>

    <Toast />
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import CreateSkill from './CreateSkill.vue';

export default {
   name: "ListSkill",
   components: {
        CreateSkill
    },
   data() {
       return {
           listSkill: null,
           skillId:  null,
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
       async getListSkill(profile){
        this.loading1 = false;
           await axios.get(`/api/v1/skillByProfile/${profile}`).then((res) => {
               this.listSkill = res.data;
           })
       },
       createSkill(profile){
            this.skillId = null;
            this.display = true;
       },
       editSkill(skillId){
            this.display = true;
            this.skillId = skillId;

        },
        async deleteSkill(skillId){
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
            this.getListSkill(this.$props.profile);
        }    
        
        this.emitter.on('skill_reload', (evt) => {
            this.getListSkill(evt);
            this.display = false;

            this.$toast.add({
                severity:'success', summary: 'EXITOSO!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        });
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