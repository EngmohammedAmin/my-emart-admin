@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">


        <div class="col-md-5 align-self-center">


            <h3 class="text-themecolor">{{trans('lang.brand')}}</h3>


        </div>


        <div class="col-md-7 align-self-center">


            <ol class="breadcrumb">


                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>


                {{--<li class="breadcrumb-item">{{trans('lang.brand')}}</li>--}}


                <li class="breadcrumb-item active">{{trans('lang.brand_table')}}</li>


            </ol>


        </div>


        <div>


        </div>


    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}
        </div>

        <div class="row">


            <div class="col-12">


                <div class="card">

                    <div class="card-header">

                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">

                            <li class="nav-item">

                                <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.brand_table')}}</a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="{!! route('brands.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.brand_create')}}</a>

                            </li>


                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive m-t-10">
                            <table id="brandTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">

                                <thead>

                                    <tr>
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>

                                        <th>{{trans('lang.photo')}}</th>

                                        <th>{{trans('lang.title')}}</th>
                                        <th>{{trans('lang.section')}}</th>

                                        <th>
                                            {{trans('lang.item')}}
                                        </th>

                                        <th>{{trans('lang.item_publish')}}</th>


                                        <th>{{trans('lang.actions')}}</th>


                                    </tr>


                                </thead>


                                <tbody id="append_vendors">

                                </tbody>


                            </table>


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

    var ref = database.collection('brands');

    var append_list = '';

    var placeholderImage = '';

    var placeholder = database.collection('settings').doc('placeHolderImage');


    placeholder.get().then(async function(snapshotsimage) {

        var placeholderImageData = snapshotsimage.data();

        placeholderImage = placeholderImageData.image;

    });


    $(document).ready(function() {




        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_vendors');

        append_list.innerHTML = '';

        ref.get().then(async function(snapshots) {
            var html = '';
            html = await buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }
            $('#brandTable').DataTable({
                order: [],
                columnDefs: [{
                        targets: 5,
                        type: 'date',
                        render: function(data) {

                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 5, 6]
                    },
                ],
                order: [
                    ['2', 'asc']
                ],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true
            });
        });

    })
    async function buildHTML(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();

            let result = user_number.filter(obj => {
                return obj.id == val.author;
            })

            if (result.length > 0) {
                val.phoneNumber = result[0].phoneNumber;
                val.isActive = result[0].isActive;

            } else {
                val.phoneNumber = '';
                val.isActive = false;
            }

            var getData = await getListData(val);
            html += getData;
        }));
        return html;
    }

    async function getListData(val) {


        var html = '';


        html = html + '<tr>';
        newdate = '';

        var id = val.id;

        var route1 = '{{route("brands.edit",":id")}}';

        route1 = route1.replace(':id', id);
        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';

        if (val.photo != '') {

            html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + val.photo + '" alt="image"></td>';

        } else {

            html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image"></td>';

        }

        html = html + '<td><a href="' + route1 + '">' + val.title + '</a></td>';

        const section = getSectionName(val.sectionId);
        html = html + '<td class="sectionName_' + val.sectionId + '"></td>';


        getProductTotal(val.id);
        var brandId = val.id;
        var url = '{{url("items?brandID=id")}}';
        url = url.replace("id", brandId);

        html = html + '<td ><a class="product_' + val.id + '" href="' + url + '"></a></td>';

        if (val.is_publish) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
        }

        html = html + '<td class="vendor-action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a><a id="' + val.id + '" name="vendor-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';


        html = html + '</tr>';


        return html;
    }

    /* toggal publish action code start*/
    $(document).on("click", "input[name='publish']", function(e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('brands').doc(id).update({
                'is_publish': true
            }).then(function(result) {

            });
        } else {
            database.collection('brands').doc(id).update({
                'is_publish': false
            }).then(function(result) {

            });
        }
    });
    /*toggal publish action code end*/

    async function getSectionName(sectionId) {

        var refData = await database.collection('sections').where("id", "==", sectionId).get().then(async function(snapshots) {
          
            var data = snapshots.docs[0].data();

            $('.sectionName_' + sectionId).html(data.name);
          

        });

    }

    async function getProductTotal(id) {
        await database.collection('vendor_products').where('brandID', '==', id).get().then(async function(productSnapshots) {
            var Product_total = productSnapshots.docs.length;
            jQuery(".product_" + id).html(Product_total);
        });
    }

    $(document).on("click", "a[name='vendor-delete']", function(e) {
        var id = this.id;
        database.collection('brands').doc(id).delete().then(function() {
            window.location.reload();
        });
    });

    $("#is_active").click(function() {
        $("#example24 .is_open").prop('checked', $(this).prop('checked'));

    });

    $("#deleteAll").click(function() {
        if ($('#example24 .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#example24 .is_open:checked').each(function() {
                    var dataId = $(this).attr('dataId');
                    console.log(dataId);
                    database.collection('brands').doc(dataId).delete().then(function() {
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    function clickpage(value) {
        setCookie('pagesizes', value, 30);
        location.reload();
    }
</script>

@endsection