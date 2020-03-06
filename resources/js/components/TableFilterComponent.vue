<template>
        <vue-bootstrap4-table :rows="rows"
                              :columns="columns"
                              :config="config"
                              @on-change-query="onChangeQuery"
                              :total-rows="total_rows"
                              :actions="actions"
                              @click="openNew"
                              :new_route="new_route"
                              :sort_value="sort_value"
                              :classes="classes"
                              :edit="edit"
                              :msg_destroy="msg_destroy">
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
                    <form :action="actionArray[props.row.id]" method="POST" :id="'form-destroy-id-'+props.row.id">
                        <a class="btn btn-primary" :href="hrefArray[props.row.id]">
                            <i class="fa fa-edit"></i>
                        </a>
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="_method" value="DELETE" v-if="seen">
                        <button type="submit" class="btn btn-danger destroy" v-if="seen"
                        data-toggle="modal" data-target="#confirm-delete" :data-id="props.row.id"
                        :data-msg-destroy="msg_destroy">
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

    props: {
        href: String,
        action: String,
        csrf: String,
        new_route: String,
        sort_value: String,
        array_coluns: String,
        get_router: String,
        edit: Boolean,
        msg_destroy: {
            default: 'Deseja realmente deletar esse item do sistema?'
        }
    },

    data: function() {
        return {

            seen: this.edit,

            rows: [],

            columns: JSON.parse(this.array_coluns),

            classes: {
                    tableWrapper: "outer-table-div-class wrapper-class-two",
                    table : {
                        "table-striped my-class" : true,
                        "table-bordered my-class-two" : function(rows) {
                            return true
                        }
                    },
                    row : {
                        "my-row my-row2" : true,
                        "function-class" : function(row) {
                            return row.id == 1
                        }
                    },
                    cell : {
                        "my-cell my-cell2" : true,
                        "text-danger" : function(row,column,cellValue) {
                            return column.name == "salary" && row.salary > 2500
                        }
                    }
                },

            actions: [
                {
                    btn_text: this.edit ? "Novo" : '',
                    event_name: "click",
                    class: "btn btn-primary " + (this.edit ? '' : 'd-none'),
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
            axios.get(this.get_router, {
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
