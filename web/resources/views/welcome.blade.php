<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="/js/vue.js"></script>
        <script src="/js/jquery-2.2.4.min.js"></script>

    </head>
    <body>
        <div style="text-shadow: 1px 1px 3px gray;" class="h1 text-center">
            PRESCRIBERS
        </div>
        <div class="flex-center">
            <div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <div id="app">
                        <table class="table">
                           <thead class="thead-dark">
                               <tr>
                                   <th v-on:click="sortByColumn('id');" id="col-id" scope="col">
                                       # <span v-if="columns.col == 'id'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('npi');" id="col-npi" scope="col">
                                       NPI <span v-if="columns.col == 'npi'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('name');" id="col-name" scope="col">
                                       Name <span v-if="columns.col == 'name'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('email');" id="col-email" scope="col">
                                       Email <span v-if="columns.col == 'email'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('phone');" id="col-phone" scope="col">
                                       Phone <span v-if="columns.col == 'phone'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('fax');" id="col-fax" scope="col">
                                       Fax <span v-if="columns.col == 'fax'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('role');" id="col-role" scope="col">
                                       Role <span v-if="columns.col == 'role'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr v-for="prescriber in items">
                                   <td scope="row" >@{{ prescriber.id }}</td>
                                   <td>@{{ prescriber.npi }}</td>
                                   <td>@{{ prescriber.name }}</td>
                                   <td>@{{ prescriber.email }}</td>
                                   <td>@{{ prescriber.phone }}</td>
                                   <td>@{{ prescriber.fax }}</td>
                                   <td>
                                       @{{ prescriber.role }}
                                       @{{ prescriber.is_admin }}
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                       <nav>
                           <ul class="pagination">
                               <li v-if="pagination.current_page > 1">
                                   <a href="#" aria-label="Previous"
                                      @click.prevent="changePage(pagination.current_page - 1)">
                                       <span aria-hidden="true">&laquo;</span>
                                   </a>
                               </li>
                               <li v-for="page in pagesNumber"
                                   v-bind:class="[ page == isActived ? 'active' : '']">
                                   <a href="#"
                                      @click.prevent="changePage(page)">@{{ page }}</a>
                               </li>
                               <li v-if="pagination.current_page < pagination.last_page">
                                   <a href="#" aria-label="Next"
                                      @click.prevent="changePage(pagination.current_page + 1)">
                                       <span aria-hidden="true">&raquo;</span>
                                   </a>
                               </li>
                           </ul>
                       </nav>
                </div>
            </div>
        </div>
        <script>
            new Vue({
                   el: '#app',
                   data: {
                       pagination: {
                           total: 100,
                           lastPage: 100,
                           per_page: 7,
                           from: 1,
                           to: 0,
                           current_page: 1
                       },
                       offset: 4,// left and right padding from the pagination <span>
                       items: [],
                       columns: {
                           col: "id",
                           asc: true
                       },
                   },
                   mounted: function () {
                       this.loadState();
                       this.fetchItems(this.pagination.current_page);
                   },
                   computed: {
                       isActived: function() {
                           return this.pagination.current_page;
                       },
                       pagesNumber: function () {
                           if (!this.pagination.to) {
                               return [];
                           }
                           var from = this.pagination.current_page - this.offset;
                           if (from < 1) {
                               from = 1;
                           }
                           var to = from + (this.offset * 2);
                           if (to >= this.pagination.last_page) {
                               to = this.pagination.last_page;
                           }
                           var pagesArray = [];
                           while (from <= to) {
                               pagesArray.push(from);
                               from++;
                           }
                           return pagesArray;
                       }//end pagesNumber
                   },//end computed
                   methods: {
                       fetchItems: function (page) {
                           var data = {page: page};
                           var vm = this;
                           $.get( "api/prescribers?page=" + page, function( data ) {
                             vm.items = data.data.data;
                             vm.pagination = data.pagination;
                             vm.sortByColumn();
                            });
                       },
                       sortByColumn: function (column = false){
                           if (!column){
                               column = this.columns.col;
                           }else if (this.columns.col === column){
                               this.columns.asc = !this.columns.asc;
                           }else{
                               this.columns.col = column;
                               this.columns.asc = true;
                           }

                           var vm = this;
                           this.items.sort(function(a, b){
                               if (a[column] < b[column]){
                                   return ((vm.columns.asc)?-1:1);
                               }else if (a[column] == b[column]){
                                   return 0;
                               }
                               return ((vm.columns.asc)?1:-1);
                           })
                           this.storeState();
                       },
                       storeState: function(){
                           localStorage.setItem('pagination', JSON.stringify(this.pagination));
                           localStorage.setItem('columns', JSON.stringify(this.columns));
                       },
                       loadState: function(){
                           var lp = JSON.parse(localStorage.getItem('pagination'));
                           var col = JSON.parse(localStorage.getItem('columns'));
                           if (lp){
                               this.pagination = lp
                           }
                           if (col){
                               this.columns = col;
                           }
                       }
                   }
               }//end Vue App
           );//end Vue App
        </script>
    </body>
</html>
