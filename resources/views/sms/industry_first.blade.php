@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Inustry First Messages</h3>
            {!! form($form) !!}
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        var sms_values = {
            sms1 : 'Please click http://www.industryfirst.tv and view the Segments tab. The 2 Interview Styles are Video and Audio under Dentist.',
            sms2 : 'Industry First TV: This is to confirm your 15 Minute Overview Call with Tim tomorrow',
            sms3 : 'Industry First TV: This is to confirm your 1 hour Dress Rehearsal Call with Tim tomorrow.',
            sms4 : 'Hi it\'s Tim. Ill be calling shortly. If you cant make this call, please return text me back asap. Then click http://www.bitly.com/new-appt to select a time.',
            smsFree : '',
            '' : ''
        };

        $(document).ready(function () {
            $("#sms_type").change(function () {
                $("#sms_text").val(sms_values[this.value]);
            });
        });
    </script>
@endsection