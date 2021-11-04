<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAA8UlEQVRYhe3XMQrCMBTG8X+s6FCwioNXEDyHCN7FU4g3cHb0EKKbd9ADKOgqFhEpcbBjsPmkpQh5U+A9Xn+kLyk1CHGM4jnQB1JH2gA9YDfM0rVvz6YCAGZAUlATA96Ahgh4etS4dqc0gE+YugFSBEDtAPEYSvNVPuCZ3esFJONJcZG1sN386inqba+2OFZKz9qHMAACIABUQOl3sXQT3l5Zli9fjnQENIwxtjLAaLok7+56iOUjUFpqgNPhEuXL1pcySaB9jgcdv+09VwWw0uv1ir87hgHwFwBpUlVA26MmVhqqf8cLoAs8HDmT5/ZKwzermEvjf0jd1wAAAABJRU5ErkJggg==">
    <link rel="icon" type="image/png" sizes="96x96" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAACXElEQVR4nO3cMW4TQRiG4W/GhCiECmhQkOgQVyEXQByAhsMgJA5ALsAZKKnpUiKELBANSCACZvenWLuJkGw5nnl/5O9pnGr+yb7R2pHGKxmq0BuQpPPZ8Zmku5JGSb+1+32FpMPl68eHw4+nO15/a9foDSydSjrSdIFGtQkwW75+2/HaV5IlwC1NF6iH2mnORrJs5lPHWZ87zlorS4Ce+8jyO0tKtpl95AAwB4A5AMwBYA4AcwCYA8AcAOYAMAeAOQDMAWAOAHMAmAPAHADmADAHgDkAzAFgDgBzAFiKk3ElxxFVRIoAP4fv9BYwKQLMTk76DYsoms/7zVsjRYAHz1+UKB1uQxHSOFY9edx+1oZSBLh++ii6DYvoN2sDKQLo5nHPaWPPYev4YyjMAWAOAHMAmAPAHADmADAHgDkAzAFgDgBzAJgDwBwA5gAwB4A5AMwBYA4AcwCYA8AcAOYAMAeAOQAsS4C9PZ+e42ji9Ejhf/28S6vIPht62fn86yJCoeniLBqNOZBUailDo/W3kiLAs5dvFhGKkP5I+qUGt6SIKLWUejCrDnDZ29fvjiTVmP5KZ2ry9PSoZfoy1OGO176SFAEuFkNdXvKi1k9Rj0j1hp8igO7c6PnGGHrfcdoaOQIMqT6YdJXl/4C95QAwB4A5AMwBYA4AcwCYA8AcAOYAMAeAOQDMAWAOAHMAmAPAHADmADAHgDkAzAFgDgBzAFiWAD3Pa6Y6G5olwL2Os+53nLVWjpNx0gdNe1kdUW+hLte+aLT+VrIEeCXptqbnOre6RawCf2m0vv2P/gJ/dVjuktlqiQAAAABJRU5ErkJggg==">
    <link rel="icon" type="image/png" sizes="16x16" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAt0lEQVQ4jcWTPQrCUBCEv5ik0U4rEcQy1h7GXi9g7QW0EmwVPYCdd7CwshPsxEP4AxLXQtPoPFhsHHiwDMPHMsuLEDrElTHQBY5AAlSBeZafp5/ZRAGADtB6v0KZCpYCgIvTC2yQP5QbuQE3rnovL6C5XOh0r++jmtnavjVR2VCJbv0fIEsczTbYa7wDKUAUyStqwHCwKsb0pw1o13V65wWYSVeZoRLLTi/4G7dAAzgBMVAD9ir4BACuMjmd9WRGAAAAAElFTkSuQmCC">
    {{-- TODO translatable suffix --}}
    <title>@yield('title') - MUVH</title>
    @include('brackets/admin-ui::admin.partials.main-styles')
    @yield('styles')

</head>

<body class="app">

@yield('content')

@include('brackets/admin-ui::admin.partials.wysiwyg-svgs')
@include('brackets/admin-ui::admin.partials.main-bottom-scripts')
@yield('bottom-scripts')

</body>

</html>
