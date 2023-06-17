<?php 

namespace VenkateshKcet\Sitemap;
use DOMDocument;
use Exception;

class Url {
    public $loc;
    public $lastmod;
    public $changefreq;
    public $priority;
    public $images;
    public $videos;
    public $news;

    public function __construct($loc, $lastmod, $changefreq, $priority, $images, $videos, $news) {

        $loc = strtolower($loc);

        if (empty($loc) || !filter_var($loc, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid URL.");
        }
                
        if ($lastmod != null) {
            if (
                !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$lastmod) &&
                !preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/",$lastmod) &&
                !preg_match("/^[0-9]{4}.(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1])$/",$lastmod)
               ) {
                throw new Exception("Invalid lastmod type. use YYYY-MM-DD.");
            }
        }
        if ($changefreq != null) {
            $changefreq = strtolower($changefreq);
            if (!is_string($changefreq)) {
                throw new Exception("Invalid changefreq type. Must be a string.");
            }
            $validChangefreq = array("always", "hourly", "daily", "weekly", "monthly", "yearly", "never");
            if (!in_array($changefreq, $validChangefreq)) {
                throw new Exception("Invalid changefreq value.");
            }
        }
        if ($priority != null) {
            if (!is_numeric($priority) || !($priority >= 0.0 && $priority <= 1.0)) {
                throw new Exception("Invalid priority value. Must be a numeric value between 0.0 and 1.0.");
            }
        }

        $this->loc = $loc;
        $this->lastmod = $lastmod;
        $this->changefreq = $changefreq;
        $this->priority = $priority;

        if (!empty($images)) {
            $this->images = [];
            foreach($images as $image) {
                if (!filter_var($image, FILTER_VALIDATE_URL)) {
                    throw new Exception("Invalid Image URL.");
                }
                $this->images[] = $image;        
            }
        }

        if(!empty($videos)) {
            $vid_req = ['thumbnail_loc', 'title', 'description', 'content_loc', 'player_loc'];
            foreach($videos as $video) {
                foreach($vid_req as $req) {
                    if (!isset($video[$req])) {
                        throw new Exception($req . " Is Required For The Video Sitemap");
                    }
                }
                if (!filter_var($video["thumbnail_loc"], FILTER_VALIDATE_URL)) {
                    throw new Exception("thumbnail_loc Is invalid For The Video Sitemap");
                }
                $video["title"] = "<![CDATA[" . $video["title"] . "]]>";
                $video["description"] = "<![CDATA[" . $video["description"] . "]]>";
                if (!filter_var($video["content_loc"], FILTER_VALIDATE_URL)) {
                    throw new Exception("content_loc Is invalid For The Video Sitemap");
                }
                if (!filter_var($video["player_loc"], FILTER_VALIDATE_URL)) {
                    throw new Exception("player_loc Is invalid For The Video Sitemap");
                }
                if (!empty($video["duration"])) {
                    if($video["duration"] < 1 || $video["duration"] > 28800) {
                        throw new Exception("The duration of the video, in seconds. Value must be from 1 to 28800 (8 hours).");
                    }
                }
                if (isset($video["expiration_date"])) {
                    $video["expiration_date"] = date_format(date_create($video["expiration_date"]),"c");
                }
                if (isset($video["rating"]) && ($video["rating"] < 0.0 || $video["rating"] > 5.0)) {
                    throw new Exception("The rating of the video. Supported values are float numbers in the range 0.0 (low) to 5.0 (high).");
                }
                if (isset($video["publication_date"])) {
                    $video["publication_date"] = date_format(date_create($video["publication_date"]),"c");
                }
                if (isset($video["family_friendly"])) {
                    if($video["family_friendly"] != "yes" && $video["family_friendly"] != "no") {
                        throw new Exception("Whether the video is available with SafeSearch. If you omit this tag, the video is available when SafeSearch is turned on.");
                    }
                }
                if (isset($video["restriction"])) {
                    if($video["restriction"]["relationship"] != "allow" && $video["restriction"]["relationship"] != "deny") {
                        throw new Exception("Whether the video is allowed or denied in search results in the specified countries. Supported values are: allow, deny");
                    }
                    if (!is_array($video["restriction"]["value"])) {
                        throw new Exception("allows the video search result to be shown only in the specified countries.");
                    }
                    
                    $ISO_3166_1 = ["AF", "AX", "AL", "DZ", "AS", "AD", "AO", "AI", "AQ", "AG", "AR", "AM", "AW", "AU", "AT", "AZ", "BS", "BH", "BD", "BB", "BY", "BE", "BZ", "BJ", "BM", "BT", "BO", "BQ", "BA", "BW", "BV", "BR", "IO", "BN", "BG", "BF", "BI", "CV", "KH", "CM", "CA", "KY", "CF", "TD", "CL", "CN", "CX", "CC", "CO", "KM", "CD", "CG", "CK", "CR", "CI", "HR", "CU", "CW", "CY", "CZ", "DK", "DJ", "DM", "DO", "EC", "EG", "SV", "GQ", "ER", "EE", "SZ", "ET", "FK", "FO", "FJ", "FI", "FR", "GF", "PF", "TF", "GA", "GM", "GE", "DE", "GH", "GI", "GR", "GL", "GD", "GP", "GU", "GT", "GG", "GN", "GW", "GY", "HT", "HM", "VA", "HN", "HK", "HU", "IS", "IN", "ID", "IR", "IQ", "IE", "IM", "IL", "IT", "JM", "JP", "JE", "JO", "KZ", "KE", "KI", "KP", "KR", "KW", "KG", "LA", "LV", "LB", "LS", "LR", "LY", "LI", "LT", "LU", "MO", "MK", "MG", "MW", "MY", "MV", "ML", "MT", "MH", "MQ", "MR", "MU", "YT", "MX", "FM", "MD", "MC", "MN", "ME", "MS", "MA", "MZ", "MM", "NA", "NR", "NP", "NL", "NC", "NZ", "NI", "NE", "NG", "NU", "NF", "MP", "NO", "OM", "PK", "PW", "PS", "PA", "PG", "PY", "PE", "PH", "PN", "PL", "PT", "PR", "QA", "RE", "RO", "RU", "RW", "BL", "SH", "KN", "LC", "MF", "PM", "VC", "WS", "SM", "ST", "SA", "SN", "RS", "SC", "SL", "SG", "SX", "SK", "SI", "SB", "SO", "ZA", "GS", "SS", "ES", "LK", "SD", "SR", "SJ", "SE", "CH", "SY", "TW", "TJ", "TZ", "TH", "TL", "TG", "TK", "TO", "TT", "TN", "TR", "TM", "TC", "TV", "UG", "UA", "AE", "GB", "UM", "US", "UY", "UZ", "VU", "VE", "VN", "VG", "VI", "WF", "EH", "YE", "ZM", "ZW"];
                    
                    foreach($video["restriction"]["value"] as $restriction_country) {
                        if (!in_array($restriction_country, $ISO_3166_1)) {
                            throw new Exception("Only ISO_3166-1 Supported");
                        }    
                    }
                }
                if (isset($video["platform"])) {
                    if($video["platform"]["relationship"] != "allow" && $video["platform"]["relationship"] != "deny") {
                        throw new Exception("specifies whether the video is restricted or permitted for the specified platforms. Supported values are: allow, deny");
                    }
                    if (!is_array($video["platform"]["value"])) {
                        throw new Exception("Whether to show or hide your video in search results on specified platform types");
                    }
                                        
                    foreach($video["platform"]["value"] as $platforms) {
                        if (!in_array($platforms, ["web", "mobile", "tv"])) {
                            throw new Exception("Whether to show or hide your video in search results on specified platform types");
                        }    
                    }
                }
                if (isset($video["requires_subscription"])) {
                    if($video["requires_subscription"] != "yes" && $video["requires_subscription"] != "no") {
                        throw new Exception("Indicates whether a subscription is required to view the video.");
                    }
                }    
                if (isset($video["live"])) {
                    if($video["live"] != "yes" && $video["live"] != "no") {
                        throw new Exception("Indicates whether the video is a live stream.");
                    }
                }
                if(!empty($video["tag"])) {
                    if(count($video["tag"]) > 32) {
                        throw new Exception(" A maximum of 32 tags is permitted.");
                    }
                } 
            }
            $this->videos = $videos;        

        }

    }
}

