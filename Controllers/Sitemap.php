<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Rapyd\Model\SitemapSettings;
use Rapyd\Model\CmsBlogPost;
use Rapyd\Model\CmsPage;

class RapydSitemap
{
  /**
   * TODO: NEEDS TO FILTER OUT FILES REQUIRING A PAGE SLUG TO WORK
   */
  protected static function directoryMapper()
  {
    $directory_arr = array();
    $blade_path    = base_path() . '/resources/Public/views/page/';
    $base_files    = glob($blade_path.'*.blade.php');

    $directory_arr = array_merge($directory_arr, $base_files);

    $folders = array_map(function ($dir) {
      return basename($dir);
    }, glob($blade_path.'*', GLOB_ONLYDIR));

    foreach ($folders as $folder) {
      $folder_files = glob($blade_path.$folder.'/*.blade.php');
      $directory_arr = array_merge($directory_arr, $folder_files);
    }

    // CLEARN STRING PATHS
    array_walk($directory_arr, function (&$value, &$key) use ($blade_path) {
      $str = str_replace('.blade.php', '', str_replace($blade_path, '', $value));
      $value = [$str, date("Y-m-d")];
    });

    return $directory_arr;
  }

  protected static function get_all_url_slugs()
  {
    $cms_posts = CmsBlogPost::select('url_slug','updated_at')->where('url_slug','NOT LIKE','%&%')->get();
    $cms_pages = CmsPage::select('url_slug','updated_at')->where('url_slug','NOT LIKE','%&%')->get();

    $url_slug_arr = [];
    foreach ($cms_posts as $post) {
      $url_slug_arr[] = [$post->url_slug, $post->updated_at];
    }

    foreach ($cms_pages as $page) {
      $url_slug_arr[] = [$page->url_slug, $page->updated_at];
    }

    return $url_slug_arr;
  }

  /*
   * NOTE: UNSURE IF SITEMAP SETTINGS AS PREVIOUSLY USED IN SURETYPEDIA WILL STILL OCCUR
   */
  protected static function settingsParser()
  {
    $data_arr   = array();
    $sys_files  = self::directoryMapper();
    $data_arr   = array_merge($data_arr, $sys_files);
    $data_arr   = array_merge($data_arr, self::get_all_url_slugs());
    return self::xmlBuilder($data_arr);
  }

  protected static function xmlBuilder($data_arr)
  {
    $website_domain = request()->root();

    $xml_body = <<<EOT
<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="${website_domain}/main-sitemap.xml"?>

<urlset
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
      http://www.google.com/schemas/sitemap-image/1.1
      http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"
xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
>
EOT;

    foreach ($data_arr as $record) {
      $path_data   = $record[0];
      $record_date = date('c', strtotime($record[1]));

      $xml_body .= <<<EOT
<url>
<loc>${website_domain}/${path_data}</loc>
<lastmod>${record_date}</lastmod>
</url>
EOT;
    }

    $xml_body .= '</urlset>';

    return $xml_body;
  }

  public static function createSitemap()
  {
    $sitemap_content = self::settingsParser();
    $put_file = Storage::disk('local')->put('public/main-sitemap.xml', $sitemap_content);
    return back()->with('success', 'Sitemap Build Succesful');
  }

  // Validate and create module array
  public function make_module()
  {
    $data = request()->validate([
      'path_prefix'   => 'nullable',
      'table_lookup'  => 'required',
      'column_lookup' => 'required'
    ]);

    return $data;
  }

  // Create Module
  public function store()
  {
    SitemapSettings::create($this->make_module());
    return back();
  }

  // Update Module
  public function update($id)
  {
    SitemapSettings::find($id)->update($this->make_module());
    return back();
  }

  public function destroy($id)
  {
    SitemapSettings::find($id)->delete();
    return back();
  }
}
