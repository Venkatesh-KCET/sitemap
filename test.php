<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    include "vendor/autoload.php";
    use VenkateshKcet\Sitemap\Sitemap;
    $sitemap = new Sitemap();
    $array = [
        'loc' => "https://pypi.org/search/?q=sitemap",
        'images' => ["https://pypi.org/search/1.png", "https://pypi.org/search/2.png"],
        'videos' => [
            0 => [
                "thumbnail_loc" => "https://www.example.com/thumbs/123.jpg",
                "title" => "Grilling steaks for summer",
                "description" => "Alkis shows you how to get perfectly done steaks every time",
                "content_loc" => "http://streamserver.example.com/video123.mp4",
                "player_loc" => "https://www.example.com/videoplayer.php?video=123",
                "duration" => 600,
                "expiration_date" => "2021-11-05T19:20:30+08:00",
                "rating" => 4.2,
                "view_count" => 12345,
                "publication_date" => "2007-11-05T19:20:30+08:00",
                "family_friendly" => "yes",
                "restriction" => [
                    "relationship" => "allow",
                    "value" => ["IE", "GB", "US", "CA"]
                ],
                "platform" => [
                    "relationship" => "allow",
                    "value" => ["web", "tv"]
                ],
                "price" => [
                    "currency" => "EUR",
                    "value" => 1.99
                ],
                "requires_subscription" => "yes",
                "uploader" => [
                    "info" => "https://www.example.com/users/grillymcgrillerson",
                    "value" => "GrillyMcGrillerson"
                ],
                "live" => "no",
                "tag" => ["steak", "meat", "summer", "outdoor"]
            ],
            1 => [
                "thumbnail_loc" => "https://www.example.com/thumbs/123.jpg",
                "title" => "Grilling steaks for summer",
                "description" => "Alkis shows you how to get perfectly done steaks every time",
                "content_loc" => "http://streamserver.example.com/video123.mp4",
                "player_loc" => "https://www.example.com/videoplayer.php?video=123"
            ]
        ]
    ];
    $sitemap->add_url($array);
    // for($i = 0; $i < 10000; $i++) {
    //     $a = $sitemap->add_url($loc = $i.".com", $lastmod = "2020/02/02", $changefreq = "never", $priority = 1.0);
    // }
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");
    // phpinfo();