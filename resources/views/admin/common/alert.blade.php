<style>
/* Toast messages */
    .toast-message {
        position: fixed;
        top: 20px;
        right: -25rem;
        padding: 15px 10px 15px 10px;
        color: white;
        border-radius: 5px;
        z-index: 1000;
        transition: right 0.5s ease;
        width: 25rem;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 16px;
    }

    /* Success message */
    .toast-success {
        background-color: green;
    }

    /* Error message */
    .toast-error {
        background-color: #f44336;
    }

</style>

@if(Session::has('success') || Session::has('error'))
    @if(Session::has('success'))
        <div id="successSms" class="toast-message toast-success">
            <span><b>Success:</b> {!! Session::get('success') !!}</span>
        </div>
    @endif

    @if(Session::has('error'))
        <div id="errorSms" class="toast-message toast-error">
            <span><b>Error:</b> {!! Session::get('error') !!}</span>
        </div>
    @endif
@endif

<script>
    $(document).ready(function() {
        // Slide in messages
        $('#successSms').css('right', '20px');
        $('#errorSms').css('right', '20px');

        setTimeout(function() {
            $('#successSms').css('right', '-25rem');
        }, 5000);

        setTimeout(function() {
            $('#errorSms').css('right', '-25rem');
        }, 5000);
    });
</script>
