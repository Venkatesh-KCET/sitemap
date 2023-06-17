# Sitemap Generator

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/your-username/sitemap)

## Description
The Sitemap Generator Library is a student project implemented as a PHP Composer package. It provides a simple and efficient way to generate sitemaps for websites. This library allows you to create XML sitemaps that search engines can use to discover and index the pages on your website.

## Features
- Easy-to-use API for generating sitemaps
- Support for different types of URLs (e.g., web pages, images, videos, news)
- Automatic handling of sitemap limits (e.g., maximum URLs per sitemap, sitemap index creation)
- Customizable options for configuring the sitemap generation process
- Efficient and scalable for large websites
- Compatible with popular PHP frameworks and content management systems

## Installation
You can install the Sitemap Generator Library using Composer:

```
composer require venkatesh-kcet/sitemap
```

## Usage
Here is a simple example of how to use the Sitemap Generator Library:

### URL Sitemap
```php
<?php
<?php
    include "vendor/autoload.php";
    use VenkateshKcet\Sitemap\Sitemap;
    $sitemap = new Sitemap();
    $array = [
        'loc' => "https://pypi.org/search/?q=sitemap",
    ];
    $sitemap->add_url($array);
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");
```

### Image Sitemap
```
<?php
    include "vendor/autoload.php";
    use VenkateshKcet\Sitemap\Sitemap;
    $sitemap = new Sitemap();
    $array = [
        'loc' => "https://pypi.org/search/?q=sitemap",
        'images' => ["https://pypi.org/search/1.png", "https://pypi.org/search/2.png"]
    ];
    $sitemap->add_url($array);
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");
```

### Video Sitemap
```
<?php
    include "vendor/autoload.php";
    use VenkateshKcet\Sitemap\Sitemap;
    $sitemap = new Sitemap();
    $array = [
        'loc' => "https://pypi.org/search/?q=sitemap",
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
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");
```

### NEWS Sitemap
```
<?php
    include "vendor/autoload.php";
    use VenkateshKcet\Sitemap\Sitemap;
    $sitemap = new Sitemap();
    $array = [
        'loc' => "https://pypi.org/search/?q=sitemap",
        'news' => [
            'publication' => [
                'name' => 'The Example Times',
                'language' => 'en'
            ],
            'publication_date' => '2008-12-23',
            'title' => 'Companies A, B in Merger Talks'
        ]
    ];
    $sitemap->add_url($array);
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");

```

### Combine Sitemap
```
<?php
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
        ],
        'news' => [
            'publication' => [
                'name' => 'The Example Times',
                'language' => 'en'
            ],
            'publication_date' => '2008-12-23',
            'title' => 'Companies A, B in Merger Talks'
        ]
    ];
    $sitemap->add_url($array);
    $sitemap->write_sitemap(__DIR__, 1000);
    $sitemap->write_sitemapIndex($folderPath = __DIR__, $path = "http://localhost/sitemap/");    
```

For more detailed usage instructions and configuration options, please refer to the [documentation](https://github.com/your-username/sitemap/docs).

## License
This project is licensed under the MIT License. See the [LICENSE](https://github.com/your-username/sitemap/LICENSE) file for more information.

## Contributing
Contributions are welcome! If you encounter any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## Examples
Here are a few examples of how you can use the Sitemap Generator Library:

- Generate a sitemap for a simple static website
- Integrate the sitemap generation into a apy web application

## Support
If you need any assistance or have any questions, please [open an issue](https://github.com/your-username/sitemap/issues) on GitHub.

---

Feel free to customize the content and structure of the documentation to best fit your library and its features.
