<style>
.flash {
    font-family: Arial, sans-serif;
    padding: 11px 30px;
    border-radius: 4px;
    font-weight: 400;
    position: fixed;
    top: 100px;
    left: 280px;
    font-size: 16px;
    color: #fff;
}

.flash--success {
    background-color: #06c902;
    color: #fff;
}

.flash--warning {
    color: #8a000f;
    background-color: #fcf8e3;
    border-color: #faebcc;
}

.flash--muted {
    background: #eee;
    color: #3a3a3a;
    border: 1px solid #e2e2e2;
}

.flash--muted-dark {
    background: #133259;
    color: #e2e1e7;
}

.flash--info a,
.flash--primary-dark a {
    color: #fff;
}

.flash--error {
    background: #d14130;
    color: #fff;
}

.flash--primary {
    background: #144f81;
}

.flash--primary-dark {
    background: linear-gradient(to right, #133259 30%, #0d233e);
}

.flash--info {
    background: #00baf3;
}

.flash > ul {
    padding-left: 15px;
}

.flash > p:only-of-type {
    margin-bottom: 0;
}

.flash i {
    margin-right: 8px;
    position: relative;
    top: 6px;
}

.flash .flash__body {
    color: inherit;
}

@media only screen and (max-width:1050px) {
    .flash {
        text-align: center;
        right: 0;
        left: 50%;
        width: 300px;
        margin-left: -150px;
    }
}
</style>

<script>
    function flash(message, link) {
        var template = $($("#flash-template").html());
        $(".flash").remove();
        template.find(".flash__body").html(message).attr("href", link || "#").end()
        .appendTo("body").hide().fadeIn(2000).delay(10000).animate({
            marginLeft: "-100%"
        }, 1000, "swing", function() {
            $(this).remove();
        });
    }
</script>

@if(Session::has('flash_notification.message'))
<script id="flash-template" type="text/template">
    <div class="flash flash--{{ Session::get('flash_notification.type') }}">
        <link href="{{ asset('fonts/material-icons.css') }}" rel='stylesheet' type='text/css'>
        <a href="#" class="flash__body" target="_blank"></a>
    </div>
</script>

<script>
    flash("{{ Session::get('flash_notification.message') }}", "{{ Session::get('flash_notification.link') }}");
</script>
@endif
