<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($courses as $course)
        <url>
            <loc>{{ url('course/course-detail/'.$course->slug) }}</loc>
            <lastmod>{{ $course->created_at->tz('UTC +6')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($services as $service)
        <url>
            <loc>{{ url('web-post/web-post-detail/'.$service->slug) }}</loc>
            <lastmod>{{ $service->created_at->tz('UTC +6')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($blogs as $blog)
        <url>
            <loc>{{ url('service/service-detail/'.$blog->slug) }}</loc>
            <lastmod>{{ $blog->created_at->tz('UTC +6')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset> 