class Sitemap
{
    public $urls;
    public $imageSitemap;
    public $videoSitemap;
    public $newsSitemap;

    function __construct() {
        $this->imageSitemap = false;
        $this->videoSitemap = false;
        $this->newsSitemap = false;
        $this->urls = [];
    }

    function add_url($array) {
        if (!isset($array['lastmod'])) {
            $array['lastmod'] = null;
        }
        if (!isset($array['changefreq'])) {
            $array['changefreq'] = null;
        }
        if (!isset($array['priority'])) {
            $array['priority'] = null;
        }

        if (!isset($array['images'])) {
            $array['images'] = [];
        } else {
            $this->imageSitemap = true;
        }
        if (!isset($array['videos'])) {
            $array['videos'] = [];
        } else {
            $this->videoSitemap = true;
            
            for($v = 0; $v < count($array['videos']); $v++) {
                $video_parameters = ['duration', 'expiration_date', 'rating', 'view_count', 'publication_date', 'family_friendly', 'restriction', 'platform', 'requires_subscription', 'uploader', 'live', 'tag'];
                foreach($video_parameters as $parameters) {
                    if (!isset($array['videos'][$v][$parameters])) {
                        $array['videos'][$v][$parameters] = null;
                    }
                }
    
            }

        }
        if (!isset($array['news'])) {
            $array['news'] = [];
        } else {
            $this->newsSitemap = true;
        }

        extract($array);

        $this->urls[] = new Url($loc = $loc, $lastmod = $lastmod, $changefreq = $changefreq, $priority = $priority, $images = $images, $videos = $videos, $news = $news);
        print_r($this->urls);
    }
    function write_sitemap($folderPath = "/", $limit = 50000) {
        // Check if the folder exists
        if (!is_dir($folderPath)) {
            // Create the folder
            mkdir($folderPath, 0777, true);
        }

        for($i = 0; $i < intval(count($this->urls)/$limit)+1; $i++) {
            // Create the XML sitemap
            $xml = new DOMDocument('1.0', 'UTF-8');
            $xml->formatOutput = true;

            $urlset = $xml->createElement('urlset');
            $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            if($this->imageSitemap) {
                $urlset->setAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');
            }
            if($this->videoSitemap) {
                $urlset->setAttribute('xmlns:video', 'http://www.google.com/schemas/sitemap-video/1.1');
            }
            $xml->appendChild($urlset);

            for ($j = $i; $j < $i + 50000; $j++) {
                if (!isset($this->urls[$j])) {
                    break;
                }

                $url = $xml->createElement('url');
                foreach ($this->urls[$j] as $tagName => $tagValue) {
                    if(!empty($tagValue)) {
                        if($tagName == "images") {
                            foreach($tagValue as $imageUrl) {
                                // Create <loc> element for image URL
                                $Imageloc = $xml->createElement('loc', $imageUrl);
                                $url->appendChild($Imageloc);
                            
                                // Create <image:image> element with <image:loc> for the image URL
                                $image = $xml->createElement('image:image');
                                $imageLoc = $xml->createElement('image:loc', $imageUrl);
                                $image->appendChild($imageLoc);
                                $url->appendChild($image);
                            }
                        } else if($tagName == "videos") {
                            foreach($tagValue as $video) {
                                $videoData = $xml->createElement('video:video');
                    
                                foreach ($video as $key => $value) {
                                    if($value == null) {

                                    } else if($key == "tag") {
                                        foreach($value as $tag) {
                                            $element = $xml->createElement("video:{$key}", $tag);
                                        }
                                        $videoData->appendChild($element);
                                    } else if (is_array($value)) {
                                        if(is_array($value["value"])) {
                                            $value["value"] = implode(" ", $value["value"]);
                                        }
                                        $element = $xml->createElement("video:{$key}", $value["value"]);
                                        foreach ($value as $key => $value) {
                                            if($key != "value") {
                                                $element->setAttribute($key, $value);
                                            }
                                        }
                                        $videoData->appendChild($element);
                                    } else {
                                        $element = $xml->createElement("video:{$key}", $value);
                                        $videoData->appendChild($element);
                                    }
                                }
                    
                                $url->appendChild($videoData);
                                $urlset->appendChild($url);                    
                            }
                        } else {
                            $element = $xml->createElement($tagName, htmlspecialchars($tagValue));
                            $url->appendChild($element);    
                        }
                    }
                }

                $urlset->appendChild($url);

            }
            // Save the XML sitemap to a file
            $xml->save(rtrim($folderPath, '/') . '/' . 'sitemap' . $i . '.xml');

        }

        echo 'Sitemap generated successfully.';

    }

    function write_sitemapIndex($folderPath = "/", $path = "") {
        // Create a new DOMDocument object
        $doc = new DOMDocument('1.0', 'UTF-8');

        // Create the <sitemapindex> root element
        $sitemapIndex = $doc->createElement('sitemapindex');
        $doc->appendChild($sitemapIndex);
        $files = glob(rtrim($folderPath, '/') . '/' . 'sitemap*');

        foreach ($files as $file) {
            if(basename($file) !== 'sitemap-index.xml') {
                // echo $file . "\n";
                $file = str_replace($folderPath, $path, $file);
                $file = str_replace("//", "/", $file);
                $file = str_replace(":/", "://", $file);
                $sitemap = $doc->createElement('sitemap');
                $loc = $doc->createElement('loc', $file);
    
                $sitemap->appendChild($loc);
                $sitemapIndex->appendChild($sitemap);
    
            }
        }

        // Set the XML header
        $doc->xmlStandalone = false;
        $doc->formatOutput = true;

        // Save the XML as a file
        $doc->save(rtrim($folderPath, '/') . '/'. 'sitemap-index.xml');
    }
}