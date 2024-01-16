<?php 



// if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) && $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] === 'https') {
//     $_SERVER['HTTPS'] = 'on';
// }



print_r("---------------------------------------------------------");
print_r($_SERVER['HTTPS']);
print_r("---------------------------------------------------------");
print_r($_SERVER);
print_r("---------------------------------------------------------");




#### direto do ip do cdn buscando via https
Array
(
    [SCRIPT_URL] =&gt; /cdn1.php
    [SCRIPT_URI] =&gt; http://fraseteca.com.br/cdn1.php
    [HTTP_HOST] =&gt; fraseteca.com.br
    [HTTP_CONNECTION] =&gt; Keep-Alive
    [HTTP_ACCEPT_ENCODING] =&gt; gzip, br
    [HTTP_X_FORWARDED_FOR] =&gt; 2804:7c0:10b0:bbd0:9e9d:8664:1965:6db3
    [HTTP_CF_RAY] =&gt; 81677f639e381774-EWR
    [HTTP_X_FORWARDED_PROTO] =&gt; https
    [HTTP_CF_VISITOR] =&gt; {"scheme":"https"}
    [HTTP_PRAGMA] =&gt; no-cache
    [HTTP_CACHE_CONTROL] =&gt; no-cache
    [HTTP_SEC_CH_UA] =&gt; "Google Chrome";v="117", "Not;A=Brand";v="8", "Chromium";v="117"
    [HTTP_SEC_CH_UA_MOBILE] =&gt; ?0
    [HTTP_SEC_CH_UA_PLATFORM] =&gt; "Linux"
    [HTTP_UPGRADE_INSECURE_REQUESTS] =&gt; 1
    [HTTP_USER_AGENT] =&gt; Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36
    [HTTP_ACCEPT] =&gt; text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
    [HTTP_SEC_FETCH_SITE] =&gt; none
    [HTTP_SEC_FETCH_MODE] =&gt; navigate
    [HTTP_SEC_FETCH_USER] =&gt; ?1
    [HTTP_SEC_FETCH_DEST] =&gt; document
    [HTTP_ACCEPT_LANGUAGE] =&gt; en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7
    [HTTP_COOKIE] =&gt; _ga=GA1.1.603720797.1652278061; __gads=ID=b2d7d0ae6a890956-22b73ef231e30069:T=1697033416:RT=1697275476:S=ALNI_MYxNxqU3nUWUp1COEbVf0zZ9Y_okw; __gpi=UID=00000a17d23a7b99:T=1697033416:RT=1697275476:S=ALNI_MZWyl-FSabZWMjRzzeE7XqKAbkgHA; _ga_V66X552YG6=GS1.1.1697278097.12.0.1697278097.0.0.0
    [HTTP_CDN_LOOP] =&gt; cloudflare
    [HTTP_CF_CONNECTING_IP] =&gt; 2804:7c0:10b0:bbd0:9e9d:8664:1965:6db3
    [HTTP_CF_IPCOUNTRY] =&gt; BR
    [PATH] =&gt; /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin
    [SERVER_SIGNATURE] =&gt; 


    <text>Array
(
    [SCRIPT_URL] =&gt; /cdn1.php
    [SCRIPT_URI] =&gt; http://fraseteca.com.br/cdn1.php
    [HTTP_HOST] =&gt; fraseteca.com.br
    [HTTP_CONNECTION] =&gt; Keep-Alive
    [HTTP_ACCEPT_ENCODING] =&gt; gzip, br
    [HTTP_X_FORWARDED_FOR] =&gt; 2804:7c0:10b0:bbd0:9e9d:8664:1965:6db3
    [HTTP_CF_RAY] =&gt; 816783ca98e81774-EWR
    [HTTP_X_FORWARDED_PROTO] =&gt; https
    [HTTP_CF_VISITOR] =&gt; {"scheme":"https"}
    [HTTP_PRAGMA] =&gt; no-cache
    [HTTP_CACHE_CONTROL] =&gt; no-cache
    [HTTP_UPGRADE_INSECURE_REQUESTS] =&gt; 1
    [HTTP_USER_AGENT] =&gt; Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36
    [HTTP_ACCEPT] =&gt; text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
    [HTTP_SEC_FETCH_SITE] =&gt; none
    [HTTP_SEC_FETCH_MODE] =&gt; navigate
    [HTTP_SEC_FETCH_USER] =&gt; ?1
    [HTTP_SEC_FETCH_DEST] =&gt; document
    [HTTP_SEC_CH_UA] =&gt; "Google Chrome";v="117", "Not;A=Brand";v="8", "Chromium";v="117"
    [HTTP_SEC_CH_UA_MOBILE] =&gt; ?0
    [HTTP_SEC_CH_UA_PLATFORM] =&gt; "Linux"
    [HTTP_ACCEPT_LANGUAGE] =&gt; en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7
    [HTTP_COOKIE] =&gt; _ga=GA1.1.603720797.1652278061; __gads=ID=b2d7d0ae6a890956-22b73ef231e30069:T=1697033416:RT=1697275476:S=ALNI_MYxNxqU3nUWUp1COEbVf0zZ9Y_okw; __gpi=UID=00000a17d23a7b99:T=1697033416:RT=1697275476:S=ALNI_MZWyl-FSabZWMjRzzeE7XqKAbkgHA; _ga_V66X552YG6=GS1.1.1697278097.12.0.1697278097.0.0.0; XSRF-TOKEN=eyJpdiI6InFlUjlFaDV2d050ZElKTStEdXVnYkE9PSIsInZhbHVlIjoiUmd5U0liTGEwcnRaODVUL2VKOTd4SGVwQU80UmZMTmtJZHc4V2Iza1c2cGpRWkxLQ29TK3QxMnorSmFKV2pCb2tjOTF0QUdyVFh0b2xhUGlWSWRzeEFVM0RJK1FqSFlxS1FTV2tkcElSUlU0RDBNWXNWeFRvZ0xSd3pQS3ZGRysiLCJtYWMiOiIwM2ZkZjExZjAwMzVhMzg1YmQ4YmUyYmY3N2NiZGExN2EyYTQzMDc1YTczMGRlYjU1YmQ5MjkxNmY2MGRmMTkyIiwidGFnIjoiIn0%3D; fraseteca_session=eyJpdiI6Im1NVDEzMWdKZEI1YVREdzFIc1pUYlE9PSIsInZhbHVlIjoidjVuK2U2ZkcxVjRUZ3p2U0RIRXY5bDhhUk82L2xQeVI2RlB1NGpEbUxDeWtjc21WVUNDbjFWY2dwU0ZCbWRCdHpORzhvSFBtOGJ5YzZnZ3lpRlhuZEFJRUFyckFqdTIwa243SWxEaTd5azU4bW54VVJhenJ2aDhrelJJTnBidG4iLCJtYWMiOiI5NjczYzdmNGVmN2QxNTM0ZmZmNzk1MGUxOTdlODM5MTFjOGNlNDU0MmQ5MzEzM2I0ZDBmODhmOTY1OWUwZTgxIiwidGFnIjoiIn0%3D
    [HTTP_CDN_LOOP] =&gt; cloudflare
    [HTTP_CF_CONNECTING_IP] =&gt; 2804:7c0:10b0:bbd0:9e9d:8664:1965:6db3
    [HTTP_CF_IPCOUNTRY] =&gt; BR
    [PATH] =&gt; /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin
    [SERVER_SIGNATURE] =&gt; </text>

http://[2804:7c0:10b0:bbd0:9e9d:8664:1965:6db3]/cdn1.php

# Acessando via ipv6 
http://[2600:1f18:19b3:ab00:475:fafd:507f:e68a]/cdn1.php

<text>Array
(
    [SCRIPT_URL] =&gt; /cdn1.php
    [SCRIPT_URI] =&gt; http://[2600:1f18:19b3:ab00:475:fafd:507f:e68a]/cdn1.php
    [HTTP_HOST] =&gt; [2600:1f18:19b3:ab00:475:fafd:507f:e68a]
    [HTTP_CONNECTION] =&gt; keep-alive
    [HTTP_PRAGMA] =&gt; no-cache
    [HTTP_CACHE_CONTROL] =&gt; no-cache
    [HTTP_UPGRADE_INSECURE_REQUESTS] =&gt; 1
    [HTTP_USER_AGENT] =&gt; Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36
    [HTTP_ACCEPT] =&gt; text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
    [HTTP_ACCEPT_ENCODING] =&gt; gzip, deflate
    [HTTP_ACCEPT_LANGUAGE] =&gt; en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7
    [PATH] =&gt; /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin
    [SERVER_SIGNATURE] =&gt; </text>


?>






