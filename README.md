TraceNow-Tracking
=================
I've tested the tracking function on its own in a separate php file. It returns the correct details for the consignment number and member guid used. The return is all the tracking details include datetime stamp, address, contact, parcel details and image of the signature.
Using the plugin the only return I get is is the full xml array, however the plugin fails to send the consignment number with the post request so it only returns code 500.
Obviously at the moment theres no installer so the plugin needs to be copied to the plugins folder manually.
It will work on a page by adding the shortcode [tn_ajax_frontend].
Tracking number to use is: lc0614061377
If someone could have a look and point me in the right direction it would be gratefully appreciated.

Many thanks

Richard
