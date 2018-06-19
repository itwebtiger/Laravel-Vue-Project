<template>
  <div id="root-order-history-summary">
    <div class="app-row">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <a class="accordion-toggle" data-toggle="collapse"  href="#orderhistoryinfo">
                  Ticket Logs    Ticket No: {{ selectedTicket ? selectedTicket.ticket_no  : ''  }}
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
              selectedTicket: state => state.cstkt.selectedTicket,
              csType2AperTicket: state => state.cstickettype.csType2AperTicket,
              csType3perTicket: state => state.cstickettype.csType3perTicket,
              csType4perTicket: state => state.cstickettype.csType4perTicket,
              csType5perTicket: state => state.cstickettype.csType5perTicket,
                        
                       }),
             csticket() { 
                          if (this.csType2AperTicket )  
                              { console.log('logs inside type2a logs =',this.csType2AperTicket[0].ticketlogs);  
                                  var len=this.selectedTicket.ticketlogs.length;
                                  var len1=this.csType2AperTicket[0].ticketlogs.length;

                                 if(this.csType2AperTicket[0].ticket_no == this.selectedTicket.ticket_no && len1>len)
                                   {   return this.csType2AperTicket[0].ticketlogs;  }
                                  else  return this.selectedTicket.ticketlogs;
                              } 
                          else if (this.csType3perTicket )  
                              { console.log('logs inside type3 logs =',this.csType3perTicket[0].ticketlogs);  
                                  
                                if(this.csType3perTicket[0].ticket_no == this.selectedTicket.ticket_no)
                                   {   return this.csType3perTicket[0].ticketlogs;  }
                                  else  return this.selectedTicket.ticketlogs;
                              } 
                          else if (this.csType4perTicket )  
                              { console.log('logs inside type4 logs =',this.csType4perTicket[0].ticketlogs);    
                                 if(this.csType4perTicket[0].ticket_no == this.selectedTicket.ticket_no)
                                   {   return this.csType4perTicket[0].ticketlogs;  }
                                  else  return this.selectedTicket.ticketlogs;
                              } 
                          else if (this.csType5perTicket )  
                              {  console.log('logs inside type5 logs =',this.csType5perTicket[0].ticketlogs);   
                                if(this.csType5perTicket[0].ticket_no == this.selectedTicket.ticket_no)
                                   {   return this.csType5perTicket[0].ticketlogs;  }
                                  else  return this.selectedTicket.ticketlogs;
                              } 
                          else if (this.selectedTicket)  
                            {   console.log(' logs this.selectedTicket outside loop =',this.selectedTicket.ticketlogs); 
                                return this.selectedTicket.ticketlogs;
                            } 
                          else return null; 
                     },
           
            orderHistoryTrans() 
                {  if (this.csticket) 
                   {       console.log('/logs/this.csticket=',this.csticket); 
                     
                     for ( let j=0;j<this.csticket.length;j++)
                                  {  var abc1=this.csticket[j].function_name;
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
                                       this.csticket[j].function1 =abc4;
                                  }
                          
                      return this.csticket; 
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