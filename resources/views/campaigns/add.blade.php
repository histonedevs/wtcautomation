@extends('layout.master')

@section('content')
    {!! $data_table->table(['class' => 'table table-striped table-hover', 'id' => 'table_products']) !!}

    <!-- SEND SMS Modal -->
    <div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-labelledby="createCampaignModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="createCampaignModalLabel">Create a Campaign</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Enter Campaign Name</label>
                        <input type="text" class="form-control" id="campName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary createCampaign">Create</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    {!! makeScripts($data_table) !!}

    <script>
        $(document).on("click" , '.createCampBtn', function (e) {
            e.preventDefault();

            window.selected_product = $(this).attr("product_id");
            $("#createCampaignModal").modal();
        });

        $(document).ready(function () {
            $("#createCampaignModal .createCampaign").click(function () {
                var campName = $("#campName").val().trim();
                if (campName) {
                    $.post("{{ url("campaigns/add") }}", {
                        product_id: window.selected_product,
                        campName: campName
                    }, function (r) {
                        if (r == "ok") {
                            window.LaravelDataTables.table_products.ajax.reload();
                            $("#createCampaignModal").modal("hide");
                        } else {
                            alert(r);
                        }
                    });
                } else {
                    alert("Please enter a campaign name");
                }
            });
        });
    </script>
@endsection