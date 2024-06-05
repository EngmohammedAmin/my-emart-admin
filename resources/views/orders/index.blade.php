@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor orderTitle">{{ trans('lang.order_plural') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('lang.order_plural') }}</li>
                </ol>
            </div>
            <div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
                {{ trans('lang.processing') }}
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="menu-tab vendorMenuTab">

                        <ul>
                            <li>
                                <a href="{{ route('vendors.view', $id) }}">{{ trans('lang.tab_basic') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('vendors.items', $id) }}">{{ trans('lang.tab_items') }}</a>
                            </li>
                            <li class="active">
                                <a href="{{ route('vendors.orders', $id) }}">{{ trans('lang.tab_orders') }}</a>
                            </li>

                            <li>
                                <a href="{{ route('vendors.reviews', $id) }}">{{ trans('lang.tab_reviews') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('vendors.coupons', $id) }}">{{ trans('lang.tab_promos') }}</a>
                            <li>
                                <a href="{{ route('vendors.payout', $id) }}">{{ trans('lang.tab_payouts') }}</a>
                            </li>
                            <li class="dine_in_future" style="display:none;">
                                <a href="{{ route('vendors.booktable', $id) }}">{{ trans('lang.dine_in_future') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-body">


                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                            <!-- <div id="users-table_filter" class="pull-right">
                                                                                                                    <div class="row">
                                                                                                                        @if ($id == '')
    <div class="col-sm-9">
@else
    <div class="col-sm-12">
    @endif
                                                                                                                        <label>{{ trans('lang.search_by') }}
                                                                                                                        <select name="selected_search" id="selected_search"
                                                                                                                                class="form-control input-sm">
                                                                                                                            <option value="status">{{ trans('lang.order_order_status_id') }}</option>
                                                                                                                                        <?php /// if ($id == '') {
                                                                                                                                        ?>
                                                                                                                        <option value="vendor">{{ trans('lang.vendor') }}</option>
                                                                                                                                        <?php // }
                                                                                                                                        ?>
                                                                                                                        </select>
                                                                                                                    </label>
                                                                                                                    <div class="form-group">
                                                                                                                         <div id="selected_change"> -->
                          <!--  <select id="order_status" class="form-control">
                                <option value="All">{{ trans('lang.all') }}</option>
                                <option value="Order Placed">{{ trans('lang.order_placed') }}</option>
                                <option value="Order Accepted">{{ trans('lang.order_accepted') }}
                                </option>
                                <option value="Order Rejected">{{ trans('lang.order_rejected') }}
                                </option>
                                <option value="Driver Pending">{{ trans('lang.driver_pending') }}
                                </option>
                                <option value="Driver Rejected">{{ trans('lang.driver_rejected') }}
                                </option>
                                <option value="Order Shipped">{{ trans('lang.order_shipped') }}</option>
                                <option value="In Transit">{{ trans('lang.in_transit') }}</option>
                                <option value="Order Completed">{{ trans('lang.order_completed') }}
                                </option>
                            </select>
                            <input type="search" id="search" class="search form-control" placeholder="Search"
                                aria-controls="users-table"> -->

                            <!-- </div> -->
                            <!-- <button onclick="searchtext();"
                                                                                                                                            class="btn btn-warning btn-flat">{{ trans('lang.search') }}
                                                                                                                        </button>
                                                                                        &nbsp;<button onclick="searchclear();"
                                                                                                                                                  class="btn btn-warning btn-flat">{{ trans('lang.clear') }}
                                                                                                                        </button>
                                                                                                                    </div>
                                                                                                                    <div class="form-group">
                                                                                                                        <select id="pageSize" class="form-control pageSize"
                                                                                                                                onchange="clickpage(this.value)">
                                                                                                                            <option value="0">{{ trans('lang.select_limit') }}</option>
                                                                                                                                        <option value="10">10</option>
                                                                                                                                        <option value="20">20</option>
                                                                                                                                        <option value="50">50</option>
                                                                                                                                        <option value="100">100</option>
                                                                                                                                    </select>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="col-sm-3 sectionDiv">
                                                                                                                                <select id="section_id" class="form-control allModules" style="width:100%"
                                                                                                                                        onchange="clickLink(this.value)">
                                                                                                                                    <option value="">{{ trans('lang.select') }} {{ trans('lang.section_plural') }}
                                                                                                                        </option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div> -->

                            <div id="users-table_filter" class="pull-right">
                                <div class="row">
                                    <div class="col-sm-9">
                                    </div>
                                    <div class="col-sm-3 sectionDiv">
                                        <select id="section_id" class="form-control allModules" style="width:100%"
                                            onchange="clickLink(this.value)">
                                            <option value="">{{ trans('lang.select') }}
                                                {{ trans('lang.section_plural') }}
                                            </option>
                                        </select>
                                        <p style="color: red;font-size: 13px;">
                                            {{ trans('lang.rental_parcel_cab_service_are_not') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive m-t-10">
                                <table id="orderTable"
                                    class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                        class="do_not_delete" href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i>
                                                        {{ trans('lang.all') }}</a></label>
                                            </th>
                                            <th>{{ trans('lang.order_id') }}</th>

                                            @if ($id == '')
                                                <th>{{ trans('lang.vendor') }}</th>
                                                <th>{{ trans('lang.section') }}</th>
                                            @endif
                                            @if (isset($_GET['userId']))
                                                <th class="driverClass">{{ trans('lang.driver_plural') }}</th>
                                            @elseif (isset($_GET['driverId']))
                                                <th>{{ trans('lang.order_user_id') }}</th>
                                            @else
                                                <th class="driverClass">{{ trans('lang.driver_plural') }}</th>
                                                <th>{{ trans('lang.order_user_id') }}</th>
                                            @endif

                                            <th>{{ trans('lang.date') }}</th>
                                            <th>{{ trans('lang.vendors_payout_amount') }}</th>
                                            <th>{{ trans('lang.order_type') }}</th>
                                            <th>{{ trans('lang.order_order_status_id') }}</th>
                                            <th>{{ trans('lang.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_list1">
                                    </tbody>
                                </table>
                                <!-- <nav aria-label="Page navigation example">
                                                                                                                            <ul class="pagination justify-content-center">
                                                                                                                                <li class="page-item ">
                                                                                                                                    <a class="page-link" href="javascript:void(0);"
                                                                                                                                       id="users_table_previous_btn" onclick="prev()" data-dt-idx="0"
                                                                                                                                       tabindex="0">{{ trans('lang.previous') }}</a>
                                                                                                                                </li>
                                                                                                                                <li class="page-item">
                                                                                                                                    <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                                                                                                                       onclick="next()" data-dt-idx="2" tabindex="0">{{ trans('lang.next') }}</a>
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
@endsection

@section('scripts')
    <script type="text/javascript">
        var database = firebase.firestore();
        var vendor_id = '<?php echo $id; ?>';

        var offest = 1;
        var pagesize = 10;
        var pagesizes = 0;

        var end = null;
        var endarray = [];
        var start = null;
        var user_number = [];
        var append_list = '';

        var redData = ref;
        var currentCurrency = '';
        var currencyAtRight = false;
        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        var ref_sections = database.collection('sections');

        var decimal_degits = 0;
        refCurrency.get().then(async function(snapshots) {
            var currencyData = snapshots.docs[0].data();
            currentCurrency = currencyData.symbol;
            currencyAtRight = currencyData.symbolAtRight;

            if (currencyData.decimal_degits) {
                decimal_degits = currencyData.decimal_degits;
            }
        });

        var order_status = jQuery('#order_status').val();
        var search = jQuery("#search").val();
        $('.vendorMenuTab').hide();
        var getId = '<?php echo $id; ?>';

        if (getId != "") {
            $('.sectionDiv').hide();
            var refData = database.collection('vendor_orders');

        } else {

            $('.vendor_orders').show();
            var section_id = getCookie('section_id');

            if (section_id != '') {
                console.log(section_id);
                {{--  var refData = database.collection('vendor_orders').where('vendor.section_id', '==', section_id).orderBy(
                    'createdAt', 'desc');  --}}

                var refData = database.collection('vendor_orders').where('vendor.section_id', '==', section_id);
                refData.get().then(async function(snapshots) {
                    snapshots.docs.forEach((listval) => {
                        console.log(listval.data());
                    });
                });
            } else {
                var refData = database.collection('vendor_orders');

            }

        }

        $('.userClass').hide();
        $('.vendorClass').hide();
        $('.driverClass').hide();

        var ref = '';

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

        //       بحث الطلبات بحسب الحالة


        if (getId != "") {

            if (window.location.href.indexOf("userId") > -1) {

                getId = getId.split("=")[1];
                if (order_status == 'All' || order_status != '' || search != '') {
                    ref = refData.where('authorID', '==', getId);
                } else {
                    ref = refData.orderBy('createdAt', 'desc').where('authorID', '==', getId).where('status', '==',
                        order_status);
                }

                $('.vendorClass').show();
                $('.driverClass').show();

            } else if (window.location.href.indexOf("driverId") > -1) {
                getId = getId.split("=")[1];
                if (order_status == 'All' || order_status != '' || search != '') {
                    ref = refData.where('driverID', '==', getId);
                } else {
                    ref = refData.orderBy('createdAt', 'desc').where('driverID', '==', getId).where('status', '==',
                        order_status);
                }
                $('.userClass').show();
                $('.vendorClass').show();

            } else {
                $('.userClass').show();

                $('.driverClass').show();

                $('.vendorMenuTab').show();
                const getStoreName = getStoreNameFunction('@php echo $id; @endphp');
                if (order_status == 'All' || order_status != '' || search != '') {
                    ref = refData.where('vendorID', '==', getId);
                } else {
                    ref = refData.orderBy('createdAt', 'desc').where('vendorID', '==', getId).where('status', '==',
                        order_status);
                }
            }
        } else if (orderStatus) {
            if (orderStatus == 'order-placed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Placed');
            } else if (orderStatus == 'order-confirmed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Accepted', 'Driver Accepted']);
            } else if (orderStatus == 'order-shipped') {
                ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Shipped', 'In Transit']);
            } else if (orderStatus == 'order-completed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Completed');
            } else if (orderStatus == 'order-canceled') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Rejected');
            } else if (orderStatus == 'order-failed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Rejected');
            } else if (orderStatus == 'order-pending') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Pending');
            } else {

                ref = refData.orderBy('createdAt', 'desc');
            }


        } else {

            $('.userClass').show();
            $('.vendorClass').show();
            $('.driverClass').show();
            if (order_status == 'All' || order_status != '' || search != '') {
                ref = refData;


            } else {

                ref = refData.orderBy('createdAt', 'desc');
            }
        }

        var getId = '<?php echo $id; ?>';

        var userID = '<?php if (isset($_GET['userId'])) {
            echo $_GET['userId'];
        } else {
            echo '';
        } ?>';
        var driverID = '<?php if (isset($_GET['driverId'])) {
            echo $_GET['driverId'];
        } else {
            echo '';
        } ?>';
        var orderStatus = '<?php if (isset($_GET['status'])) {
            echo $_GET['status'];
        } else {
            echo '';
        } ?>';


        if (userID) {

            const getUserName = getUserNameFunction(userID);

            if ((order_status == 'All' || order_status != '') && search != '') {
                ref = refData.where('authorID', '==', userID);
            } else {
                ref = refData.orderBy('createdAt', 'desc').where('authorID', '==', userID);
            }

        } else if (driverID) {

            const getUserName = getUserNameFunction(driverID);

            if ((order_status == 'All' || order_status != '') && search != '') {
                ref = refData.where('driverID', '==', driverID);
            } else {
                ref = refData.orderBy('createdAt', 'desc').where('driverID', '==', driverID);
            }

        } else if (orderStatus) {
            if (orderStatus == 'order-placed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Placed');
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.order_placed') }}</li>");

            } else if (orderStatus == 'order-confirmed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Accepted', 'Driver Accepted']);
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.order_accepted') }}</li>");

            } else if (orderStatus == 'order-shipped') {
                ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Shipped', 'In Transit']);
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.order_shipped') }}</li>");

            } else if (orderStatus == 'order-completed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Completed');
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.order_completed') }}</li>");

            } else if (orderStatus == 'order-canceled') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Rejected');
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.order_rejected') }}</li>");

            } else if (orderStatus == 'order-failed') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Rejected');
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.driver_rejected') }}</li>");

            } else if (orderStatus == 'order-pending') {
                ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Pending');
                $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{ trans('lang.driver_pending') }}</li>");

            } else {

                ref = refData.orderBy('createdAt', 'desc');
            }


        } else if (getId != '') {

            $('.vendorMenuTab').show();

            const getStoreName = getStoreNameFunction(getId);

            if ((order_status == 'All' || order_status != '') && search != '') {
                ref = refData.where('vendorID', '==', getId);
            } else {
                ref = refData.orderBy('createdAt', 'desc').where('vendorID', '==', getId);
            }
        } else {

            if ((order_status == 'All' || order_status != '') && search != '') {

                ref = refData;
            } else {
                ref = refData.orderBy('createdAt', 'desc');
            }
        }


        $(document).ready(function() {

            jQuery('#search').hide();

            $(document.body).on('click', '.redirecttopage', function() {
                var url = $(this).attr('data-url');
                window.location.href = url;
            });

            ref_sections.get().then(async function(snapshots) {

                snapshots.docs.forEach((listval) => {
                    var data = listval.data();

                    if (data.serviceTypeFlag != "cab-service" && data.serviceTypeFlag !=
                        "parcel_delivery" && data.serviceTypeFlag != "rental-service") {
                        $('#section_id').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.name));
                    }

                })

                $('#section_id').val(section_id);
            })

            $(document.body).on('change', '#selected_search', function() {

                if (jQuery(this).val() == 'status') {
                    jQuery('#order_status').show();
                    jQuery('#search').hide();
                } else {

                    jQuery('#order_status').hide();
                    jQuery('#search').show();

                }
            });

            var inx = parseInt(offest) * parseInt(pagesize);
            jQuery("#data-table_processing").show();

            append_list = document.getElementById('append_list1');
            append_list.innerHTML = '';

            // ref.where('status', 'in', ["Order Completed"]).get().then(async function(orderSnapshots) {
            //     var paymentData = orderSnapshots.docs;
            // })


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
                if (getId != '' || driverID || userID) {
                    $('#orderTable').DataTable({
                        order: [],
                        columnDefs: [{
                                targets: 4,
                                type: 'date',
                                render: function(data) {

                                    return data;
                                }
                            },
                            {
                                orderable: false,
                                targets: [0, 7, 8]
                            },
                        ],
                        order: [
                            ['4', 'desc']
                        ],
                        "language": {
                            "zeroRecords": "{{ trans('lang.no_record_found') }}",
                            "emptyTable": "{{ trans('lang.no_record_found') }}"
                        },
                        responsive: true
                    });

                } else {
                    $('#orderTable').DataTable({
                        order: [],
                        columnDefs: [{
                                targets: 6,
                                type: 'date',
                                render: function(data) {

                                    return data;
                                }
                            },
                            {
                                orderable: false,
                                targets: [0, 9, 10]
                            },
                        ],
                        order: [
                            ['6', 'desc']
                        ],
                        "language": {
                            "zeroRecords": "{{ trans('lang.no_record_found') }}",
                            "emptyTable": "{{ trans('lang.no_record_found') }}"
                        },
                        responsive: true
                    });

                }

            });
            //}
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
            var route1 = '{{ route('orders.edit', ':id') }}';
            route1 = route1.replace(':id', id);

            var printRoute = '{{ route('vendors.orderprint', ':id') }}';
            printRoute = printRoute.replace(':id', id);

            <?php if ($id != '') { ?>
            route1 = route1 + '?eid={{ $id }}';
            printRoute = printRoute + '?eid={{ $id }}';

            <?php } ?>
            var route_view = '{{ route('vendors.view', ':id') }}';
            route_view = route_view.replace(':id', vendorID);

            var customer_view = '{{ route('users.edit', ':id') }}';
            customer_view = customer_view.replace(':id', user_id);

            html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id +
                '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label></td>';


            html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>';

            if (userID) {

                var title = '';
                if (val.hasOwnProperty('vendor') && val.vendor.title != undefined) {
                    title = val.vendor.title;
                }

                html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + title + '</td>';
                if (val.section_id) {

                    const section = await getSectionName(val.section_id);
                    html = html + '<td class="sectionName_' + val.section_id + '">' + section + '</td>';

                } else {
                    html = html + '<td></td>';

                }

                if (val.hasOwnProperty("driver") && val.driver != null) {
                    var driverId = val.driver.id;
                    var diverRoute = '{{ route('drivers.edit', ':id') }}';
                    diverRoute = diverRoute.replace(':id', driverId);
                    html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName +
                        ' ' + val.driver.lastName + '</td>';

                } else {
                    html = html + '<td></td>';
                }

            } else if (driverID) {

                if (val.hasOwnProperty("author") && val.author != null) {
                    var driverId = val.author.id;

                    html = html + '<td  data-url="' + customer_view + '" class="redirecttopage">' + val.author
                        .firstName + ' ' + val.author.lastName + '</td>';

                } else {
                    html = html + '<td></td>';
                }
                var title = '';
                if (val.hasOwnProperty('vendor') && val.vendor.title != undefined) {
                    title = val.vendor.title;
                }
                html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + title + '</td>';
                if (val.section_id) {

                    const section = await getSectionName(val.section_id);
                    html = html + '<td class="sectionName_' + val.section_id + '">' + section + '</td>';

                } else {
                    html = html + '<td></td>';

                }

            } else if (getId != '') {

                if (val.hasOwnProperty("driver") && val.driver != null) {
                    var driverId = val.driver.id;
                    var diverRoute = '{{ route('drivers.edit', ':id') }}';
                    diverRoute = diverRoute.replace(':id', driverId);
                    html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName +
                        ' ' + val.driver.lastName + '</td>';

                } else {
                    html = html + '<td></td>';

                }


                if (val.hasOwnProperty("author") && val.author != null) {
                    var driverId = val.author.id;

                    html = html + '<td  data-url="' + customer_view + '" class="redirecttopage">' + val.author
                        .firstName + ' ' + val.author.lastName + '</td>';

                } else {
                    html = html + '<td></td>';
                }

            } else {
                var title = '';
                if (val.hasOwnProperty('vendor') && val.vendor.title != undefined) {
                    title = val.vendor.title;
                }

                html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + title + '</td>';
                if (val.section_id) {

                    const section = await getSectionName(val.section_id);
                    html = html + '<td class="sectionName_' + val.section_id + '">' + section + '</td>';

                } else {
                    html = html + '<td></td>';

                }

                if (val.hasOwnProperty("driver") && val.driver != null) {
                    var driverId = val.driver.id;
                    var diverRoute = '{{ route('drivers.edit', ':id') }}';
                    diverRoute = diverRoute.replace(':id', driverId);
                    html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName +
                        ' ' + val.driver.lastName + '</td>';

                } else {
                    html = html + '<td></td>';
                }


                if (val.hasOwnProperty("author") && val.author != null) {
                    var driverId = val.author.id;

                    html = html + '<td  data-url="' + customer_view + '" class="redirecttopage">' + val.author
                        .firstName + ' ' + val.author.lastName + '</td>';

                } else {
                    html = html + '<td></td>';
                }

            }


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
            var price = 0;


            var price = await buildHTMLProductstotal(val);

            html = html + '<td class="text-green">' + price + '</td>';
            if (val.hasOwnProperty('takeAway') && val.takeAway) {
                // if(val.takeAway){
                html = html + '<td>{{ trans('lang.order_takeaway') }}</td>';
            } else {
                html = html + '<td>{{ trans('lang.order_delivery') }}</td>';
            }


            if (val.status == 'Order Placed') {
                html = html + '<td class="order_placed"><span>' + val.status + '</span></td>';

            } else if (val.status == 'Order Accepted') {
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

            html = html + '<td class="action-btn"><a href="' + printRoute +
                '"><i class="fa fa-print" style="font-size:20px;"></i></a><a href="' + route1 +
                '"><i class="fa fa-edit"></i></a><a id="' + val.id +
                '" class="do_not_delete" name="order-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';


            html = html + '</tr>';

            return html;
        }


        // function buildHTML(snapshots) {
        //     var html = '';
        //     var alldata = [];
        //     var number = [];
        //     snapshots.docs.forEach((listval) => {
        //         var datas = listval.data();
        //         datas.id = listval.id;
        //         let result = user_number.filter(obj => {
        //             return obj.id == datas.author;
        //         })

        //         if (result.length > 0) {
        //             datas.phoneNumber = result[0].phoneNumber;
        //             datas.isActive = result[0].isActive;

        //         } else {
        //             datas.phoneNumber = '';
        //             datas.isActive = false;
        //         }
        //         alldata.push(datas);
        //     });

        //     var count = 0;
        //     alldata.forEach((listval) => {


        //         var val = listval;

        //         html = html + '<tr>';
        //         newdate = '';
        //         var id = val.id;
        //         var vendorID = val.vendorID;
        //         var user_id = val.author.id;
        //         var route1 = '{{ route('orders.edit', ':id') }}';
        //         route1 = route1.replace(':id', id);

        //         var printRoute = '{{ route('vendors.orderprint', ':id') }}';
        //         printRoute = printRoute.replace(':id', id);

        //         <?php if ($id != '') { ?>
        //             route1 = route1 + '?eid={{ $id }}';
        //             printRoute = printRoute + '?eid={{ $id }}';

        //         <?php } ?>
        //         var route_view = '{{ route('vendors.view', ':id') }}';
        //         route_view = route_view.replace(':id', vendorID);

        //         var customer_view = '{{ route('users.edit', ':id') }}';
        //         customer_view = customer_view.replace(':id', user_id);

        //         html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
        //             'for="is_open_' + id + '" ></label></td>';


        //         html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>';

        //         <?php if ($id != '') { ?>
        //             if (window.location.href.indexOf("userId") > -1) {

        //                 html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + val.vendor.title + '</td>';

        //                 if (val.hasOwnProperty("driver")) {
        //                     var driverId = val.driver.id;
        //                     var diverRoute = '{{ route('drivers.edit', ':id') }}';
        //                     diverRoute = diverRoute.replace(':id', driverId);
        //                     html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName + ' ' + val.driver.lastName + '</td>';

        //                 } else {
        //                     html = html + '<td></td>';
        //                 }

        //             } else if (window.location.href.indexOf("driverId") > -1) {
        //                 html = html + '<td data-url="' + customer_view + '" class="redirecttopage">' + val.author.firstName + ' ' + val.author.lastName + '</td>';

        //                 html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + val.vendor.title + '</td>';

        //             } else {


        //                 html = html + '<td data-url="' + customer_view + '" class="redirecttopage">' + val.author.firstName + ' ' + val.author.lastName + '</td>';
        //                 if (val.hasOwnProperty("driver")) {
        //                     var driverId = val.driver.id;
        //                     var diverRoute = '{{ route('drivers.edit', ':id') }}';
        //                     diverRoute = diverRoute.replace(':id', driverId);
        //                     html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName + ' ' + val.driver.lastName + '</td>';

        //                 } else {
        //                     html = html + '<td></td>';
        //                 }

        //             }
        //         <?php } else { ?>

        //             html = html + '<td data-url="' + customer_view + '" class="redirecttopage">' + val.author.firstName + ' ' + val.author.lastName + '</td>';

        //             html = html + '<td  data-url="' + route_view + '" class="redirecttopage">' + val.vendor.title + '</td>';
        //             console.log(val.vendor.title);

        //             if (val.hasOwnProperty("driver")) {
        //                 var driverId = val.driver.id;
        //                 var diverRoute = '{{ route('drivers.edit', ':id') }}';
        //                 diverRoute = diverRoute.replace(':id', driverId);
        //                 html = html + '<td  data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName + ' ' + val.driver.lastName + '</td>';

        //             } else {
        //                 html = html + '<td></td>';
        //             }
        //         <?php } ?>



        //         var date = '';
        //         var time = '';
        //         if (val.hasOwnProperty("createdAt")) {

        //             try {
        //                 date = val.createdAt.toDate().toDateString();
        //                 time = val.createdAt.toDate().toLocaleTimeString('en-US');
        //             } catch (err) {

        //             }
        //             html = html + '<td>' + date + '</td>';
        //         } else {
        //             html = html + '<td></td>';
        //         }
        //         var price = 0;

        //         var price = buildHTMLProductstotal(val);
        //         html = html + '<td>' + price + '</td>';
        //         if (val.hasOwnProperty('takeAway') && val.takeAway) {
        //             html = html + '<td>{{ trans('lang.order_takeaway') }}</td>';
        //         } else {
        //             html = html + '<td>{{ trans('lang.order_delivery') }}</td>';
        //         }

        //         if (val.status == 'Order Placed') {
        //             html = html + '<td class="order_placed"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Order Accepted') {
        //             html = html + '<td class="order_accepted"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Order Rejected') {
        //             html = html + '<td class="order_rejected"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Driver Pending') {
        //             html = html + '<td class="driver_pending"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Driver Rejected') {
        //             html = html + '<td class="driver_rejected"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Order Shipped') {
        //             html = html + '<td class="order_shipped"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'In Transit') {
        //             html = html + '<td class="in_transit"><span>' + val.status + '</span></td>';

        //         } else if (val.status == 'Order Completed') {
        //             html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

        //         }

        //         html = html + '<td class="action-btn"><a href="' + printRoute + '"><i class="fa fa-print" style="font-size:20px;"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a><a id="' + val.id + '" class="do_not_delete" name="order-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';


        //         html = html + '</tr>';
        //         count = count + 1;
        //     });

        //     return html;
        // }

        $("#is_active").click(function() {
            $("#orderTable .is_open").prop('checked', $(this).prop('checked'));

        });

        $("#deleteAll").click(function() {
            if ($('#orderTable .is_open:checked').length) {
                if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                    jQuery("#data-table_processing").show();
                    $('#orderTable .is_open:checked').each(function() {
                        var dataId = $(this).attr('dataId');
                        database.collection('vendor_orders').doc(dataId).delete().then(function() {
                            setTimeout(function() {
                                window.location.reload();
                            }, 5000);
                        });

                    });

                }
            } else {
                alert("{{ trans('lang.select_delete_alert') }}");
            }
        });
        async function getSectionName(sectionId) {
            var sectionName = '';
            await database.collection('sections').where("id", "==", sectionId).get().then(async function(snapshots) {

                if (snapshots.docs.length > 0) {
                    var data = snapshots.docs[0].data();
                    sectionName = data.name;
                    //$('.sectionName_' + sectionId).html(data.name);

                }
            });
            return sectionName;
        }

        async function getStoreNameFunction(vendorId) {
            var vendorName = '';
            await database.collection('vendors').where('id', '==', vendorId).get().then(async function(snapshots) {
                var vendorData = snapshots.docs[0].data();

                vendorName = vendorData.title;
                $('.orderTitle').html("{{ trans('lang.order_plural') }} - " + vendorName);

                if (vendorData.dine_in_active == true) {
                    $(".dine_in_future").show();
                }

            });

            return vendorName;

        }


        async function getUserNameFunction(userId) {
            var userName = '';
            await database.collection('users').where('id', '==', userId).get().then(async function(snapshots) {

                var userData = snapshots.docs[0].data();

                userName = userData.firstName + " " + userData.lastName;
                $('.orderTitle').html('{{ trans('lang.order_plural') }} - ' + userName);

            });

            return userName;

        }

        function prev() {
            if (endarray.length == 1) {
                return false;
            }
            end = endarray[endarray.length - 2];

            if (end != undefined || end != null) {

                jQuery("#data-table_processing").show();
                if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val().trim() != '') {

                    if (order_status == 'All') {
                        listener = ref.startAt(end).limit(pagesize).get();
                    } else {
                        listener = ref.orderBy('status').limit(pagesize).startAt(order_status).endAt(order_status +
                            '\uf8ff').startAt(end).get();
                    }

                } else if (jQuery("#selected_search").val() == 'vendor' && jQuery("#search").val().trim() != '') {

                    listener = ref.orderBy('vendor.title').limit(pagesize).startAt(search).endAt(search + '\uf8ff').startAt(
                        end).get();
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

                if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val().trim() != '') {

                    if (order_status == 'All') {

                        listener = ref.startAfter(start).limit(pagesize).get();

                    } else {

                        listener = ref.orderBy('status').limit(pagesize).startAt(order_status).endAt(order_status +
                            '\uf8ff').startAfter(start).get();
                    }

                } else if (jQuery("#selected_search").val() == 'vendor' && jQuery("#search").val().trim() != '') {

                    listener = ref.orderBy('vendor.title').limit(pagesize).startAt(search).endAt(search + '\uf8ff').startAt(
                        start).get();
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
            jQuery("#data-table_processing").show();
            database.collection('vendor_orders').doc(id).delete().then(function(result) {

                window.location.href = '{{ url()->current() }}';
            });

        });

        function clickpage(value) {
            setCookie('pagesizes', value, 30);
            location.reload();
        }

        function searchclear() {
            jQuery("#search").val('');
            $('#order_status').val("All").trigger('change');
            searchtext();
        }

        function searchtext() {

            var offest = 1;
            jQuery("#data-table_processing").show();
            append_list.innerHTML = '';

            if (jQuery("#selected_search").val() == 'status' && jQuery("#order_status").val().trim() != '') {

                if (order_status == 'All') {

                    wherequery = ref.limit(pagesize).get();

                } else {

                    wherequery = ref.orderBy('status').limit(pagesize).startAt(order_status).endAt(order_status + '\uf8ff')
                        .get();
                }

            } else if (jQuery("#selected_search").val() == 'vendor' && jQuery("#search").val().trim() != '') {

                wherequery = ref.orderBy('vendor.title').limit(pagesize).startAt(search).endAt(search + '\uf8ff').get();
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

        function buildHTMLProductstotal(snapshotsProducts) {

            var adminCommission = snapshotsProducts.adminCommission;
            var discount = snapshotsProducts.discount;
            var couponCode = snapshotsProducts.couponCode;
            var extras = snapshotsProducts.extras;
            var extras_price = snapshotsProducts.extras_price;
            var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
            var takeAway = snapshotsProducts.takeAway;
            var tip_amount = snapshotsProducts.tip_amount;
            var status = snapshotsProducts.status;
            var products = snapshotsProducts.products;
            var deliveryCharge = snapshotsProducts.deliveryCharge;
            var totalProductPrice = 0;
            var total_price = 0;

            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

            if (products) {

                products.forEach((product) => {

                    var val = product;

                    price_item = parseFloat(val.price).toFixed(decimal_degits);

                    extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity)).toFixed(
                        decimal_degits);

                    totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                    var extras_price = 0;
                    if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                        extras_price = extras_price_item;
                    }
                    totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                    totalProductPrice = parseFloat(totalProductPrice).toFixed(decimal_degits);

                    total_price += parseFloat(totalProductPrice);

                });
            }

            if (intRegex.test(discount) || floatRegex.test(discount)) {

                discount = parseFloat(discount).toFixed(decimal_degits);
                total_price -= parseFloat(discount);

                if (currencyAtRight) {
                    discount_val = discount + "" + currentCurrency;
                } else {
                    discount_val = currentCurrency + "" + discount;
                }

            }

            var tax = 0;
            taxlabel = '';
            taxlabeltype = '';

            if (snapshotsProducts.hasOwnProperty('taxSetting')) {
                var total_tax_amount = 0;
                for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                    var data = snapshotsProducts.taxSetting[i];

                    if (data.type && data.tax) {
                        if (data.type == "percentage") {
                            tax = (data.tax * total_price) / 100;
                            taxlabeltype = "%";
                        } else {
                            tax = data.tax;
                            taxlabeltype = "fix";
                        }
                        taxlabel = data.title;
                    }
                    total_tax_amount += parseFloat(tax);
                }
                total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
            }

            if ((intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) && !isNaN(deliveryCharge)) {

                deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
                total_price += parseFloat(deliveryCharge);

                if (currencyAtRight) {
                    deliveryCharge_val = deliveryCharge + "" + currentCurrency;
                } else {
                    deliveryCharge_val = currentCurrency + "" + deliveryCharge;
                }
            }


            if (intRegex.test(tip_amount) || floatRegex.test(tip_amount) && !isNaN(tip_amount)) {

                tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
                total_price += parseFloat(tip_amount);
                total_price = parseFloat(total_price).toFixed(decimal_degits);

                if (currencyAtRight) {
                    tip_amount_val = tip_amount + "" + currentCurrency;
                } else {
                    tip_amount_val = currentCurrency + "" + tip_amount;
                }
            }


            if (currencyAtRight) {
                var total_price_val = parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                var total_price_val = currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits);
            }

            return total_price_val;
        }

        function clickLink(value) {
            setCookie('section_id', value, 30);
            location.reload();
        }
    </script>
@endsection
