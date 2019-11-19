{{-- <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script> --}}
<script type="text/javascript">
    var BASE_URL = 'http://Tikz.edu.vn/';

    var PRICE_MAGAZINE = '25000 - 30000';
    var PRICE_READ_ONLINE = '25000';
    var discount = [{
        "range_time": "12",
        "year": "2019",
        "discount": "50000"
    }];
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js"></script> --}}
<script src="{{ asset('tikz/js/jquery.js') }}"></script>
<script src="{{ asset('tikz/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('tikz/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('tikz/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('tikz/js/slide/jquery.bxslider.js') }}"></script>
<script src="{{ asset('tikz/js/scriptNav.js') }}"></script>
<script src="{{ asset('tikz/js/custom.js') }}"></script>

<script language="JavaScript">
    $(document).ready(function() {
        $('.bxslider').bxSlider({
            auto: true,
            autoControls: true
        });
    });
    $(".hw-date").datepicker({
        format: 'mm-yyyy',
        changeMonth: true,
        changeYear: true,
        yearRange: '2017:2019',
        startView: "months",
        minViewMode: "months",
        language: 'vi'
    }).keydown(false);
</script>
