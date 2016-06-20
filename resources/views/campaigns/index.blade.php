@extends('layout.master')

@section('content')
    {!! $data_table->table(['class' => 'table table-striped table-hover', 'id' => 'table_campaigns']) !!}

    <!-- SEND SMS Modal -->
    <div class="modal fade" id="sendSMSModal" tabindex="-1" role="dialog" aria-labelledby="sendSMSModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sendSMSModalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Enter Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Enter Coupon Code</label>
                        <input type="text" class="form-control" id="couponCode">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left resetSMS">Reset</button>
                    <button type="button" class="btn btn-primary pull-left testSMS">Test</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success sendSMS">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SEND SMS Modal -->
    <div class="modal fade" id="downloadCSVModal" tabindex="-1" role="dialog" aria-labelledby="downloadCSVModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="downloadCSVModalLabel">Download CSV</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">From</label>
                                <input type="text" class="form-control" id="dateFrom">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class="control-label">To</label>
                                <input type="text" class="form-control" id="dateTo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary downloadBtn">Download</button>
                </div>
            </div>
        </div>
    </div>

    {{--edit campaign modal--}}
    <div class="modal fade" id="updateCampaignModal" tabindex="-1" role="dialog" aria-labelledby="createCampaignModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="createCampaignModalLabel">Edit Campaign</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" accept-charset="UTF-8" id="updateCampaignForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label">Enter Campaign Name</label>
                            <input type="text" class="form-control" name="camp_name" id="camp_name">
                        </div>
                        <input value="2" class="form-control" id="capaign_id" name="campaign_id" type="hidden">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updateCampaign">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    {!! makeScripts($data_table) !!}
    <script type="text/javascript">
        function resetSMSModal(){
            $("#sendSMSModal .testSMS").show();
            $("#sendSMSModal .sendSMS").hide();
            $("#phoneNumber").val("").prop("disabled", false);
        }

        $(document).on("click", ".resetSMS", resetSMSModal);

        $(document).on("click", ".sendSmsBtn", function (e) {
            e.preventDefault();

            window.selected_campaign = $(this).attr("campaign_id");
            $("#phoneNumber").val("");

            resetSMSModal();
            $("#sendSMSModal").modal();
        });

        $(document).on("click" , ".downloadOrdersBtn", function (e) {
            e.preventDefault();

            window.selected_campaign = $(this).attr("campaign_id");
            window.discounted = $(this).attr("discount");
            console.log("discounted = "+ window.discounted);
            $("#downloadCSVModal").modal();
        })

        $(document).on("click" , ".btn_edit_campaign", function (e) {
            e.preventDefault();
            var row = $(this).closest('tr');

            var rowData = getRowData("table_campaigns", row)
            console.log(rowData);
           $("#updateCampaignModal #camp_name").val(rowData.campaign_name);
            $("#updateCampaignForm #capaign_id").val( $(this).attr("campaign_id"));
            console.log("btn_edit_campaign clicked");
            $("#updateCampaignModal").modal();
        })
        
        $(document).ready(function () {
            $("#sendSMSModal .sendSMS").click(function () {
                var phoneNumber  = $("#phoneNumber").val().trim();
                var couponCode = $('#couponCode').val().trim();
                if(phoneNumber){
                    if(couponCode) {
                        $.post("{{ url("sms") }}", {campaign_id : window.selected_campaign, phoneNumber: phoneNumber, couponCode: couponCode}, function (r) {
                            if(r == "ok"){
                                $("#sendSMSModal").modal("hide");
                            }else{
                                alert(r);
                            }
                        });
                    } else {
                        alert("Please enter a coupon code");
                    }
                }else{
                    alert("Please enter a phone number");
                }
            });

            $("#sendSMSModal .testSMS").click(function () {
                var phoneNumber  = $("#phoneNumber").val().trim();
                var couponCode = $('#couponCode').val().trim();
                if(phoneNumber){
                    if(couponCode) {
                        $.get("{{ url("sms/carrier") }}", {phoneNumber: phoneNumber, couponCode: couponCode}, function (r) {
                            if(r == "ok"){
                                $("#sendSMSModal .testSMS").hide();
                                $("#sendSMSModal .sendSMS").show();
                                $("#phoneNumber").prop("disabled", true);
                            }else{
                                alert(r);
                            }
                        });
                    } else {
                        alert("Please enter a coupon code");
                    }

                }else{
                    alert("Please enter a phone number");
                }
            });


            $("#downloadCSVModal .downloadBtn").click(function () {
                var errors = [];
                var dateFrom = $("#dateFrom").val().trim();
                if(dateFrom.length == 0){
                    errors.push("From Date Field is required");
                }

                var dateTo = $("#dateTo").val().trim();
                if(dateTo.length == 0){
                    errors.push("To Date Field is required");
                }

                if(errors.length == 0){
                    $("#downloadCSVModal").modal("hide");
                    window.location = "{{ url("download") }}?" +
                        $.param({
                            campaign_id : window.selected_campaign,
                            dateFrom : dateFrom,
                            dateTo: dateTo,
                            discounted: window.discounted,
                        });
                }else{
                    alert("Correct Following Errors : \n\n" + errors.join("\n"));
                }
            });

            $('#dateFrom').datetimepicker();
            $('#dateTo').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });
            $("#dateFrom").on("dp.change", function (e) {
                $('#dateTo').data("DateTimePicker").minDate(e.date);
            });
            $("#dateTo").on("dp.change", function (e) {
                $('#dateFrom').data("DateTimePicker").maxDate(e.date);
            });

            $("#updateCampaignModal .updateCampaign").click(function () {
                var campName = $("#updateCampaignModal #camp_name").val().trim();
                $.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : '{{ url("campaigns/edit") }}', // the url where we want to POST
                    data        : $("#updateCampaignModal #updateCampaignForm").serialize(), // our data object
                    success:function(r){
                        window.LaravelDataTables.table_campaigns.ajax.reload();
                        $("#updateCampaignModal").modal("hide");
                    }

                });
            });
        });
    </script>
@endsection

