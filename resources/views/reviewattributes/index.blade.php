@extends('layouts.app')


@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.reviewattribute_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.reviewattribute_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
<div id="data-table_processing" class="dataTables_processing panel panel-default"
                            style="display: none;">{{trans('lang.processing')}}
                        </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                        class="fa fa-list mr-2"></i>{{trans('lang.reviewattribute_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('reviewattributes.create') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.reviewattribute_create')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">

                        
                    {{--
                        <div id="users-table_filter" class="pull-right">
                            <div class="row">

                                <div class="col-sm-9">
                                    <label>{{trans('lang.search_by')}}
                                        <select name="selected_search" id="selected_search"
                                            class="form-control input-sm">
                                            <option value="title">{{trans('lang.reviewattribute_name')}}</option>
                                        </select>
                                        <div class="form-group">
                                            <input type="search" id="search" class="search form-control"
                                                placeholder="Search" aria-controls="users-table">
                                    </label>&nbsp;<button onclick="searchtext();" class="btn btn-warning btn-flat">
                                        {{trans('lang.search')}}
                                    </button>&nbsp;<button onclick="searchclear();" class="btn btn-warning btn-flat">
                                        {{trans('lang.clear')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="table-responsive m-t-10">


                        <table id="example24"
                            class="display nowrap table table-hover table-striped table-bordered table table-striped"
                            cellspacing="0" width="100%">

                            <thead>

                                <tr>

                                    <th>{{trans('lang.reviewattribute_name')}}</th>

                                    <th>{{trans('lang.actions')}}</th>

                                </tr>

                            </thead>

                            <tbody id="append_list1">


                            </tbody>

                        </table>
                      {{--  <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item ">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_previous_btn"
                                        onclick="prev()" data-dt-idx="0" tabindex="0">{{trans('lang.previous')}}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                        onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                </li>
                            </ul>
                        </nav>--}}
                    </div>
                </div>
            </div>




        </div>

    </div>

</div>

</div>

</div>

</div>

</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];

    var ref = database.collection('review_attributes');
    var append_list = '';

    $(document).ready(function () {

        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';

            html = buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }
            $('#example24').DataTable({
                
                order: [],
                columnDefs: [
                    {orderable: false, targets: [1]},
                ],
                order: [0,"asc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
        });

    });

    function buildHTML(snapshots) {
        var html = '';
        var alldata = [];
        var number = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            alldata.push(datas);
        });

        var count = 0;
        alldata.forEach((listval) => {

            var val = listval;

            html = html + '<tr>';
            newdate = '';

            var id = val.id;
            var route1 = '{{route("reviewattributes.edit",":id")}}';
            route1 = route1.replace(':id', id);

            html = html + '<td>' + val.title + '</td>';
            html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a><a id="' + val.id + '" name="reviewattribute-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';


            html = html + '</tr>';
            count = count + 1;
        });
        return html;
    }

    function prev() {
        if (endarray.length == 1) {
            return false;
        }
        end = endarray[endarray.length - 2];

        if (end != undefined || end != null) {
            jQuery("#data-table_processing").show();
            if (jQuery("#selected_search").val() == 'title' && jQuery("#search").val().trim() != '') {

                listener = ref.orderBy('title').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').startAt(end).get();
            } else {
                listener = ref.startAt(end).limit(pagesize).get();
            }

            listener.then((snapshots) => {
                html = '';
                html = buildHTML(snapshots);
                jQuery("#data-table_processing").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.splice(endarray.indexOf(endarray[endarray.length - 1]), 1);

                    if (snapshots.docs.length < pagesize) {

                        jQuery("#users_table_previous_btn").hide();
                    }

                }
            });
        }
    }

    function next() {
        if (start != undefined || start != null) {

            jQuery("#data-table_processing").hide();

            if (jQuery("#selected_search").val() == 'title' && jQuery("#search").val().trim() != '') {

                listener = ref.orderBy('title').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').startAfter(start).get();
            } else {
                listener = ref.startAfter(start).limit(pagesize).get();
            }
            listener.then((snapshots) => {

                html = '';
                html = buildHTML(snapshots);
                console.log(snapshots);
                jQuery("#data-table_processing").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];

                    if (endarray.indexOf(snapshots.docs[0]) != -1) {
                        endarray.splice(endarray.indexOf(snapshots.docs[0]), 1);
                    }
                    endarray.push(snapshots.docs[0]);
                }
            });
        }
    }

    function searchclear() {
        jQuery("#search").val('');
        searchtext();
    }

    function searchtext() {

        jQuery("#data-table_processing").show();

        append_list.innerHTML = '';

        if (jQuery("#selected_search").val() == 'title' && jQuery("#search").val().trim() != '') {

            wherequery = ref.orderBy('title').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').get();

        } else {

            wherequery = ref.limit(pagesize).get();
        }

        wherequery.then((snapshots) => {
            html = '';
            html = buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);

                if (snapshots.docs.length < pagesize) {

                    jQuery("#data-table_paginate").hide();
                } else {

                    jQuery("#data-table_paginate").show();
                }
            }
        });

    }

    $(document).on("click", "a[name='reviewattribute-delete']", function (e) {
        var id = this.id;
        database.collection('review_attributes').doc(id).delete().then(function (result) {
            window.location.href = '{{ route("reviewattributes")}}';
        });
    });

</script>

@endsection