<template>
        <vue-bootstrap4-table :rows="rows"
                              :columns="columns"
                              :config="config"
                              @on-change-query="onChangeQuery"
                              :total-rows="total_rows"
                              :actions="actions"
                              @click="openNew"
                              :new_route="new_route"
                              :sort_value="sort_value">
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
            <template slot="actions" slot-scope="props" >
                <span>
                    <form :action="actionArray[props.row.id]" method="POST">
                        <a class="btn btn-primary" :href="hrefArray[props.row.id]">
                            <i class="fa fa-edit"></i>
                        </a>
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </span>

             </template>
        </vue-bootstrap4-table>
</template>

<script>
import VueBootstrap4Table from 'vue-bootstrap4-table'

export default {
    name: 'App',

     props : ['href','action','csrf','new_route','sort_value'],

    data: function() {
        return {
            rows: [],
            columns: [{
                    label: "#",
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
                    label: "Razão Social",
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
            actions: [
                {
                    btn_text: "Novo",
                    event_name: "click",
                    class: "btn btn-primary"
                }
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
                per_page: 10,
                per_page_options: [10,15,20],
            },
            queryParams: {
                sort: JSON.parse(this.sort_value),
                filters: [],
                global_search: "",
                per_page: 10,
                page: 1,
            },
            total_rows: 0,
            showLoader: true,

            hrefArray: JSON.parse(this.href),
            actionArray: JSON.parse(this.action),
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
                    self.rows = response.data.data.data;
                    self.total_rows = response.data.data.total;
                    self.showLoader = true;
                })
                .catch(function(error) {
                    self.showLoader = false;
                    console.log(error);
                });
        },
        openNew() {
            window.open(this.new_route,"_self");
        },
    },
    components: {
        VueBootstrap4Table
    },

    mounted() {
        this.fetchData();
    },


}
</script>
