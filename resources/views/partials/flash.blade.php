
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-bs-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif


@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-bs-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-bs-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


{{--@if ($errors->any())--}}
{{--<div class="alert alert-danger">--}}
{{--<button type="button" class="close" data-bs-dismiss="alert">×</button>--}}
{{--Veuillez vérifier si le formulaire ci-dessous contient des erreurs--}}
{{--</div>--}}
{{--@endif--}}

@if(Session::has('flashy_notification.message'))
<script id="flashy-template" type="text/template">
    <div class="flashy flashy--{{ Session::get('flashy_notification.type') }}">
            <i class="material-icons">speaker_notes</i>
            <a href="#" class="flashy__body" target="_blank"></a>
        </div>
    </script>

<script>
    flash("{{ Session::get('flashy_notification.message') }}", "{{ Session::get('flashy_notification.link') }}");
</script>
@endif

















{{--@if (session()->has('errors'))--}}
{{--<div class="alert alert-danger text-center animated fadeIn">--}}
{{--<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">--}}
{{--<span aria-hidden="true">&times;</span>--}}
{{--</button>--}}
{{--<strong>--}}
{{--{{ session()->get('errors') }}--}}
{{--</strong>--}}
{{--</div>--}}
{{--@endif--}}


{{--@if (session()->has('success'))--}}
{{--<div class="alert alert-success text-center animated fadeIn">--}}
{{--<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">--}}
{{--<span aria-hidden="true">&times;</span>--}}
{{--</button>--}}
{{--<strong>--}}
{{--{{ session()->get('success') }}--}}
{{--</strong>--}}
{{--</div>--}}
{{--@endif--}}