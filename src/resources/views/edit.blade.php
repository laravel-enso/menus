@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <page v-cloak>
        <span slot="header">
            <a class="btn btn-primary" href="/system/menus/create">
                {{ __("Create Menu") }}
            </a>
            <a class="btn btn-primary" href="/system/menus/reorder">
                {{ __("Reorder Menu") }}
            </a>
        </span>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form">
                <template slot="icon" scope="props">
                    <div class="input-group">
                        <input class="form-control"
                            @keydown="props.errors.clear(props.element.column)"
                            v-model="props.element.value"
                            :name="props.element.column"
                            type="text">
                        <span class="input-group-addon">
                            <i :class="props.element.value">
                            </i>
                        </span>
                    </div>
                </template>
            </vue-form>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            data: {
                form: {!! $form !!}
            }
        });

    </script>

@endpush