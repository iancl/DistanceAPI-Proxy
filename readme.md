# Distance API Proxy

I created this so you can use it on your server and get data from the google api without having to do a crossdomain request from your client.


Version
-----------

1.0



How to use:
--------------

Just make an ajax call to the service and pass the necessary params:

```javascript

GET Request Params structure

// urlEnconded
origins=1.23,-0.98&destinations=4.123,9.093&mode=driving&language=en&type=json&apiKey=12345

// definition
origins = lat,long; REQUIRED
destinations = lat,long; REQUIRED
mode = driving|walking|bicycling; REQUIRED
language = es|en|fr; REQUIRED
apiKey = google api Key; OPTIONAL
type = json|xml; OPTIONAL, DEFAULT is json

```

---

License
----

Created By Ian Calderon.

&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;