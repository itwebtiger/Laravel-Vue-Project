<template>
  <div id="root-order-history-summary">
    <div class="app-row">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <a class="accordion-toggle" data-toggle="collapse"  href="#csticketinfoo"> Ticket No: {{ selectedTicket1 ? selectedTicket1.ticket_no  : ''  }} [ {{selectedTicketType ? selectedTicketType : '' }} ] </a>
              <span class="pull-right"> <button class="btn btn-info btn-xs" @click.prevent="onClickPdf">SAVE PDF</button>
                                        <button class="btn btn-success btn-sm" @click.prevent="onClickNew">NEW</button> 
                                        <button class="btn btn-warning btn-sm" @click.prevent="onClickEdit">EDIT</button>
                                        <button class="btn btn-danger btn-sm" @click.prevent="onClickDel">DEL</button>
              </span>
            </div>
            <div id="csticketinfoo" class="panel-collapse collapse in table-responsive">
              <table class="table table-hover table-striped table-responsive table-bordered table-condensed">
               
                <tbody>
                      <tr><td>Credit Note ID</td><td colspan="2"> {{csticket[0] ? csticket[0].id: '' }}</td></tr>
                      <tr><td>Ticket No</td><td colspan="2"> {{csticket[0] ? csticket[0].ticket_no: '' }}</td></tr>
                       <tr><td>Price</td><td colspan="2"> {{csticket[0] ? csticket[0].amount: '' }}</td></tr>
                        <tr><td>Reason</td><td colspan="2"> {{csticket[0] ? csticket[0].aaa: '' }}</td></tr>
                        <tr><td>Status</td><td colspan="2"> {{csticket[0] ? csticket[0].tstatus.STATUS: '' }}</td></tr>
                      
                      <tr><td>Approving User : Group </td>
                        <td>{{ csticket[0] ? csticket[0].auserid.name : '' }}</td>
                        <td>{{ csticket[0] ? csticket[0].agroupid.name : '' }}</td>
                      </tr>
                     <tr><td>Comments</td><td colspan="2"> {{ csticket[0] ? csticket[0].comment : '' }}</td></tr>
                    <tr><td>Created By/ Updated By </td>
                        <td>{{ csticket[0] ? csticket[0].created_by.name : '' }}</td>
                        <td>{{ csticket[0] ? csticket[0].updated_by.name : '' }}</td>
                    </tr>
                    <tr><td>Created At/ Updated At </td>
                        <td>{{ csticket[0] ? csticket[0].created_at : '' }}</td>
                        <td>{{ csticket[0] ? csticket[0].updated_at : '' }}</td>
                    </tr>
                   
                    <td class="center">

                </td>

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
//import PermissionCustomActions from './Type2A/CsTicketType2ACustomActions.vue'
import jsPDF from 'jspdf'
import modal from 'vue-strap/src/Modal'
import input from 'vue-strap/src/Input'
import imgurl from '../../../img/logo.png'


