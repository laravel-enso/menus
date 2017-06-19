@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <section class="content-header">
        <a class="btn btn-primary" href="/system/menus/create">
            {{ __("Create Menu") }}
        </a>
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>

    <section class="content">
        <div class="row" v-cloak>
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">
                            {{ __("Drag And Drop") }}
                        </div>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool btn-sm" data-widget="collapse">
                                <i class="fa fa-minus">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <center>
                            <reorderable-menu :menus="menus"
                                style="max-width: 400px;
                                padding-left: 0"
                                v-cloak>
                            </reorderable-menu>
                        <center>
                            <button id="save" class="btn btn-primary" @click="setOrder()">
                                {{ __("Save") }}
                            </button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>

        var vm = new Vue({
            el: '#app',

            data: {
                menus: {!! $treeMenu !!}
            },

            methods: {
                addEmptyChildrenArray(menus) {
                    var self = this;

                    menus.forEach(menu => {
                        if (!menu.hasOwnProperty('children')) {
                            menu.children = [];
                        } else {
                            self.addEmptyChildrenArray(menu.children);
                        }
                    });
                },
                setOrder() {
                    axios.patch('/system/menus/setOrder', { menus: this.menus }).then(response => {
                        window.location.reload();
                    });
                },
            },

            created() {
                this.addEmptyChildrenArray(this.menus);
            }
        });

    </script>

@endpush