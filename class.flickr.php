<?php
class Flickr{

  private $flickr_key;
  private $flickr_secret;
  private $format;

  public function __construct($flickr_key, $flickr_secret) {

      $this->flickr_key = $flickr_key;
      $this->flickr_secret = $flickr_secret;
      $this->format = 'json';
  }

public function searchPhotos($query = '', $tags = '', $page, $sort){

$urlencoded_tags = array();
  if(!empty($tags)){    
      $tags_r = explode(',', $tags);
      foreach($tags_r as $tag){
          $urlencoded_tags[] = urlencode($tag);
      }
  }

  //construct the url
  $url  = 'https://api.flickr.com/services/rest/?';
  $url .= 'method=flickr.photos.search';
  $url .= '&text=' . urlencode($query);
  $url .= '&tags=' . implode(',', $urlencoded_tags); //convert the array of url encoded tags back to a string
  $url .= '&sort='.$sort;
  $url .= '&safe_search=1';
  $url .= '&content_type=4';
  $url .= '&api_key=' . $this->flickr_key;
  $url .= '&format=' . $this->format;
  $url .= '&per_page='.$page;
  //get the results
  $opts = array('http' =>
					array(
						'method' => 'GET',
						'ignore_errors' => '1'));

		$context = stream_context_create($opts);
		$stream = fopen($url, 'r', false, $context);

		// actual data at $url
		$result =stream_get_contents($stream);
		fclose($stream);
  #$result = file_get_contents($url);

  //remove the unneccessary strings that wraps the result returned from the API
  $json = substr($result, strlen("jsonFlickrApi("), strlen($result) - strlen("jsonFlickrApi(") - 1);

  $photos = array();
  $data = json_decode($json, true);

  //check if the status didn't fail
  if($data['stat'] != 'fail'){
      //return only the data for the photos as that's the only thing that we need
      $photos = $data['photos']['photo'];
      return $photos;
  }else{
      return false;
  }
}
}
?>
