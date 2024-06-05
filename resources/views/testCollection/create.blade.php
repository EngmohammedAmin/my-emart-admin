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
                    <li class="breadcrumb-item active">Test Collection Create</li>
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
                                <input type="text" class="form-control test-name">
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
                            <input type="checkbox" data-id="" name="isActive" id="isActive">
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
        var database = firebase.firestore();
        var Ref = database.collection('testCollection');
        var ischeck;
        var id_test = "<?php echo uniqid(); ?>";
        var id;
        $(document).ready(function() {
            jQuery("#data-table_processing").show();
            $("#isActive").attr('data-id', id_test);

            $(document).on("click", "input[name='isActive']", function(e) {


                ischeck = $(this).is(':checked');
                {{--  id_test = $(this).attr('data-id');  --}}

            });

            if (ischeck) {
                ischeck = true;
            } else {
                ischeck = false;
            }
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
                    {{--  console.log(id_test);
                    return false;  --}}
                    try {

                        database.collection('testCollection').doc(id_test).set({
                            'id': id_test,
                            'name': name,
                            'age': Age,
                            'address': address,
                            'isActive': ischeck,
                        }).then(function(result) {
                            window.location.href = '{{ route('TestColl.index') }}';

                        });



                    } catch (error) {
                        console.error("Error adding document: ", error);

                    }

                }
            });

        });
    </script>
@endsection
