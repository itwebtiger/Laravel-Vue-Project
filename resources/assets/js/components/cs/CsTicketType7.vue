<template>
  <div id="root-order-history-summary">
    <div class="app-row">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <a class="accordion-toggle" data-toggle="collapse"  href="#csticketinfoo">TYPE7: Notification for collection by customer</a>
              <span class="pull-right"> <button class="btn btn-success btn-sm" @click.prevent="onClickNew">NEW</button> </span>
            </div>
            <div id="csticketinfoo" class="panel-collapse collapse in table-responsive">
              <table class="table table-hover table-striped table-responsive table-bordered table-condensed">
                <thead>
                  <tr> <th>Ticket No</th><th>Date Time </th> <th>Description</th> <th>Comments</th><th>Status </th></tr>
                </thead>
                <tbody>
 
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
       {  ...mapGetters({    }),
          ...mapState({   user: state => state.authUser,
                          selectedOrder: state => state.tab.selectedOrder,
                          //csTicketdata: state => state.csticket.csTicketdata,
                          csTicketperQuote: state => state.csticket.csTicketperQuote,
                      }),
          order()   {  if (this.selectedOrder)  return this.selectedOrder;  else return null;    }, 
          csticket()   {  if (this.csTicketperQuote)  return this.csTicketperQuote;  else return null;    }, 
         //  csticket()   {  if (this.csTicketdata)  return this.csTicketdata;  else return null;    }, 

       },

    created() {   },
    data () {  return {    }   },
    components: {    },
    updated() {    console.log('Booking/OrderList/CsTicektInfo.vue-updated.this.selectedorder', this.selectedOrder.cs_ticketss); 
                   
              },
    methods: 
          { onClickNew() 
              { console.log('Booking/OrderList/CsTicektInfo.vue-onClickNew');
               // this.$store.dispatch('getLastTicket');
                let formData = {   ticket_no: '',ticket_type_id: '',QUOTE_ID: '',ORDER_ID: '',
                                   location_id: '',
                                   name: '',  title: '',  id: ''
                               };
                let payload = { isShow: true, data: {action: 'Add', data: formData} };
                this.$store.dispatch('setCsTicketShowModal', payload)  //----triggers this in store--with empty data and opens new popup for adding
              },
          }
}
</script>

<style scoped>
td.center {  text-align: center !important; }
</style>