<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}}</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{asset('js/app.js') }}"></script>

  <script src="{{asset('js/jquery.validate.js') }}"></script>

    <link rel="stylesheet" href="{{asset('css/app.css') }}">

    <link rel="stylesheet" href="{{asset('css/style.css') }}">
    <link rel="stylesheet" href="{{asset('css/alertify.css') }}">
    <link rel="stylesheet" href="{{asset('css/default.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css') }}">

    <link rel="stylesheet" href="{{asset('css-loader-master/dist/css-loader.css') }}">

    @stack('styles')
</head>
 
<body>

@yield('contenido')

<script src="{{asset('js/alertify.js') }}"></script>
<script src="{{asset('fontawesome/js/fontawesome.min.js') }}"></script>
<script src="{{asset('fontawesome/js/all.min.js') }}"></script>


<script>
alertify.defaults = {
    // dialogs defaults
    autoReset:true,
    basic:false,
    closable:true,
    closableByDimmer:true,
    frameless:false,
    maintainFocus:true, // <== global default not per instance, applies to all dialogs
    maximizable:true,
    modal:true,
    movable:true,
    moveBounded:false,
    overflow:true,
    padding: true,
    pinnable:true,
    pinned:true,
    preventBodyShift:false, // <== global default not per instance, applies to all dialogs
    resizable:true,
    startMaximized:false,
    transition:'pulse',

    // notifier defaults
    notifier:{
        // auto-dismiss wait time (in seconds)  
        delay:5,
        // default position
        position:'bottom-right',
        // adds a close button to notifier messages
        closeButton: false
    },

    // language resources 
    glossary:{
        // dialogs default title
        title:'Aviso!',
        // ok button text
        ok: 'OK',
        // cancel button text
        cancel: 'Cancel'            
    },

    // theme settings
    theme:{
        // class name attached to prompt dialog input textbox.
        input:'ajs-input',
        // class name attached to ok button
        ok:'ajs-ok',
        // class name attached to cancel button 
        cancel:'ajs-cancel'
    }
};
</script>

@stack('scripts')
</body>
</html>