export default 
{    computed: 
        { ...mapGetters({    }),
          ...mapState({ user: state => state.authUser,
                        selectedTicketttype1: state => state.cstkt.selectedTicket.ttype2a, //from main page--no subticket added
                        csType1perTicket: state => state.cstickettype.csType2AperTicket, //after update
                        selectedTicket: state => state.cstkt.selectedTicket,
                        selectedTicketType: state => state.cstkt.selectedTicketType,
                      }),
          selectedTicket1(){  console.log('/2a/- this.selectedTicket=',this.selectedTicket);
                              return this.selectedTicket; 
                           },
          csticket() {  console.log('/2a/- this.selectedTicketttype1=',this.selectedTicketttype1); 
                        if (this.csType1perTicket )  
                              { console.log('/2a/ this.csType1perTicket=',this.csType1perTicket); 
                                console.log('/2a/ this.selectedTicketttype1=',this.selectedTicketttype1); 
                                console.log('/2a/ this.csType1perTicket[0].ttype1=',this.csType1perTicket[0].ttype2a);
                                if(this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no)
                                {     console.log('/2a/ this.csType1perTicket[0].ttype1', this.csType1perTicket[0].ttype2a);
                                      return this.csType1perTicket[0].ttype2a;
                                }
                                else  return this.selectedTicketttype1;
                              } 
                        else if (this.selectedTicketttype1)  
                            {   console.log('this.selectedTicketttype1=',this.selectedTicketttype1); 
                                return this.selectedTicketttype1;
                            } 
                        else return null; 
                     },
        }, //computed finish

    created() {   console.log('cs/cstickettype1.vue-in created-.this.csticket', this.selectedTicket); 
              },
    data () {  return {    }   },
    components: {       },
    updated() {   console.log('cs/cstickettype1.vue-in updated-.this.selectedorder', this.selectedTicketttype1); 
              },
    methods: 
          { onClickNew() 
              { console.log('cs/cstickettype1.vue-onClickNew');
                let formData = {   ticket_no: '',ticket_type_id: '',QUOTE_ID: '',ORDER_ID: '',
                                   location_id: '',  name: '',  title: '',  id: ''
                               };
                let payload = { isShow: true, data: {action: 'Add', data: formData,index: 0} };
                if(this.selectedTicketttype1.length > 0) 
                {   if (this.csType1perTicket && this.csType1perTicket[0].ttype2a.length === 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no )  
                     {  console.log('inside 1st--deletion done--this.csType1perTicket',this.csType1perTicket);
                        this.$store.dispatch('setCsTicketType2AShowModal', payload)
                     }
                     else{
                          console.log('this.selectedTicketttype1.length>0',this.selectedTicketttype1);
                          if(this.csType1perTicket) console.log('csType1perTicket=',this.csType1perTicket);
                          this.$store.dispatch('showErrorNotification', 'Credit Note is already added to this Ticket !');
                          return;
                     }
                } else if (this.csType1perTicket && this.csType1perTicket[0].ttype2a.length > 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no )  
                     {  console.log('inside 2nd-this.csType1perTicket',this.csType1perTicket);
                        this.$store.dispatch('showErrorNotification', 'Credit Note is already added to this Ticket !');
                        return;
                     }
                else {this.$store.dispatch('setCsTicketType2AShowModal', payload)  //----triggers this in store--with empty data and opens new popup for adding
                }
             }, //onclicknew finish
              onClickEdit() 
              {   console.log('cs/cstickettype1.vue-onClickNew');
                 // let formData = {   ticket_no: '',ticket_type_id: '',QUOTE_ID: '',ORDER_ID: '', location_id: '',  name: '',  title: '',  id: ''  };
                  let payload = { isShow: true, data: {action: 'Edit' } };  // data: formData,index: 0} };
                  if(this.selectedTicketttype1.length > 0) 
                    {    if (this.csType1perTicket && this.csType1perTicket[0].ttype2a.length === 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no )  
                            { this.$store.dispatch('showErrorNotification', 'Nothing to Edit!');}
                          else {this.$store.dispatch('setCsTicketType2AShowModal', payload)}
                    } 
                  else if (this.csType1perTicket && this.csType1perTicket[0].ttype2a.length > 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no ) 
                    {   this.$store.dispatch('setCsTicketType2AShowModal', payload)    }
                  else 
                    { this.$store.dispatch('showErrorNotification', 'Please add Credit Note to this Ticket !');
                      return;
                    }
              }, //onclickEdit finish
              onClickPdf() 
              {       var img = new Image();
                      img.src = imgurl;  var cstkt=this.csticket[0];
                      console.log('this.cstickt[0]=',cstkt);
                     
                      var doc = new jsPDF();
                         img.onload = function()
                         {
                           doc.addImage(img,  'png', 5, 5, 40, 10);
                           doc.setFontSize(6);  
                           doc.text("Dowell Windows Pty Ltd.", 10, 20);
                           doc.text("ABN 78 004 069 523", 10, 22);
                     
                           doc.setFontSize(20); 
                           doc.text(80, 10, "CREDIT NOTE");

                           doc.setFontSize(15); 
                           doc.text(50, 40, 'Credit Note No.');if(cstkt.id) doc.text(110, 40, String(cstkt.id));
                           doc.text(50, 50, 'Ticket Number'); if(cstkt.ticket_no) doc.text(110, 50, cstkt.ticket_no);
                           doc.text(50, 60, 'Approving User');  if(cstkt.auserid.name) doc.text(110, 60, cstkt.auserid.name);
                           doc.text(50, 70, 'Amount'); if(cstkt.amount)  doc.text(110, 70, cstkt.amount);
                           doc.text(50, 80, 'Status');  if(cstkt.tstatus.STATUS) doc.text(110, 80, cstkt.tstatus.STATUS);
                           doc.text(50, 90, 'Comments'); if(cstkt.comment) doc.text(110, 90, cstkt.comment);
                             //-------------------------------
                           doc.save('CreditNote.pdf');
                          };
              },
             onClickDel()
              {   if(this.selectedTicketttype1.length > 0) 
                     {    
                         if (this.csType1perTicket && this.csType1perTicket[0].ttype2a.length === 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no )  
                          { console.log('already deleted--this.csType1perTicket',this.csType1perTicket);
                            this.$store.dispatch('showErrorNotification', 'Whats this-- Pls add something !');
                            return;
                          }
                          else
                          {
                            let data=this.csticket[0];
                            let payload = { isShow: true, data: data   };
                            console.log('delete this.selectedTicketttype1.length > 0=',this.selectedTicketttype1 );
                            console.log('delete 1st- payload=',payload );
                            let swal = this.$swal;  let me = this;
                            this.$swal({
                                      title: 'Are you sure?',
                                      text: 'You will not be able to recover this Credit Note!',
                                      type: 'warning',   showCancelButton: true,
                                      confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                                      confirmButtonText: 'Yes',  cancelButtonText: 'cancel',
                                      allowOutsideClick: false
                                     }).then(  function() {    me.$store.dispatch('deletetype2A', data)
                                                                  .then((response) => {
                                                                    console.log(' delete success'); 
                                                                     me.$events.fire('refreshcsticket');
                                                                    })
                                                                  .catch((error) => {});
                                                          }, 
                                                function (dismiss) {       }
                                             );
                                  return;
                                
                                   
                            }
                       } else if(this.csType1perTicket && this.csType1perTicket[0].ttype2a.length > 0 && this.csType1perTicket[0].ticket_no == this.selectedTicket.ticket_no ) 
                                {   let data=this.csticket[0];
                                    let payload = { isShow: true, data: data   };
                                    console.log('delete 2nd- payload',payload );
                                    let swal = this.$swal;     let me = this;
                                    this.$swal({
                                              title: 'Are you sure?',
                                              text: 'You will not be able to recover this Credit Note!',
                                              type: 'warning',  showCancelButton: true,
                                              confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                                              confirmButtonText: 'Yes',   cancelButtonText: 'cancel',
                                              confirmButtonClass: 'btn btn-success',  cancelButtonClass: 'btn btn-danger',
                                              allowOutsideClick: false
                                            }).then(  function() {    me.$store.dispatch('deletetype2A', data)
                                                                    .then((response) => {console.log(' delete success'); 
                                                                     me.$events.fire('refreshcsticket');
                                                                                       })
                                                                    .catch((error) => {});
                                                                     
                                                                  }, 
                                                      function (dismiss) {       }
                                                    );
                                     
                                   
                                     console.log('refresh done--after delete2');
                                     return;
                                  
                               // this.$store.dispatch('setCsTicketType2AShowModal', payload) 
                             }
                         else 
                              { this.$store.dispatch('showErrorNotification', 'nothing to delete !');
                                return;
                              }
                      }//del finish
          },//methods finish

          watch: 
          {    }
}
</script>

<style scoped>
td.center {  text-align: center !important; }
</style>