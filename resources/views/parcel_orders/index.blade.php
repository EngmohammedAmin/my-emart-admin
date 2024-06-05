@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.parcel_plural')}} {{trans('lang.order_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb" id="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.parcel_plural')}} {{trans('lang.order_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{ trans('lang.processing')}}
        </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                        <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        <!-- <div id="users-table_filter" class="pull-right">
                                <label>{{trans('lang.search_by')}}
                                    <select name="selected_search" id="selected_search" class="form-control input-sm">
                                        <option value="status">{{trans('lang.order_order_status_id')}}</option>
                                        <option value="id">{{trans('lang.order_id')}}</option>

                                    </select>
                                </label>&nbsp;
                                <div class="form-group">

                                    <select id="order_status" class="form-control">
                                        <option value="All">{{ trans('lang.all')}}</option>
                                        <option value="Order Placed">{{ trans('lang.order_placed')}}</option>
                                        <option value="Order Accepted">{{ trans('lang.order_accepted')}}</option>
                                        <option value="Order Rejected">{{ trans('lang.order_rejected')}}</option>
                                        <option value="Driver Pending">{{ trans('lang.driver_pending')}}</option>
                                        <option value="Driver Rejected">{{ trans('lang.driver_rejected')}}</option>
                                        <option value="Order Shipped">{{ trans('lang.order_shipped')}}</option>
                                        <option value="In Transit">{{ trans('lang.in_transit')}}</option>
                                        <option value="Order Completed">{{ trans('lang.order_completed')}}</option>
                                    </select>
                                    <input type="search" id="search" class="search form-control" placeholder="Search"
                                           aria-controls="users-table" style="display:none">

                                    <button onclick="searchtext();"
                                            class="btn btn-warning btn-flat">{{trans('lang.search')}}
                                    </button>&nbsp;<button
                                            onclick="searchclear();"
                                            class="btn btn-warning btn-flat">{{trans('lang.clear')}}
                                    </button>
                                </div>
                            </div> -->


                        <div class="table-responsive m-t-10">
                            <table id="parcelTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>

                                    <tr>

                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>

                                        <th>{{trans('lang.order_id')}}</th>

                                        <th>{{trans('lang.item_review_user_id')}}</th>
                                        <th>{{trans('lang.driver')}}</th>

                                        <th>{{trans('lang.amount')}}</th>

                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.order_order_status_id')}}</th>
                                        <th>{{trans('lang.actions')}}</th>

                                    </tr>

                                </thead>

                                <tbody id="append_list1">


                                </tbody>

                            </table>
                            <div id="data-table_paginate" style="display:none">
                                <!-- <nav aria-label="Page navigation example" class="pagination_div">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item ">
                                                <a class="page-link" href="javascript:void(0);"
                                                   id="users_table_previous_btn" onclick="prev()" data-dt-idx="0"
                                                   tabindex="0">{{trans('lang.previous')}}</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript:void(0);"
                                                   id="users_table_next_btn" onclick="next()" data-dt-idx="2"
                                                   tabindex="0">{{trans('lang.next')}}</a>
                                            </li>
                                        </ul>
                                    </nav> -->
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

    var append_list = '';
    var user_number = [];

    var driverID = '{{$id}}';

    var refData = database.collection('parcel_orders');
    var ref = database.collection('parcel_orders').orderBy('createdAt', 'desc');

    if(driverID){
        var refData = database.collection('parcel_orders').where('driverID','==',driverID);
        var ref = database.collection('parcel_orders').where('driverID','==',driverID).orderBy('createdAt', 'desc');
    }

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;

    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function(snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });

    $(document).ready(function() {
        var order_status = jQuery('#order_status').val();
        var search = jQuery("#search").val();


        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        jQuery('#search').hide();

        $(document.body).on('change', '#selected_search', function() {

            if (jQuery(this).val() == 'status') {
                jQuery('#order_status').show();
                jQuery('#search').hide();
            } else {

                jQuery('#order_status').hide();
                jQuery('#search').show();

            }
        });


        jQuery("#data-table_processing").show();
        append_list = document.getElementById('append_list1');
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
            $('#parcelTable').DataTable({
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
                        targets: [0, 7]
                    },
                ],
                order: [
                    ['5', 'desc']
                ],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true
            });

        });

    });
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
            //console.log(val.id,val.author.id);
            var id = val.id;
            var vendorID = val.vendorID;
            var user_id = val.authorID;
            var route1 = '{{route("parcel_orders.edit",":id")}}';
            route1 = route1.replace(':id', id);

            var route2 = '{{route("users.edit",":id")}}';
            route2 = route2.replace(':id', user_id);

            var user_view = '{{route("users.view",":id")}}';
            user_view = user_view.replace(':id', user_id);

            var driver_id = val.driverID;
            var route3 = '{{route("drivers.edit",":id")}}';
            route3 = route3.replace(':id', driver_id);

            var driverView = '{{route("drivers.view",":id")}}';
            driverView = driverView.replace(':id', driver_id);

            html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label></td>';


            html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>';
            html = html + '<td data-url="' + route2 + '" class="redirecttopage">' + val.author.firstName + ' ' + val.author.lastName + '</td>';

            if (val.driver != undefined) {
                var firstName = val.driver.firstName;
                var lastName = val.driver.lastName;
                html = html + '<td data-url="' + driverView + '" class="redirecttopage">' + firstName + ' ' + lastName + '</td>';

            } else {
                var firstName = '';
                var lastName = '';
                html = html + '<td></td>';

            }



            var price = 0;



            price = buildParcelTotal(val);

            html = html + '<td>' + price + '</td>';

        var date = '';
        var time = '';
        if (val.hasOwnProperty("createdAt")) {
            try {
                date = val.createdAt.toDate().toDateString();
                time = val.createdAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
        } else {
            html = html + '<td></td>';
        }

            if (val.status == 'Order Placed') {
                html = html + '<td class="order_placed"><span>' + val.status + '</span></td>';

                }
                else if (val.status == 'Order Accepted') {
                    html = html + '<td class="order_accepted"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Rejected') {
                    html = html + '<td class="order_rejected"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Driver Pending') {
                    html = html + '<td class="driver_pending"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Driver Rejected') {
                    html = html + '<td class="driver_rejected"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Shipped') {
                    html = html + '<td class="order_shipped"><span>' + val.status + '</span></td>';

                } else if (val.status == 'In Transit') {
                    html = html + '<td class="in_transit"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Completed') {
                    html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

                } else {
                    html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

                }

                html = html + '<td class="action-btn"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a><a id="' + val.id + '" class="do_not_delete" name="order-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';


                html = html + '</tr>';

                return html;
            }


            $(document.body).on('change', '#order_status', function() {
                order_status = jQuery(this).val();
            });

            $(document.body).on('keyup', '#search', function() {
                search = jQuery(this).val();
            });
            var orderStatus = '<?php if (isset($_GET['status'])) {
                                    echo $_GET['status'];
                                } else {
                                    echo '';
                                } ?>';
            if (orderStatus) {
                if (orderStatus == 'order-placed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Placed');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_placed')}}</li>");

                } else if (orderStatus == 'order-confirmed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Accepted', 'Driver Accepted']);
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_accepted')}}</li>");

                } else if (orderStatus == 'order-shipped') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Shipped', 'In Transit']);
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_shipped')}}</li>");

                } else if (orderStatus == 'order-completed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Completed');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_completed')}}</li>");

                } else if (orderStatus == 'order-canceled') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Rejected');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_rejected')}}</li>");

                } else if (orderStatus == 'order-failed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Rejected');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.driver_rejected')}}</li>");

                } else if (orderStatus == 'order-pending') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Pending');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.driver_pending')}}</li>");

                } else {

                    ref = refData.orderBy('createdAt', 'desc');
                }
            }

            function prev() {
                if (endarray.length == 1) {
                    return false;
                }
                end = endarray[endarray.length - 2];

                if (end != undefined || end != null) {
                    jQuery("#data-table_processing").show();
                    if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val() != 'All' && jQuery("#order_status").val().trim() != '') {

                        listener = refData.orderBy('status').limit(pagesize).startAt(jQuery("#order_status").val()).endAt(jQuery("#order_status").val() + '\uf8ff').startAt(end).get();
                    } else if (jQuery("#selected_search").val() == 'id' && jQuery("#search").val().trim() != '') {

                        listener = refData.orderBy('id').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').startAt(end).get();
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

                    jQuery("#data-table_processing").show();

                    if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val() != 'All' && jQuery("#order_status").val().trim() != '') {

                        listener = refData.orderBy('status').limit(pagesize).startAt(jQuery("#order_status").val()).endAt(jQuery("#order_status").val() + '\uf8ff').startAfter(start).get();
                    } else if (jQuery("#selected_search").val() == 'id' && jQuery("#search").val().trim() != '') {

                        listener = refData.orderBy('id').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').startAt(end).get();
                    } else {
                        listener = ref.startAfter(start).limit(pagesize).get();
                    }
                    listener.then((snapshots) => {

                        html = '';
                        html = buildHTML(snapshots);

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

            $(document).on("click", "a[name='order-delete']", function(e) {
                var id = this.id;
                database.collection('parcel_orders').doc(id).delete().then(function(result) {
                    window.location.href = '{{ url()->current() }}';
                });


            });

            function searchclear() {
                jQuery("#search").val('');
                jQuery("#order_status").val('All');
                location.reload();
            }

            function searchtext() {
                var offest = 1;
                jQuery("#data-table_processing").show();

                append_list.innerHTML = '';

                if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val() != 'All' && jQuery("#order_status").val().trim() != '') {
                    wherequery = refData.orderBy('status').limit(pagesize).startAt(jQuery("#order_status").val()).endAt(jQuery("#order_status").val() + '\uf8ff').get();

                } else if (jQuery("#selected_search").val() == 'id' && jQuery("#search").val().trim() != '') {

                    wherequery = refData.orderBy('id').limit(pagesize).startAt(jQuery("#search").val()).endAt(jQuery("#search").val() + '\uf8ff').get();

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

            function buildParcelTotal(snapshotsProducts) {

                var adminCommission = snapshotsProducts.adminCommission;
                var adminCommissionType = snapshotsProducts.adminCommissionType;
                var discount = snapshotsProducts.discount;
                var subTotal = snapshotsProducts.subTotal;


                var total_price = subTotal;

                var intRegex = /^\d+$/;
                var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                if (intRegex.test(discount) || floatRegex.test(discount)) {

                    discount = parseFloat(discount).toFixed(2);
                    total_price -= parseFloat(discount);

                }

                var total_tax_amount = 0;

                if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting != '' && snapshotsProducts.taxSetting != null) {
                    for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                        var data = snapshotsProducts.taxSetting[i];

                        var tax = 0;

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {

                                tax = (data.tax * total_price) / 100;
                            } else {
                                tax = data.tax;
                            }
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }

                total_price += parseFloat(total_tax_amount);

                if (currencyAtRight) {

                    var total_price_val = total_price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var total_price_val = currentCurrency + "" + total_price.toFixed(decimal_degits);
                }

                return total_price_val;
            }

            $("#is_active").click(function() {
                $("#parcelTable .is_open").prop('checked', $(this).prop('checked'));

            });

            $("#deleteAll").click(function() {
                if ($('#parcelTable .is_open:checked').length) {
                    if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                        jQuery("#data-table_processing").show();
                        $('#parcelTable .is_open:checked').each(function() {
                            var dataId = $(this).attr('dataId');
                            //console.log(dataId);
                            database.collection('parcel_orders').doc(dataId).delete().then(function() {
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
</script>


@endsection