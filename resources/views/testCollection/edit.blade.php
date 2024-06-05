@extends('layouts.app')

@section('content')
    <style>
        /* تخصيص مظهر عنصر الـ checkbox */
        .custom-checkbox {
            display: inline-block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 32px;
            cursor: pointer;
            font-size: 18px;
        }

        .custom-checkbox input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 40px;
            width: 40px;
            background-color: #776f6f;
        }

        .custom-checkbox:hover input~.checkmark {
            background-color: #f58787;
        }

        .custom-checkbox input:checked~.checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 14px;
            top: 3px;
            width: 13px;
            height: 22px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    </style>
    <div class="page-wrapper">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Test Collection</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('TestColl.index') !!}">Test Collection</a>
                    </li>
                    <li class="breadcrumb-item active">Test Collection Edit</li>
                </ol>
            </div>
        </div>


        <div class="card-body">

            <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
                {{ trans('lang.processing') }}
            </div>
            <div class="error_top" style="display:none"></div>
            <div class="row vendor_payout_create">

                <div class="vendor_payout_create-inner">
                    <fieldset>
                        <legend> NAME</legend>
                        <div class="form-group row width-100">
                            <div class="col-7">
                                <input id="test-name" type="text" class="form-control test-name">
                                <div class="form-text text-muted"> TestColl Name</div>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset id="" class="diliverychargeDiv">
                        <legend>Age</legend>
                        <div class="form-group row width-50">
                            <div class="col-7">
                                <input type="number" id="Age" class="form-control Age " value="">
                                <div class="form-text text-muted"> TestColl Age</div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset id="" class="diliverychargeDiv">
                        <legend> Address </legend>
                        <div class="form-group row width-50">
                            <div class="col-7">
                                <input type="text" id="address" class="form-control ">
                                <div class="form-text text-muted"> TestColl Address</div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="" class="diliverychargeDiv">
                        <legend>Is Active</legend>
                        <label class="custom-checkbox">
                            <input type="checkbox" data-id="{{ $id }}" name="isActive" id="isActive">
                            <span class="checkmark"></span>
                        </label>
                        <div class="form-text text-muted"> TestColl Is Active</div>

                    </fieldset>

                </div>

            </div>

        </div>
        <div class="form-group col-12 text-center btm-btn">
            <button type="button" class="btn btn-primary save_test_btn"><i class="fa fa-save"></i>
                {{ trans('lang.save') }}
            </button>
            <a href="{!! route('TestColl.index') !!}" class="btn btn-default"><i
                    class="fa fa-undo"></i>{{ trans('lang.cancel') }}</a>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var id = "<?php echo $id; ?>";
        var ischeck;
        var database = firebase.firestore();
        var ref = database.collection('testCollection').where("id", "==", id);

        $(document).ready(function() {
            jQuery("#data-table_processing").show();

            ref.get().then(async function(snapshots) {
                if (snapshots.docs) {
                    var testColl = snapshots.docs[0].data();
                    $(".test-name").val(testColl.name);
                    $(".Age").val(testColl.age);
                    $("#address").val(testColl.address);
                    if (testColl.isActive == true) {
                        $("#isActive").prop('checked', true);

                    } else {
                        $("#isActive").prop('checked', false);


                    }

                }
            })


            $(document).on("click", "input[name='isActive']", function(e) {


                ischeck = $(this).is(':checked');



            });

            jQuery("#data-table_processing").hide();

            $(".save_test_btn").click(function() {

                var name = $(".test-name").val();
                var Age = $("#Age").val();
                var address = $("#address").val();


                if (name == '') {

                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p> يجب إدخال الاسم !!</p>");
                    window.scrollTo(0, 0);
                } else if (Age == "") {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p> يجب إدخال العمر</p>");
                    window.scrollTo(0, 0);
                } else if (address == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>يجب تحديد العنوان</p>");
                    window.scrollTo(0, 0);
                } else {

                    if (ischeck) {
                        database.collection('testCollection').doc(id).update({
                            'isActive': true
                        }).then(function(result) {});
                    } else {
                        database.collection('testCollection').doc(id).update({
                            'isActive': false
                        }).then(function(result) {});
                    }

                    database.collection('testCollection').doc(id).update({
                        'name': name,
                        'age': Age,
                        'address': address,

                    }).then(function(result) {
                        window.location.href = '{{ route('TestColl.index') }}';
                    });
                }
            });



            $(document).on("input", "#test-name", function(e) {

                var Real_name = $("#test-name").val();
                database.collection('testCollection').doc(id).update({
                    'name': Real_name,

                });

            });

            $(document).on("input", "#Age", function(e) {

                var Real_Age = $("#Age").val();
                database.collection('testCollection').doc(id).update({
                    'age': Real_Age,

                });

            });

            $(document).on("input", "#address", function(e) {

                var Real_address = $("#address").val();
                database.collection('testCollection').doc(id).update({
                    'address': Real_address,

                });

            });

        });
    </script>
@endsection
