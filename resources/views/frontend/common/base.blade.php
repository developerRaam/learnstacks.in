<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic Meta Tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

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
        <link rel="icon" href="https://yourwebsite.com/favicon.ico" type="image/x-icon">

        <!-- Alternative Language Versions (if applicable) -->
        <link rel="alternate" hreflang="en" href="https://yourwebsite.com">

        <!-- Article Meta Tags -->
        <meta property="article:published_time" content="@stack('addArticlePublishDate')">
        <meta property="article:modified_time" content="@stack('addArticleModifiedData')">
        <meta property="article:author" content="@stack('addAuthor')">
        <meta property="article:section" content="@stack('addArticleSection')">
        <meta property="article:tag" content="@stack('addArticleTag')"> <!-- Relevant keywords as tags -->

        <!-- Structured Data for Blog Post (SEO Boost) -->
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "@stack('addOgType')",
                "headline": "@stack('addTitle')",
                "author": {
                    "@type": "Person"",
                    "name": "@stack('addAuthor')"
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "@stack('addTitle')",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "https://yourwebsite.com/logo.png"
                    }
                },
                "datePublished": "@stack('addArticlePublishDate')",
                "dateModified": "@stack('addArticleModifiedData')",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "{{ url()->current() }}"
                },
                "image": "@stack('addOgImage')",
                "articleSection": "@stack('addCategory')",
                "keywords": "@stack('addArticleTag')"
            }
        </script>

        <title>@stack('setTitle')</title>

        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/responsive.css') }}">
        
        <!-- Add additional css link -->
        @stack('addStyle')
    </head>
    <body>

        @include('frontend.common.header')

        @yield('content')

        @include('frontend.common.footer')

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Add additional js link -->
        @stack('addScript')

        <script>
            // for tooltip
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    </body>
</html>