<template>
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-md-8">   
             <div class="row mt-5">
              <div class="col-md-8">   
                 <h2>Customer table</h2>
              </div>
              <div class="col-md-4">
                  <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addModal">Add new Customer</button> <!-- Button trigger modal -->
              </div>    
           </div>    
          </div>
         </div> 
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <table class="table mt-2">
                     <thead>
                          <tr>
                              <td>ID</td>
                              <td>NAME</td>
                              <td>ADDRESS</td>
                              <td>EMAIL</td>
                              <td>ACTION</td>    
                          </tr>    
                     </thead>
    
                     <tbody  v-for="customer in customers" v-bind:key="customer.id">                      
                           <tr>
                              <td>{{customer.id}}</td>
                              <td>{{customer.name}}</td>
                              <td>{{customer.email}}</td>
                              <td>{{customer.address}}</td>
                              <td>
                              
                              <a class="btn btn-primary far fa-edit"  data-toggle="modal" data-target="#editModal" @click="EditCustomer(customer)">Edit</a>
                              <button class="btn btn-danger far fa-trash-alt"  @click="deleteCustomer(customer.id)">Delete</button>
                            </td>    
                         </tr>
                        
                     </tbody>        
                 </table> 

                          <div v-if="seen">
                               <form>
                                    <div class="form-group ">    
                                        <input type="text" v-model="customer.name" class="form-control" placeholder="Enter name">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.address" class="form-control" placeholder="Enter address">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.email" class="form-control" placeholder="Enter email">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.phone" class="form-control" placeholder="Enter phone">
                                    </div>
                                     <button type="submit" class="btn btn-primary" @click="updateCustomer(customer.id)">Save</button>
                                     <a class="btn btn-info" @click="cancel">Exit</a>
                                  </form>
                             </div>
        
                        <!-- Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add new Customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="addCustomer(customer.id)">
                                    <div class="form-group ">    
                                        <input type="text" v-model="customer.name" class="form-control" placeholder="Enter name">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.address" class="form-control" placeholder="Enter address">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.email" class="form-control" placeholder="Enter email">
                                    </div>

                                    <div class="form-group">
                                         <input type="text" v-model="customer.phone" class="form-control" placeholder="Enter phone">
                                    </div>
                                     <button type="submit" class="btn btn-primary btn-block">Save</button>
                                  </form>
                            </div>
                
                            </div>
                        </div>
                        </div>

                       <!-- end modal -->
           
                    <div v-show="customers.length > 5">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mt-2">
                                <li v-bind:class="[{disabled:!pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCustomer(pagination.prev_page_url)">Previous</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                                <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCustomer(pagination.next_page_url)">Next</a></li>
                            </ul>
                        </nav>
                    </div>

                </div>         
           </div>
    </div>
</template>

<script>
    export default {

      data(){
        return{
           customers: [],
                 customer: {
                     'id':'',
                     'name':'',
                     'address':'',
                     'email':'',
                     'phone':'',
                 },
                    customer_id:'',
                    pagination:{},
                    edit:false,
                    seen:false,
            }
          
        },//end data
        
          created(){
            this.fetchCustomer();
        },// end of created

        methods:{

          fetchCustomer(page_url){
                let vm = this;
                page_url = page_url ||'api/customer'; 
                fetch(page_url)
                .then(res=>res.json())
                .then(res=>{
                    this.customers=res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err=>console.log(err));
            },

            makePagination(meta, links){
                let pagination = {
                    current_page:meta.current_page,
                    last_page:meta.last_page,
                    next_page_url:links.next,
                    prev_page_url:links.prev,
                }
              this.pagination = pagination;
            },

           addCustomer(){
                      
                if(this.edit===false){
                   fetch('api/customer',{
                       method:'post',
                       body:JSON.stringify(this.customer),
                       headers:{
                           'content-type':'application/json'
                       }
                   })
                   .then(res=>res.JSON)
                   .then(res=>{
                        this.customer.name='';
                        this.customer.address='';
                        this.customer.email='';
                        this.customer.phone='';
                        this.fetchCustomer();
                   });
                }
           },//end of add customer    

        updateCustomer(id){
           fetch(`api/customer/${id}`,{
                       method:'put',
                       body:JSON.stringify(this.customer),
                       headers:{
                           'content-type':'application/json'
                       }
                   })
                   .then(res=>res.JSON)
                   .then(res=>{
                        this.customer.name='';
                        this.customer.address='';
                        this.customer.email='';
                        this.customer.phone='';
                      //  alert("article updated");
                        this.fetchCustomer();
                   });
        },

             deleteCustomer(id){
                    if(confirm('Are you sure ?')){
                       fetch(`api/customer/${id}`,{
                           method:'delete'   
                        })
                    //    .then(res=>res.JSON())
                    //    .then(res=>{
                           this.fetchCustomer();
                        //   alert('article remove');
                        //   }) 
                       //.catch(err=>console.log(err));
                    } 
                   
            },

                EditCustomer(customer){
                this.seen=true;    
                this.edit=true;
                this.customer.id=customer.id;
                this.customer.name=customer.name;
                this.customer.address=customer.address;
                this.customer.email=customer.email;
                this.customer.phone=customer.phone;
            },

            cancel(){
                 this.seen=false;   
            }

        },//end of methods

        mounted() {
            console.log('Component mounted.')
        }

    }//end of export

</script>
