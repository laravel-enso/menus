@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <page v-cloak>
        <span slot="header">
            <a class="btn btn-primary" href="/system/menus/create">
                {{ __("Create Menu") }}
            </a>
        </span>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <box theme="primary"
                collapsible removable
                border open footer
                title="{{ __('Drag And Drop') }}">
                <center>
                    <reorderable-menu :menus="menus"
                        style="max-width: 400px;padding-left: 0"
                        v-cloak>
                    </reorderable-menu>
                </center>
                <span slot="footer">
                    <center>
                        <button id="save" class="btn btn-primary" @click="setOrder()">
                            {{ __("Save") }}
                        </button>
                    </center>
                </span>
            </box>
        </div>
    </page>

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