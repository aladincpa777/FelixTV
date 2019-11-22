<?php

$whitelistPatterns = array();

$forceCORS = false;

$anonymize = true;

// ################################### *ENCRYPT* ###################################################
// #################################################################################################
function db_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}


// #################################################################################################

/*$startURL = "http://oc4xsad47mv7py5l.onion/";*/
$startURL = "http://mojeip.cz/";

$landingExampleURL = "https://example.net";
/****************************** END CONFIGURATION ******************************/

ob_start("ob_gzhandler");

if (version_compare(PHP_VERSION, "5.4.7", "<")) {
    die("miniProxy requires PHP version 5.4.7 or later.");
}

if (!function_exists("curl_init")) die("miniProxy requires PHP's cURL extension. Please install/enable it on your server and try again.");

function getHostnamePattern($hostname) {
  $escapedHostname = str_replace(".", "\.", $hostname);
  return "@^https?://([a-z0-9-]+\.)*" . $escapedHostname . "@i";
}


function removeKeys(&$assoc, $keys2remove) {
  $keys = array_keys($assoc);
  $map = array();
  $removedKeys = array();
  foreach ($keys as $key) {
    $map[strtolower($key)] = $key;
  }
  foreach ($keys2remove as $key) {
    $key = strtolower($key);
    if (isset($map[$key])) {
      unset($assoc[$map[$key]]);
      $removedKeys[] = $map[$key];
    }
  }
  return $removedKeys;
}

if (!function_exists("getallheaders")) {
  function getallheaders() {
    $result = array();
    foreach($_SERVER as $key => $value) {
      if (substr($key, 0, 5) == "HTTP_") {
        $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
        $result[$key] = $value;
      }
    }
    return $result;
  }
}

$usingDefaultPort =  (!isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"] === 80) || (isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"] === 443);
$prefixPort = $usingDefaultPort ? "" : ":" . $_SERVER["SERVER_PORT"];
$prefixHost = $_SERVER["HTTP_HOST"];
$prefixHost = strpos($prefixHost, ":") ? implode(":", explode(":", $_SERVER["HTTP_HOST"], -1)) : $prefixHost; // Return IP of Hicoria

define("PROXY_PREFIX", "http" . (isset($_SERVER["HTTPS"]) ? "s" : "") . "://" . $prefixHost . $prefixPort . $_SERVER["SCRIPT_NAME"] . "?");
//die(PROXY_PREFIX); // Return full link exept ? => ..
//die($prefixHost);
//$url = db_crypt($url, 'd' );
if (strpos($url, "streamuj.tv")!==false){
 $url = $url + "?pass=USERNAME:::xxXXXxxx";
}
else {
  //die( "ERROR");
}

function makeRequest($url) {

  global $anonymize;


  $user_agent = $_SERVER["HTTP_USER_AGENT"];
  if (empty($user_agent)) {
    $user_agent = "Mozilla/5.0 (compatible; miniProxy)";
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

  $browserRequestHeaders = getallheaders();

  $removedHeaders = removeKeys($browserRequestHeaders, array(
    "Accept-Encoding", 
    "Content-Length",
    "Host",
    "Origin"
  ));

  array_change_key_case($removedHeaders, CASE_LOWER);

  curl_setopt($ch, CURLOPT_ENCODING, "");
  $curlRequestHeaders = array();
  foreach ($browserRequestHeaders as $name => $value) {
    $curlRequestHeaders[] = $name . ": " . $value;
  }
  if (!$anonymize) {
    $curlRequestHeaders[] = "X-Forwarded-For: " . $_SERVER["REMOTE_ADDR"];
  }
  if (array_key_exists('origin', $removedHeaders)) {
    $urlParts = parse_url($url);
    $port = $urlParts['port'];
    $curlRequestHeaders[] = "Origin: " . $urlParts['scheme'] . "://" . $urlParts['host'] . (empty($port) ? "" : ":" . $port);
  };
  curl_setopt($ch, CURLOPT_HTTPHEADER, $curlRequestHeaders);

  //Proxy any received GET/POST/PUT data.
  switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
      curl_setopt($ch, CURLOPT_POST, true);
      $postData = Array();
      parse_str(file_get_contents("php://input"), $postData);
      if (isset($postData["miniProxyFormAction"])) {
        unset($postData["miniProxyFormAction"]);
      }
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    break;
    case "PUT":
      curl_setopt($ch, CURLOPT_PUT, true);
      curl_setopt($ch, CURLOPT_INFILE, fopen("php://input", "r"));
    break;
  }

  //cURL options.
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //Set the request URL.
  curl_setopt($ch, CURLOPT_URL, $url);

  //Make the request.
  $response = curl_exec($ch);
  $responseInfo = curl_getinfo($ch);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  curl_close($ch);

  $responseHeaders = substr($response, 0, $headerSize);
  $responseBody = substr($response, $headerSize);

  return array("headers" => $responseHeaders, "body" => $responseBody, "responseInfo" => $responseInfo);
}


