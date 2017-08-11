@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <page :custom-render="customRender"
        v-cloak>
        <span slot="header">
            <a class="btn btn-primary" href="/system/menus/create">
                {{ __("Create Menu") }}
            </a>
            <a class="btn btn-primary" href="/system/menus/reorder">
                {{ __("Reorder Menu") }}
            </a>
        </span>
        <div class="col-md-12">
            <data-table source="/system/menus"
                id="menus">
            </data-table>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            methods: {
                customRender(column, data, type, row, meta) {
                    switch(column) {
                        case 'icon':
                                return '<i class="' + data + '"></i>';
                        default:
                            toastr.warning('render for column ' + column + ' is not defined.' );
                            return data;
                    }
                }
            }
        });

    </script>

@endpush