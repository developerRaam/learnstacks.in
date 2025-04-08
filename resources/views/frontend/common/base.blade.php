<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic Meta Tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- SEO Meta Tags -->
        <meta name="title" content="@stack('addTitle')">
        <meta name="description" content="@stack('addDescription')">
        <meta name="keywords" content="@stack('addKeywords')">
        <meta name="author" content="@stack('addAuthor')">
        <meta name="robots" content="@stack('addRobots')">
        <meta name="googlebot" content="@stack('addGooglebot')">

        <!-- Open Graph (OG) Meta Tags for Social Media -->
        <meta property="og:title" content="@stack('addOgTitle')">
        <meta property="og:description" content="@stack('addOgDescription')">
        <meta property="og:image" content="@stack('addOgImage')">
        <meta property="og:url" content="@stack('addOgUrl')">
        <meta property="og:type" content="@stack('addOgType')">
        <meta property="og:site_name" content="@stack('addOgSiteName')">

        <!-- Canonical Tag (Avoid Duplicate Content) -->
        <link rel="canonical" href="@stack('addCanonical')">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/x-icon">

        <!-- Alternative Language Versions (if applicable) -->
        <link rel="alternate" hreflang="en" href="https://learnstacks.in">

        <!-- Article Meta Tags -->
        @if(!empty(trim($__env->yieldPushContent('addArticlePublishDate'))))
            <meta property="article:published_time" content="@stack('addArticlePublishDate')">
        @endif
        @if(!empty(trim($__env->yieldPushContent('addArticleModifiedData'))))
            <meta property="article:modified_time" content="@stack('addArticleModifiedData')">
        @endif
        @if(!empty(trim($__env->yieldPushContent('addAuthor'))))
            <meta property="article:author" content="@stack('addAuthor')">
        @endif
        @if(!empty(trim($__env->yieldPushContent('addArticleSection'))))
            <meta property="article:section" content="@stack('addArticleSection')">
        @endif
        @if(!empty(trim($__env->yieldPushContent('addArticleTag'))))
            <meta property="article:tag" content="@stack('addArticleTag')">
        @endif
    
        <title>@stack('setTitle') | {{ app('settings')['site_name'] }}</title>

        <meta name="google-site-verification" content="j9OPEVywxg8w5HXlOCid6gOuVj3H-doTlGxLLdFbgLc" />
        
        <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/responsive.css') }}">

        <!-- Sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4JKMES7FP"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-D4JKMES7FP');
        </script>
        
        <!-- Add additional css link -->
        @stack('addStyle')
    </head>
    <body>

        @include('frontend.common.header')

        @yield('content')

        @include('frontend.common.footer')

        <!-- Sweet alert -->
        <script src="{{ URL::asset('frontend/js/sweet-alert.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        
        <!-- Add additional js link -->
        @stack('addScript')
    </body>
</html>