<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') | {{config('app.name')}}</title>

  @include('admin.include.styles')
</head>

<body>

  <!-- Wrapper-->
  <div id="wrapper">

    <!-- Navigation -->
    @include('admin.include.navigation')

    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

      <!-- Page wrapper -->
      @include('admin.include.topnavbar')

      <!-- Main view  -->
      @yield('content')

      <!-- Footer -->
      @include('admin.include.footer')

    </div>
    <!-- End page wrapper-->

  </div>
  <!-- End wrapper-->

  @include('admin.include.scripts')

</body>

</html>