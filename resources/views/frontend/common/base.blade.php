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
        <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/x-icon">

        <!-- Alternative Language Versions (if applicable) -->
        <link rel="alternate" hreflang="en" href="https://learnstacks.in">

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
                "@type": "BlogPosting",
                "headline": "@stack('addTitle')",
                "description": "@stack('addDescription')",
                "author": {
                    "@type": "Person",
                    "name": "Learn Stacks"
                },
                "datePublished": "@stack('addArticlePublishDate')",
                "dateModified": "@stack('addArticlePublishDate')",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "@stack('addCanonical')"
                },
                "image": "@stack('addOgImage')",
                "publisher": {
                    "@type": "Organization",
                    "name": "Learn Stacks",
                    "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('logo.jpg') }}"
                    }
                }
            }
        </script>
    
        <title>@stack('setTitle') | {{ app('settings')['site_name'] }}</title>

        <meta name="google-site-verification" content="j9OPEVywxg8w5HXlOCid6gOuVj3H-doTlGxLLdFbgLc" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/responsive.css') }}">

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