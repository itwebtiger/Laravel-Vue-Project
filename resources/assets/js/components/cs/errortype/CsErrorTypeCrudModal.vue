<template>
    <div>
        <custom-modal :value="showPopup" @cancel="onClose" effect="fade">
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title"> {{ title }} </h4>
            </div>
            <div slot="modal-body" class="modal-body">
                   <div class="form-group"><div><label for="status">Ticket Type</label></div>
                                <Select clearable filterable v-model="formData.ticket_type_id"
                                        @on-change="onChangeType"  placeholder="Please select a Type..."   >
                                    <Option v-for="item in typeOptions" :value="item.value" :key="item" :label="item.label">{{ item.label }}</Option>
                                </Select>
                            </div>
                <div class="form-group">
                    <bs-input label="Error Code" type="text" required  :maxlength="255" :icon="true" v-model="formData.STATUS"></bs-input>
                    <bs-input label="Comment" type="textarea" :maxlength="255" :icon="true" v-model="formData.comment"></bs-input>
                </div>
                        
            </div>
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-success" @click="onClose">Cancel</button>
                <button type="button" class="btn btn-primary" @click="OnSave">Save</button>
            </div>
        </custom-modal>
    </div>
</template>
<script>
    import Vue from 'vue'
    import { mapState } from 'vuex'
    import modal from 'vue-strap/src/Modal'
    import input from 'vue-strap/src/Input'
    export default 
    {  computed: 
           { ...mapState({ showPopup: state => state.csticketerror.showPopup,//---------add---6
                          errortypeData: state=> state.csticketerror.errortypeData,  
                        }),   
            },
       data ()  {  return {  title: '',  formData: {     id: '',    STATUS: '',   comment: '', },typeOptions: []     }   },
       created() 
        {   console.log('/components/settings/tab/TabCrudModal.vue--CustomModal Component created.')
            this.$store.dispatch('gettickettypetable')  // get page list
                .then((response) => 
                {   console.log('/components/settings/tab/TabCrudModal.vue--created getPageOptions success=', response);
                    this.collectTypeOptions(response.data);
                })
                .catch((error) => { console.error('/components/settings/tab/TabCrudModal.vue---getPageOptions error=', error); });
        },
       components: {  'custom-modal': modal, 'bs-input': input,  },
       mounted() { console.log('/cs/csstatus/CsStatusCrudModal.vue--- mounted. statusData=', this.errortypeData) },
       methods: 
           {
                collectTypeOptions(types) 
                     {  console.log('/cs/cscrud---collectTypeOptions types=',types);
                        let options = [];
                        for (let type in types) 
                         { options.push({value: types[type].id, label: types[type].ticket_type});  }
                           this.typeOptions = options;
                     },
               onChangeType(val) { console.log('CNstatuscrud-- statuses=-onStatusLocation val=',val);    },
               OnSave() //---------------on save while adding and edit----coming from action=Add in  onClickNew() in statelistview
                { console.log('/cs/csstatus/CsStatusCrudModal.vue----OnSave_click'); //-------add----9
                  let payload = {  isShow: false,  data: this.formData, }; //isshow false after save pressed
                  if (this.errortypeData.action === 'Add')// add new state
                     { this.$store.dispatch('cserrortypeshowpopup', payload); //this is to disable popup after save pressed ie  isshow- false
                       this.$store.dispatch('cserrortypeadd', this.formData) //--add-10--send the status form fields to store file
                        .then((response) => {})     .catch((error) => {});
                     } 
                  else if (this.errortypeData.action === 'Edit')// edit---8
                   { 
                       this.$store.dispatch('cserrortypeshowpopup', payload);  
                       this.$store.dispatch('cserrortypeupdate', this.formData)
                        .then((response) => {})     .catch((error) => {});
                   }
                  else  {     }// error
                },
               onClose() {  console.log('/cs/csstatus/CsStatusCrudModal.vue-----onClose'); ////---------add---8
                           let payload = {   isShow: false,   data: this.formData,   };
                           this.$store.dispatch('cserrortypeshowpopup', payload);
                           this.resetFormData();
                        },
               resetFormData() {  this.formData = { id: '',  STATUS: '',  comment: ''  }; }

           },
           watch: {  errortypeData() 
                      {  console.log('/cs/csstatus/CsStatusCrudModal.vue-+++++++ statusData changed =', this.statusData);
                         if (this.errortypeData && this.errortypeData.action === 'Add')  ////---------add---7
                            {   this.resetFormData();   this.title = 'Adding New Error Type';  
                                console.log('/cs/csstatus/CsStatusCrudModal.vue-+++add form is open now_just before save is pressed');
                            }
                          else if (this.errortypeData && this.errortypeData.action === 'Edit')//-----edit 7
                           {   this.resetFormData();  
                               this.title = 'Editing the ERROR CODE';
                               console.log('error--++edit form is open now_just before save is pressed');
                               this.formData.id = this.errortypeData.data.id;
                               this.formData.STATUS = this.errortypeData.data.errorcode;
 console.log('error--++edit form ithis.errortypeData.data.ticket_type_id', this.errortypeData.data);

                               this.formData.ticket_type_id = this.errortypeData.data.ttype.id;
                                 console.log('error--++edit form this.formData.ticket_type_id', this.formData.ticket_type_id);
                              // this.csticketActivityData.data.ttype? this.csticketActivityData.data.ttype.id : '';
                               this.formData.comment = this.errortypeData.data.comment;
                           }
                       }
               }
    }

    </script>