function rel2abs($rel, $base) {
  if (empty($rel)) $rel = ".";
  if (parse_url($rel, PHP_URL_SCHEME) != "" || strpos($rel, "//") === 0) return $rel; 
  if ($rel[0] == "#" || $rel[0] == "?") return $base.$rel; 
  extract(parse_url($base)); 
  $path = isset($path) ? preg_replace("#/[^/]*$#", "", $path) : "/"; 
  if ($rel[0] == "/") $path = ""; 
  $port = isset($port) && $port != 80 ? ":" . $port : "";
  $auth = "";
  if (isset($user)) {
    $auth = $user;
    if (isset($pass)) {
      $auth .= ":" . $pass;
    }
    $auth .= "@";
  }
  $abs = "$auth$host$port$path/$rel"; 
  for ($n = 1; $n > 0; $abs = preg_replace(array("#(/\.?/)#", "#/(?!\.\.)[^/]+/\.\./#"), "/", $abs, -1, $n)) {}
  return $scheme . "://" . $abs; 
}

function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}


function proxifySrcset($srcset, $baseURL) {
  $sources = array_map("trim", explode(",", $srcset)); 
  $proxifiedSources = array_map(function($source) use ($baseURL) {
    $components = array_map("trim", str_split($source, strrpos($source, " "))); 
    $components[0] = PROXY_PREFIX . rel2abs(ltrim($components[0], "/"), $baseURL); 
    return implode($components, " "); 
  }, $sources);
  $proxifiedSrcset = implode(", ", $proxifiedSources); 
  return $proxifiedSrcset;
}

$queryParams = Array();
if (isset($_POST["miniProxyFormAction"])) {
  $url = $_POST["miniProxyFormAction"];
  unset($_POST["miniProxyFormAction"]);
} else {
  
  parse_str($_SERVER["QUERY_STRING"], $queryParams);

  if (isset($queryParams["miniProxyFormAction"])) {
    $formAction = $queryParams["miniProxyFormAction"];
    unset($queryParams["miniProxyFormAction"]);
    $url = $formAction . "?" . http_build_query($queryParams);
  } else {
    //die(get_browser_name($_SERVER['HTTP_USER_AGENT']));
        //if(strpos($_SERVER['HTTP_USER_AGENT'], "Mozilla/6.0") ){//|| strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT 5.1")){
        $url = substr($_SERVER["REQUEST_URI"], strlen($_SERVER["SCRIPT_NAME"]) + 1);
        if (strpos($url, "http://FelixTV.to/")!==false || strpos($url, "streamuj.tv")!==false){
          if($url !== "http://FelixTV.to/"){
            if(strpos($url, "/vystupy5981/") || strpos($url, "jsonsearchapi.php")){
              $url = str_replace("FelixTV.to","tv.sosac.to", $url);
            }
          }
        } elseif (strpos($url, "webshare")!==false || strpos($url, "stream-cinema")!==false || strpos($url, "bbaron")!==false) {
          $url = $url;
        }
        else {
          die("Syntax error{}");
        }
      //} else { die("Syntax error{}"); }
  }
}



if (empty($url)) 

{
    if (empty($startURL)) 
    {
      die("<html><head><title>miniProxy</title></head><body><h1>Welcome to miniProxy!</h1>miniProxy can be directly invoked like this: <a href=\"" . PROXY_PREFIX . $landingExampleURL . "\">" . PROXY_PREFIX . $landingExampleURL . "</a><br /><br />Or, you can simply enter a URL below:<br /><br /><form onsubmit=\"if (document.getElementById('site').value) { window.location.href='" . PROXY_PREFIX . "' + document.getElementById('site').value; return false; } else { window.location.href='" . PROXY_PREFIX . $landingExampleURL . "'; return false; }\" autocomplete=\"off\"><input id=\"site\" type=\"text\" size=\"50\" /><input type=\"submit\" value=\"Proxy It!\" /></form></body></html>");
    } 

    else

      {
      $url = $startURL;
      }
}

 else if (strpos($url, ":/") !== strpos($url, "://")) 

    {
    $pos = strpos($url, ":/");
    $url = substr_replace($url, "://", $pos, strlen(":/"));
    }


