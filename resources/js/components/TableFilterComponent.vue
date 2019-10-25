<template>
    <div id="app">
        <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config"
        @on-change-query="onChangeQuery" :total-rows="total_rows">
            <template slot="paginataion-previous-button">
                Anterior
            </template>
            <template slot="paginataion-next-button">
                Próximo
            </template>
            <template slot="column_actions" slot-scope="props">
                <i>
                    {{props.column.label}}
                </i>
            </template>
            <template slot="actions" slot-scope="props">
                <span>
                    <form :action="'http://easysystem/home/comercial/client/client/'+props.row.id" method="POST">
                        <a class="btn btn-primary" :href="href">
                            <i class="fa fa-edit"></i>
                        </a>
                        <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Post</router-link>
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </span>
             </template>
        </vue-bootstrap4-table>
    </div>
</template>

<script>
import VueBootstrap4Table from 'vue-bootstrap4-table'

export default {
    name: 'App',

     props : ['href','action','csrf'],

    data: function() {
        return {
            rows: [],
            columns: [{
                    label: "id",
                    name: "id",
                    filter: {
                        type: "simple",
                        placeholder: "id",
                        case_sensitive: true,
                        showClearButton: true,
                        filterOnPressEnter: true,
                        debounceRate: 1000,
                        placeholder: "Código do Cliente"
                    },
                    sort: true,
                    uniqueId: true
                },
                {
                    label: "First Name",
                    name: "razao_social",
                    filter: {
                        type: "simple",
                        case_sensitive: true,
                        showClearButton: true,
                        filterOnPressEnter: true,
                        debounceRate: 1000,
                        placeholder: "Razão Social"
                    },
                    sort: true,
                },
                {
                    label: "Ações",
                    name: "actions",
                    sort: false,
                },
                ],
            config: {
                checkbox_rows: false,
                rows_selectable: false,
                card_title: "",
                server_mode: true,
                loaderText: "Atualizando...",
                global_search: {
                    placeholder: "Enter custom Search text",
                    visibility: false,
                    case_sensitive: false,
                    showClearButton: false,
                    searchOnPressEnter: false,
                    searchDebounceRate: 1000,
                },
                show_refresh_button: false,
                show_reset_button: false,
                card_mode: false,
                pagination: true,
                pagination_info: false,
                per_page: 1,
                per_page_options: [1,5,10,15],
            },
            queryParams: {
                sort: [{"name":"id","order":"asc"}],
                filters: [],
                global_search: "",
                per_page: 1,
                page: 1,
            },
            total_rows: 0,
            showLoader: true,
        }
    },
    methods: {
        onChangeQuery(queryParams) {
            this.queryParams = queryParams;
            this.showLoader = true;
            this.fetchData();
        },
        fetchData() {
            let self = this;
            axios.get('/home/comercial/client/clients', {
                params: {
                    "queryParams": this.queryParams,
                    "page": this.queryParams.page
                    }
                })
                .then(function(response) {
                    console.log(response);
                    //xsaxs
                    self.rows = response.data.data.data;
                    self.total_rows = response.data.data.total;
                    self.showLoader = true;
                })
                .catch(function(error) {
                    self.showLoader = false;
                    console.log(error);
                });
            }

        },
        components: {
            VueBootstrap4Table
        },
        mounted() {
            this.fetchData();
        },
}
</script>
