<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .php-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var baseUrl = "http://localhost:8080";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-3.27.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-3.27.0.js") }}"></script>

</head>

<body data-languages="[&quot;php&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                                                                            <ul id="tocify-header-0" class="tocify-header">
                    <li class="tocify-item level-1" data-unique="introduction">
                        <a href="#introduction">Introduction</a>
                    </li>
                                            
                                                                    </ul>
                                                <ul id="tocify-header-1" class="tocify-header">
                    <li class="tocify-item level-1" data-unique="authenticating-requests">
                        <a href="#authenticating-requests">Authenticating requests</a>
                    </li>
                                            
                                                </ul>
                    
                    <ul id="tocify-header-2" class="tocify-header">
                <li class="tocify-item level-1" data-unique="transactions">
                    <a href="#transactions">Transactions</a>
                </li>
                                    <ul id="tocify-subheader-transactions" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="transactions-POSTapi-v1-transactions">
                        <a href="#transactions-POSTapi-v1-transactions">POST api/v1/transactions</a>
                    </li>
                                                    </ul>
                            </ul>
                    <ul id="tocify-header-3" class="tocify-header">
                <li class="tocify-item level-1" data-unique="users">
                    <a href="#users">Users</a>
                </li>
                                    <ul id="tocify-subheader-users" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="users-POSTapi-v1-users">
                        <a href="#users-POSTapi-v1-users">POST api/v1/users</a>
                    </li>
                                                    </ul>
                            </ul>
        
                        
            </div>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
        <ul class="toc-footer" id="last-updated">
        <li>Last updated: May 12 2022</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Aplicação back-end de transações financeiras utilizando Laravel 9</p>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://localhost:8080</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="transactions">Transactions</h1>

    

            <h2 id="transactions-POSTapi-v1-transactions">POST api/v1/transactions</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-transactions">
<blockquote>Example request:</blockquote>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost:8080/api/v1/transactions',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'payer' =&gt; 7209235.8555215,
            'payee' =&gt; 691.2127692,
            'value' =&gt; 4078332.2521685343,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/transactions"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "payer": 7209235.8555215,
    "payee": 691.2127692,
    "value": 4078332.2521685343
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-transactions">
</span>
<span id="execution-results-POSTapi-v1-transactions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-transactions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-transactions"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-transactions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-transactions"></code></pre>
</span>
<form id="form-POSTapi-v1-transactions" data-method="POST"
      data-path="api/v1/transactions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-transactions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-transactions"
                    onclick="tryItOut('POSTapi-v1-transactions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-transactions"
                    onclick="cancelTryOut('POSTapi-v1-transactions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-transactions" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/transactions</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>payer</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
                <input type="number"
               name="payer"
               data-endpoint="POSTapi-v1-transactions"
               value="7209235.8555215"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>payee</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
                <input type="number"
               name="payee"
               data-endpoint="POSTapi-v1-transactions"
               value="691.2127692"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>value</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
                <input type="number"
               name="value"
               data-endpoint="POSTapi-v1-transactions"
               value="4078332.2521685"
               data-component="body" hidden>
    <br>

        </p>
        </form>

        <h1 id="users">Users</h1>

    

            <h2 id="users-POSTapi-v1-users">POST api/v1/users</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-users">
<blockquote>Example request:</blockquote>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost:8080/api/v1/users',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'npityrxpblvqpowqhmobxrqesdsxfpnjuerqexnthmuzvmlhyahajrhnnkrtkailxnlhiqqcnifpydnmcacinjawupsksxudkrzuedaimxn',
            'fantasy_name' =&gt; 'xnurbbpbprrpxxfhviurawjoftbglfnmlweiuvqaxtrozfubpdoxgkbvzxblexsyrktponwmarzgqynmbehvvfquwrvbjfprjajrxzvlmiunrvdggcrrzckatlkymekvleytdzyculiemeilotjnseyjeyktzrjnmpexlhdjbwikqcjankupmvqoswuwdhibiciczhqrzqpqbjtgjmlrnzsr',
            'type' =&gt; 1,
            'register' =&gt; 'dj',
            'email' =&gt; 'repellat',
            'password' =&gt; 'dgslcz',
            'balance' =&gt; 1.66541579,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "npityrxpblvqpowqhmobxrqesdsxfpnjuerqexnthmuzvmlhyahajrhnnkrtkailxnlhiqqcnifpydnmcacinjawupsksxudkrzuedaimxn",
    "fantasy_name": "xnurbbpbprrpxxfhviurawjoftbglfnmlweiuvqaxtrozfubpdoxgkbvzxblexsyrktponwmarzgqynmbehvvfquwrvbjfprjajrxzvlmiunrvdggcrrzckatlkymekvleytdzyculiemeilotjnseyjeyktzrjnmpexlhdjbwikqcjankupmvqoswuwdhibiciczhqrzqpqbjtgjmlrnzsr",
    "type": 1,
    "register": "dj",
    "email": "repellat",
    "password": "dgslcz",
    "balance": 1.66541579
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-users">
</span>
<span id="execution-results-POSTapi-v1-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-users"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-users"></code></pre>
</span>
<form id="form-POSTapi-v1-users" data-method="POST"
      data-path="api/v1/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-users"
                    onclick="tryItOut('POSTapi-v1-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-users"
                    onclick="cancelTryOut('POSTapi-v1-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-users" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/users</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-v1-users"
               value="npityrxpblvqpowqhmobxrqesdsxfpnjuerqexnthmuzvmlhyahajrhnnkrtkailxnlhiqqcnifpydnmcacinjawupsksxudkrzuedaimxn"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>fantasy_name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="fantasy_name"
               data-endpoint="POSTapi-v1-users"
               value="xnurbbpbprrpxxfhviurawjoftbglfnmlweiuvqaxtrozfubpdoxgkbvzxblexsyrktponwmarzgqynmbehvvfquwrvbjfprjajrxzvlmiunrvdggcrrzckatlkymekvleytdzyculiemeilotjnseyjeyktzrjnmpexlhdjbwikqcjankupmvqoswuwdhibiciczhqrzqpqbjtgjmlrnzsr"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>type</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
                <input type="number"
               name="type"
               data-endpoint="POSTapi-v1-users"
               value="1"
               data-component="body" hidden>
    <br>
<p>Must be between 1 and 2.</p>
        </p>
                <p>
            <b><code>register</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="register"
               data-endpoint="POSTapi-v1-users"
               value="dj"
               data-component="body" hidden>
    <br>
<p>Must be at least 11 characters.</p>
        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-v1-users"
               value="repellat"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="password"
               data-endpoint="POSTapi-v1-users"
               value="dgslcz"
               data-component="body" hidden>
    <br>
<p>Must be at least 6 characters.</p>
        </p>
                <p>
            <b><code>balance</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
                <input type="number"
               name="balance"
               data-endpoint="POSTapi-v1-users"
               value="1.66541579"
               data-component="body" hidden>
    <br>

        </p>
        </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