// *********** ENCRYPT **************
//if (strpos($url, '.onion') !== false) {
//                echo "Your URL is not Encrypted!";
//       die();
//                    }
//  else 
//   {
//        $url = db_crypt($url, 'd' );
//     }
// **********************************
$scheme = parse_url($url, PHP_URL_SCHEME);

if (empty($scheme)) {
  if (strpos($url, "//") === 0) {
    $url = "http:" . $url;
  }
} else if (!preg_match("/^https?$/i", $scheme)) {
    die('Error: Detected a "' . $scheme . '" URL. miniProxy exclusively supports http[s] URLs.');
}






  if (strpos($url, "atlayo")!==false){
 die( "This url is not allowed");
}
else {
  //die( "ERROR");
}





$urlIsValid = count($whitelistPatterns) === 0;
foreach ($whitelistPatterns as $pattern) {
  if (preg_match($pattern, $url)) {
    $urlIsValid = true;
    break;
  }
}
if (!$urlIsValid) {
  die("Error: The requested URL was disallowed by the server administrator.");
}

$response = makeRequest($url);
$rawResponseHeaders = $response["headers"];
$responseBody = $response["body"];
$responseInfo = $response["responseInfo"];
$responseURL = $responseInfo["url"];
if ($responseURL !== $url) {
  header("Location: " . PROXY_PREFIX . $responseURL, true);
  exit(0);
}

$header_blacklist_pattern = "/^Content-Length|^Transfer-Encoding|^Content-Encoding.*gzip/i";

$responseHeaderBlocks = array_filter(explode("\r\n\r\n", $rawResponseHeaders));
$lastHeaderBlock = end($responseHeaderBlocks);
$headerLines = explode("\r\n", $lastHeaderBlock);
foreach ($headerLines as $header) {
  $header = trim($header);
  if (!preg_match($header_blacklist_pattern, $header)) {
    header($header, false);
  }
}

header("X-Robots-Tag: noindex, nofollow", true);

if ($forceCORS) {
  
  header("Access-Control-Allow-Origin: *", true);
  header("Access-Control-Allow-Credentials: true", true);

  if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"])) {
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS", true);
    }
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"])) {
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}", true);
    }
    exit(0);
  }

}

$contentType = "";
if (isset($responseInfo["content_type"])) $contentType = $responseInfo["content_type"];


