<template>
    <div class="filter-bar">
        <form class="form-inline form-group-sm ">
            <div class="form-group">
                <label>Search for:</label>
                  <input type="text" v-model="formSearchData.ticket_no" class="form-control" @keyup.enter="doFilter" placeholder="Ticket No">
                  <input type="text" v-model="formSearchData.subticket_no" class="form-control" @keyup.enter="doFilter" placeholder="SubTicket No">
               
             
                  <Select clearable filterable v-model="formSearchData.auser"
                                        @on-change="onChangeUser"
                                        placeholder="User..."
                                        style="width:180px"
                                > 
                         <Option v-for="item in usersOptions" :value="item.value" :key="item" :label="item.label">{{ item.label }}</Option>
                    </select>
                      
              
                <button class="btn btn-success btn-sm" @click.prevent="doFilter">Search</button>
                <button class="btn btn-warning btn-sm" @click.prevent="resetFilter">Reset</button>
            </div>
        </form>
    </div>
</template>

<script>
    import input from 'vue-strap/src/Input'
     import { mapState } from 'vuex'

    export default 
    {  
        
         created() {   console.log('LogFilterBar Component created.');
                          this.$store.dispatch('getuserlist') 
                       .then((response) =>
                        { console.log('/cs/search.vue-created getuserlist success=', response);
                          this.collectUserOptions(response.data);
                        })
                       .catch((error) => {  console.error('/cs/search.vue-getuserlist error=', error); });
                     
                  },
        components: { 'bs-input': input, },
        data () 
           {  return {  formSearchData: {    
                                             filterText: '', auser: '', ticket_no:'',subticket_no:'',
                                           
                                        },usersOptions:[],
                      
                    }
            },
        methods: {  doFilter () {  console.log('doFilter----formSearchData=', this.formSearchData);
                                   this.$events.fire('log-list-filter-set', this.formSearchData);
                                },
                    resetFilter () 
                              {  console.log('resetFilter');
                                // this.$events.fire('/cs/Search.vue--order-list-reset', this.formSearchData)
                                 this.formSearchData = 
                                    {  // type: 'USER_ACTION',
                                       // level: 'ERROR',
                                       // filterText: '', auser:'',
                                         filterText: '', auser: '', ticket_no:'',subticket_no:'',
                                   };
                                  this.$events.fire('log-list-filter-reset')
                              },
                    collectUserOptions(users) 
                                    {  console.log('/cs/search---collectUserOptions types=',users);
                                        let options = [];
                                        for (let users1 in users) 
                                        { options.push({value: users[users1].id, label: users[users1].name});  }
                                        this.usersOptions = options;
                                    },
                    onChangeUser(val) { console.log('/cs/Search.vue--onChangeCreatedBy val=',val);   },
                }
    }
</script>
<style scoped>
</style>