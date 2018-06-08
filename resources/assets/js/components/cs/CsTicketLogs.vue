<template>
  <div id="root-order-history-summary">
    <div class="app-row">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <a class="accordion-toggle" data-toggle="collapse"  href="#orderhistoryinfo">
                  Ticket Logs
              </a>              
            </div>
            <div id="orderhistoryinfo" class="panel-collapse collapse in table-responsive">
              <table class="table table-hover table-striped table-responsive table-bordered table-condensed">
                <thead>
                  <tr> <th>Date Time Stamp</th> <th>Activity</th> <th>User</th></tr>
                </thead>
                <tbody>
                  <tr v-for="orderHisTran in orderHistoryTrans">
                    <td> {{ formatDatetime(orderHisTran.updated_at) }}</td>
                    <td> {{ orderHisTran.function1 }} </td>
                    <td> {{ orderHisTran.updated_by? orderHisTran.updated_by.name: '' }}
                    </td>                    
                  </tr>
                </tbody>
              </table>
            </div>          
        </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import { mapGetters, mapState} from 'vuex'

export default 
{   computed: 
        {   ...mapGetters({    }),
            ...mapState({   user: state => state.authUser,
              selectedOrder: state => state.cstkt.selectedTicket.ticketlogs,
                        
                       }),
           
            orderHistoryTrans() 
                {  if (this.selectedOrder) 
                   {      for ( let j=0;j<this.selectedOrder.length;j++)
                                  {  var abc1=this.selectedOrder[j].function_name;
                                       // console.log('abc1=',abc1); 
                                       var abc2=""; var abc3="";var abc4="";
                                       var abc2=abc1.split("::"); 
                                       var abc3=abc2[1].split("csticket");
                                       if(abc3.length>1)
                                       {   if(abc3[0]=="add") abc4="Ticket Created"; 
                                           if(abc3[0]=="edit")abc4="Ticket Updated";
                                        } else 
                                        {  var abc3=abc2[1].split("Ticket");
                                           if(abc3[0]=="add") abc4="SubTicket Created"; 
                                           if(abc3[0]=="update") abc4="SubTicket Updated";
                                            if(abc3[0]=="delete") abc4="SubTicket Deleted";

                                        }
                                       this.selectedOrder[j].function1 =abc4;
                                  }
                          
                      return this.selectedOrder; 
                   }
                  else return null;
                }
        },
    created() {   },
    data () {  return {    }   },
    components: {    }
}
</script>

<style scoped>

td.center {
  text-align: center !important;
}
</style>