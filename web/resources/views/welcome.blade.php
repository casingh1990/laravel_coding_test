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
                                       # <span v-if="columns.col = 'id'"><span v-if="columns.asc">/|\</span><span v-else>\|/<span></span>
                                   </th>
                                   <th v-on:click="sortByColumn('npi');" id="col-npi" scope="col">
                                       NPI
                                   </th>
                                   <th v-on:click="sortByColumn('name');" id="col-name" scope="col">
                                       Name
                                   </th>
                                   <th v-on:click="sortByColumn('email');" id="col-email" scope="col">
                                       Email
                                   </th>
                                   <th v-on:click="sortByColumn('phone');" id="col-phone" scope="col">
                                       Phone
                                   </th>
                                   <th v-on:click="sortByColumn('fax');" id="col-fax" scope="col">
                                       Fax
                                   </th>
                                   <th v-on:click="sortByColumn('role');" id="col-role" scope="col">
                                       Role
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
                   }//end computed
               }//end Vue App
           );//end Vue App
        </script>
    </body>
</html>