if (stripos($contentType, "text/html") !== false) {

  $detectedEncoding = mb_detect_encoding($responseBody, "UTF-8, ISO-8859-1");
  if ($detectedEncoding) {
    $responseBody = mb_convert_encoding($responseBody, "HTML-ENTITIES", $detectedEncoding);
  }

  //Parse the DOM.
  $doc = new DomDocument();
  @$doc->loadHTML($responseBody);
  $xpath = new DOMXPath($doc);

  foreach($xpath->query("//form") as $form) {
    $method = $form->getAttribute("method");
    $action = $form->getAttribute("action");
    $action = empty($action) ? $url : rel2abs($action, $url);
    $form->setAttribute("action", rtrim(PROXY_PREFIX, "?"));
    $actionInput = $doc->createDocumentFragment();
    $actionInput->appendXML('<input type="hidden" name="miniProxyFormAction" value="' . htmlspecialchars($action) . '" />');
    $form->appendChild($actionInput);
  }
  //Proxify <meta> tags with an 'http-equiv="refresh"' attribute.
  foreach ($xpath->query("//meta[@http-equiv]") as $element) {
    if (strcasecmp($element->getAttribute("http-equiv"), "refresh") === 0) {
      $content = $element->getAttribute("content");
      if (!empty($content)) {
        $splitContent = preg_split("/=/", $content);
        if (isset($splitContent[1])) {
          $element->setAttribute("content", $splitContent[0] . "=" . PROXY_PREFIX . rel2abs($splitContent[1], $url));
        }
      }
    }
  }
  //Profixy <style> tags.
  //foreach($xpath->query("//style") as $style) {
  //  $style->nodeValue = proxifyCSS($style->nodeValue, $url);
  //}
  //Proxify tags with a "style" attribute.
  //foreach ($xpath->query("//*[@style]") as $element) {
  //  $element->setAttribute("style", proxifyCSS($element->getAttribute("style"), $url));
 // }
  //Proxify "srcset" attributes in <img> tags.
  foreach ($xpath->query("//img[@srcset]") as $element) {
    $element->setAttribute("srcset", proxifySrcset($element->getAttribute("srcset"), $url));
  }
  //Proxify any of these attributes appearing in any tag.
  $proxifyAttributes = array("href", "src");//, "src");
  foreach($proxifyAttributes as $attrName) {
    foreach($xpath->query("//*[@" . $attrName . "]") as $element) { //For every element with the given attribute...
      $attrContent = $element->getAttribute($attrName);
      if ($attrName == "href" && preg_match("/^(about|javascript|magnet|mailto):/i", $attrContent)) continue;
      $attrContent = rel2abs($attrContent, $url);
      $attrContent = PROXY_PREFIX . $attrContent;
      $element->setAttribute($attrName, $attrContent);
    }
  }


  //$head = $xpath->query("//head")->item(0);
  //$body = $xpath->query("//body")->item(0);
  //$prependElem = $head != NULL ? $head : $body;

  if ($prependElem != NULL) {

    $scriptElem = $doc->createElement("script",
      '(function() {

        if (window.XMLHttpRequest) {

          function parseURI(url) {
            var m = String(url).replace(/^\s+|\s+$/g, "").match(/^([^:\/?#]+:)?(\/\/(?:[^:@]*(?::[^:@]*)?@)?(([^:\/?#]*)(?::(\d*))?))?([^?#]*)(\?[^#]*)?(#[\s\S]*)?/);
            // authority = "//" + user + ":" + pass "@" + hostname + ":" port
            return (m ? {
              href : m[0] || "",
              protocol : m[1] || "",
              authority: m[2] || "",
              host : m[3] || "",
              hostname : m[4] || "",
              port : m[5] || "",
              pathname : m[6] || "",
              search : m[7] || "",
              hash : m[8] || ""
            } : null);
          }

          function rel2abs(base, href) { // RFC 3986

            //function removeDotSegments(input) {
            //  var output = [];
            //  input.replace(/^(\.\.?(\/|$))+/, "")
            //    .replace(/\/(\.(\/|$))+/g, "/")
            //    .replace(/\/\.\.$/, "/../")
            //    .replace(/\/?[^\/]*/g, function (p) {
            //      if (p === "/..") {
            //        output.pop();
            //      } else {
            //        output.push(p);
            //      }
            //    });
            //  return output.join("").replace(/^\//, input.charAt(0) === "/" ? "/" : "");
            }

            href = parseURI(href || "");
            base = parseURI(base || "");

            return !href || !base ? null : (href.protocol || base.protocol) +
            (href.protocol || href.authority ? href.authority : base.authority) +
            removeDotSegments(href.protocol || href.authority || href.pathname.charAt(0) === "/" ? href.pathname : (href.pathname ? ((base.authority && !base.pathname ? "/" : "") + base.pathname.slice(0, base.pathname.lastIndexOf("/") + 1) + href.pathname) : base.pathname)) +
            (href.protocol || href.authority || href.pathname ? href.search : (href.search || base.search)) +
            href.hash;

          }

          var proxied = window.XMLHttpRequest.prototype.open;
          window.XMLHttpRequest.prototype.open = function() {
              if (arguments[1] !== null && arguments[1] !== undefined) {
                var url = arguments[1];
                url = rel2abs("' . $url . '", url);
                url = "' . PROXY_PREFIX . '" + url;
                arguments[1] = url;
              }
              return proxied.apply(this, [].slice.call(arguments));
          };

        }

      })();'
    );
    // $scriptElem->setAttribute("type", "text/javascript");

    // $prependElem->insertBefore($scriptElem, $prependElem->firstChild);

  }

  //echo "<!-- Atlayo TOR Proxy -->\n" . 

  $output = str_replace("<p>","",$doc->saveHTML());
  $output = str_replace("<p>","",$doc->saveHTML());
  $output = str_replace("<p>","",$doc->saveHTML());
  $output = str_replace("</p>","",$doc->saveHTML());
  echo $output;
} else if (stripos($contentType, "text/css") !== false) {
  //echo proxifyCSS($responseBody, $url);
} else { 
  header("Content-Length: " . strlen($responseBody), true);
  echo $responseBody;
}
