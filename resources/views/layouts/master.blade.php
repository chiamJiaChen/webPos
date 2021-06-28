<!DOCTYPE html>
<html lang="en">
<head>

    @include('layouts.header')

    @yield('css')

</head>
<body>
    
    @include('layouts.error')
    
    @yield('content')
    
    @include('layouts.script')
    
    @yield('script')
    
</body>
</html>